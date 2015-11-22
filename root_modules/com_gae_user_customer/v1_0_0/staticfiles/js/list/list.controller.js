angular.module('customer').controller('ListController', function ($scope, $window) {
  $scope.customers = [];
  $scope.total = 0;
  $scope.limit = 10;
  $scope.selectedDeleteId = [];
  $scope.deleteAll = false;
  $scope.onClickBulkDeleteAll = onClickBulkDeleteAll;
  $scope.onChangeLimit = function (limitList) {
    $scope.limit = limitList || 10;
  };
  $scope.onChangeBulkDelete = function (action) {
    onChangeBulkDelete(action);
  };
  $scope.onClickSort = function (keyname) {
    onClickSort(keyname);
  };
  $scope.onClickBulkDelete = function (id) {
    onClickBulkDelete(id);
  };
  $scope.deleteSelected = function (id) {
    return $scope.selectedDeleteId.indexOf(id) > -1;
  };

  CUR_MODULE.apiGet("start/listing").then(function (res) {
    $scope.$apply(function () {
      $scope.customers = res.data;
      $scope.total = res.data.length;
    });
  });

  function onChangeBulkDelete(action) {
    if (action != 1) {
      return false;
    }
    if ($scope.selectedDeleteId.length === 0) {
      alert('Please select some customer');
    } else {
      var dataSend = {
        "ids": $scope.selectedDeleteId
      };
      CUR_MODULE.apiPost('start/bulk_delete', dataSend).then(function (res) {
        if (res.ok) {
          $window.location.href = CUR_MODULE.data.app_url + 'start';
        } else {
          alert("Error: Can not delete customer");
        }
      });
    }
  }

  function onClickSort(keyname) {
    $scope.sortKey = keyname || 'create_time';
    if ($scope.reverse) {
      $scope.reverse = false;
    } else {
      $scope.reverse = true;
    }
  }

  function onClickBulkDeleteAll() {
    if ($scope.deleteAll) {
      $scope.deleteAll = false;
      $scope.selectedDeleteId = [];
    } else {
      $scope.deleteAll = true;
      $scope.selectedDeleteId = [];
      angular.forEach($scope.customers, function (value, key) {
        $scope.selectedDeleteId.push(value.customer_id);
      });
    }
  }

  function onClickBulkDelete(id) {
    if ($scope.selectedDeleteId.indexOf(id) > -1) {
      $scope.selectedDeleteId.splice($scope.selectedDeleteId.indexOf(id), 1);
    } else {
      $scope.selectedDeleteId.push(id);
    }
  }
});