angular.module('customer').controller('listdata', function ($scope, $window, $attrs) {
  $scope.customers = [];
  $scope.total = 0;
  $scope.limit = 10;
  $scope.selectedDeleteId = [];
  $scope.deleteAll = false;
  CUR_MODULE.apiGet("start/listing").then(function (res) {
    $scope.$apply(function () {
      $scope.customers = res.data;
      $scope.total = res.data.length;
    });
  });
  $scope.onChangeLimit = function (limitList) {
    $scope.limit = limitList || 10;
  };
  $scope.onChangeBulkDelete = function (action) {
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
  };
  $scope.onClickSort = function (keyname) {
    $scope.sortKey = keyname || 'create_time';
    if ($scope.reverse) {
      $scope.reverse = false;
    } else {
      $scope.reverse = true;
    }
  };
  $scope.onClickBulkDeleteAll = function(){
    if ($scope.deleteAll) {
      $scope.deleteAll = false;
      $scope.selectedDeleteId = [];
    } else {
      $scope.deleteAll = true;
      $scope.selectedDeleteId = [];
      angular.forEach($scope.customers, function(value, key) {
        $scope.selectedDeleteId.push(value.customer_id);
      });

    }
  };
  $scope.onClickBulkDelete = function(id){
    if ($scope.selectedDeleteId.indexOf(id) > -1) {
      $scope.selectedDeleteId.splice( $scope.selectedDeleteId.indexOf(id), 1 );
    } else {
      $scope.selectedDeleteId.push(id);
    }
    console.log($scope.selectedDeleteId);
  };
  $scope.deleteSelected =  function(id){
    return $scope.selectedDeleteId.indexOf(id) > -1;
  }
});
angular.module('customer').directive('ngConfirmClick', [
  function () {
    return {
      link: function (scope, element, attr) {
        var msg = attr.ngConfirmClick || "Are you sure?";
        var clickAction = attr.confirmedClick;
        element.bind('click', function (event) {
          if (window.confirm(msg)) {
            scope.$eval(clickAction)
          }
        });
      }
    };
  }]);