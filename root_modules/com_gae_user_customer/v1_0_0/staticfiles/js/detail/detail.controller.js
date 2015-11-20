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
function getUrlParameter(param, dummyPath) {
  var sPageURL = dummyPath || window.location.search.substring(1),
      sURLVariables = sPageURL.split(/[&||?]/),
      res;

  for (var i = 0; i < sURLVariables.length; i += 1) {
    var paramName = sURLVariables[i],
        sParameterName = (paramName || '').split('=');

    if (sParameterName[0] === param) {
      res = sParameterName[1];
    }
  }

  return res;
}