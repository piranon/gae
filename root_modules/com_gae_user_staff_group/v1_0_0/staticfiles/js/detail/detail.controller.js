(function() {
  'use strict';

  angular
      .module('staff')
      .controller('DetailController', DetailController);

  function DetailController($scope) {
    var vm = this;
    var dataSend = {
      "id":getUrlParameter('id')
    };
    CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
      $scope.$apply(function () {
        vm.customer = res.data;
      });
    });
  }

})();
