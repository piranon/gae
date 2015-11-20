angular.module('customer').controller('listdata', function ($scope, $window) {
  $scope.customers = [];
  $scope.total = 0;
  $scope.limit = 10;
  CUR_MODULE.apiGet("start/listing").then(function (res) {
    $scope.$apply(function () {
      $scope.customers = res.data;
      $scope.total = res.data.length
    });
  });
  $scope.changeLimit = function (limitList) {
    $scope.limit = limitList || 10;
  };
  $scope.sort = function (keyname) {
    if (keyname == 'order' || keyname == 'pay') {
      return false;
    }
    $scope.sortKey = keyname || 'create_time';   //set the sortKey to the param passed
    $scope.reverse = true;
  }
  $scope.clickOnDelete = function(id) {
    var dataSend = {
      "id": id || ''
    }
    CUR_MODULE.apiPost('start/delete', dataSend).then(function (res) {
      if (res.ok) {
        $window.location.href = CUR_MODULE.data.app_url + 'start';
      } else {
        alert("Error: Can not delete customer");
      }
    });
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