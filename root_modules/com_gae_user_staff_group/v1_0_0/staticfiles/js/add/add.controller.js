(function() {
  'use strict';

  angular
      .module('staffGroup')
      .controller('AddController',AddController);

  function AddController($scope, $window, $cookies) {
    var vm = this;
    var id = getUrlParameter('id'),
        apiUrl,
        successMessage,
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
      GAEUI.pageLoading().play();
      if (id) {
        apiUrl = 'start/update';
        successMessage = 'Update staff group complete';
        errorMessage = 'Can not update staff group';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Update staff group complete';
        errorMessage = 'Can not create staff group';
      }
      var dataSend = {
        "id": id || '',
        "name": vm.name || '',
        "description": vm.description || ''
      };
      CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
        if (res.ok) {
          GAEUI.pageLoading().stop();
          $cookies.putObject('staff_g_list_noti', {'message': successMessage, 'time':res.data.time}, {'path': '/'});
          $window.location.href = CUR_MODULE.data.app_url + 'start?timestamp=' + res.data.time;
        } else {
          angular.forEach(res.data, function (value, key) {
            console.log(res.data);
            if (value === 'required') {
              angular.element('#' + key).parent().addClass('has-error');
              angular.element('#' + key).next().text('ห้ามเว้นว่าง');
              angular.element('#' + key).next().removeClass('hide');
            }
          });
          GAEUI.pageLoading().stop();
          GAEUI.notification().playError(errorMessage);
        }
      }).onProgress(function(percent){
        GAEUI.pageLoading().updateProgress(percent);
      });
    }
  }

})();
$( document ).ready(function() {
  $("#submit-save-header").click(function() {
    $( "#submit-save" ).trigger( "click" );
  });
});