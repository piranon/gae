angular.module('customer').controller('DetailController', function ($scope) {
  var dataSend = {
    "id":getUrlParameter('id')
  };
  CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
    $scope.$apply(function () {
      $scope.customer = res.data;
    });
  });
});