(function() {
  'use strict';

  angular
      .module('staff')
      .controller('AddController', AddController);

  function AddController($scope, $timeout, $window, focus) {
    var vm = this;
    var id = getUrlParameter('id'),
        apiUrl,
        errorMessage;

    vm.imageProfile = '';
    vm.inputType = 'password';
    vm.groupOption = [];
    vm.password = '';
    vm.passwordWarning = false;
    vm.checkPassword = checkPassword;
    vm.showPassword = showPassword;
    vm.clickOnUpload = clickOnUpload;
    vm.clickOnSubmit = clickOnSubmit;
    vm.submit = submit;

    if (id) {
      var dataSend = {
        "id": id
      };
      CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
        $scope.$apply(function () {
          vm.email = res.data.email;
          vm.firstname = res.data.first_name;
          vm.lastname = res.data.last_name;
          vm.phone = res.data.phone;
          vm.birthday = res.data.birthday;
          vm.tag = res.data.tag;
          vm.password = res.data.password;
          if (res.data.image_id) {
            vm.imageProfile = GURL.root_url() + 'root_images/' + res.data.file_dir + 'r200_' + res.data.file_name;
          }
        });
      });
    }

    CUR_MODULE.apiGet('start/list_group').then(function (res) {
      $scope.$apply(function () {
        vm.groupOption = res.data;
      });
    });

    function showPassword() {
      focus('test');
      if (vm.inputType == 'password') {
        vm.inputType = 'text';
      } else {
        vm.inputType = 'password';
      }
    }

    function clickOnUpload() {
      $timeout(function () {
        angular.element('#imageCategory').trigger('click');
      }, 100);
    }

    function clickOnSubmit() {
      $timeout(function () {
        angular.element('#submit').trigger('click');
      }, 100);
    }

    function checkPassword() {
      if (vm.password.length >= 8) {
        vm.passwordWarning = false;
      } else {
        vm.passwordWarning = true;
      }
    }

    function submit() {
      if (vm.passwordWarning) {
        focus('password');
        return false;
      }
      if (vm.email && vm.firstname && vm.lastname && vm.customerGroup && vm.password) {
        if (id) {
          apiUrl = 'start/update';
          errorMessage = 'Can not update staff';
        } else {
          apiUrl = 'start/add';
          errorMessage = 'Can not create staff';
        }
        var dataSend = {
          "id": id || '',
          "first_name": vm.firstname || '',
          "last_name": vm.lastname || '',
          "email": vm.email || '',
          "phone": vm.phone || '',
          "tag": vm.tag || '',
          "password": vm.password || '',
          "profile_pic": vm.fileModel,
          "group_id": vm.customerGroup && vm.customerGroup.staff_group_id || ''
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