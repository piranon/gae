(function() {
  'use strict';

  angular
      .module('staffGroup')
      .controller('AddController',AddController);

  function AddController($scope, $window) {
    var vm = this;
    var id = getUrlParameter('id'),
        apiUrl,
        errorMessage;
    vm.clickOnSubmit = submit;

    if (id) {
      var dataSend = {
        "id": id
      };
      CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
        $scope.$apply(function () {
          vm.name = res.data.name;
          vm.description = res.data.description;
        });
      });
    }

    function submit() {
      if (vm.name) {
        if (id) {
          apiUrl = 'start/update';
          errorMessage = 'Can not update staff group';
        } else {
          apiUrl = 'start/add';
          errorMessage = 'Can not create staff group';
        }
        var dataSend = {
          "id": id || '',
          "name": vm.name || '',
          "description": vm.description || ''
        };
        CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
          if (res.ok) {
            $window.location.href = CUR_MODULE.data.app_url + 'start';
          } else {
            alert(errorMessage);
          }
        });
      } else {
        alert('Please fill-in required field');
      }
    }
  }

})();