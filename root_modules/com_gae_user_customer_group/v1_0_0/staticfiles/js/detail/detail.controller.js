(function() {
  'use strict';

  angular
      .module('customerGroup')
      .controller('DetailController', DetailController);

  function DetailController($scope, $window) {
    var id = getUrlParameter('id');
    $scope.group = [];
    $scope.customers = [];
    $scope.total = 0;
    $scope.limit = 10;
    $scope.selectedDeleteId = [];
    $scope.deleteAll = false;
    $scope.onClickBulkDeleteAll = onClickBulkDeleteAll;
    $scope.onChangeLimit = function (limitList) {
      $scope.limit = limitList || 10;
    };
    $scope.deleteSelected = function (id) {
      return $scope.selectedDeleteId.indexOf(id) > -1;
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

    var dataSend = {
      "id": id
    };
    CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
      $scope.$apply(function () {
        $scope.group = res.data;
        $scope.customers = res.data.customers;
        $scope.total = res.data.customers.length;
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
          "id": id,
          "customerIds": $scope.selectedDeleteId
        };
        CUR_MODULE.apiPost('start/bulk_delete_customer', dataSend).then(function (res) {
          if (res.ok) {
            $window.location.href = CUR_MODULE.data.app_url + 'start/detail?id=' + id;
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
  }

})();