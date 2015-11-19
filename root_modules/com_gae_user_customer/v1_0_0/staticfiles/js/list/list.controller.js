angular.module('customer').controller('listdata', function ($scope) {
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
  // sort
  $scope.sort = function (keyname) {
    if (keyname == 'order' || keyname == 'pay') {
      return false;
    }
    $scope.sortKey = keyname || 'create_time';   //set the sortKey to the param passed
    $scope.reverse = true;
  }
});