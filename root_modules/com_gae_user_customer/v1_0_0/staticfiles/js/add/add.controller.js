(function() {
  'use strict';

  angular
      .module('customer')
      .controller('AddController', AddController);

  function AddController($scope, $timeout, $window, $cookies, focus) {
    var vm = this;
    var id = getUrlParameter('id'),
        apiUrl,
        successMessage,
        errorMessage;

    vm.imageProfile = '';
    vm.inputType = 'password';
    vm.groupOption = [];
    vm.sexOption = [
      {name: 'male', value: '1'},
      {name: 'female', value: '2'}
    ];
    vm.password = '';
    vm.passwordWarning = false;
    vm.showPassword = showPassword;
    vm.clickOnUpload = clickOnUpload;
    vm.clickOnSubmit = clickOnSubmit;
    vm.submit = submit;
    vm.checkPassword = function ($event) {
      checkPassword();
      keyDownRequired($event);
    };
    vm.keyDownRequired = function ($event) {
      keyDownRequired($event);
    };

    if (id) {
      var dataSend = {
        "id": id
      };
      CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
        $scope.$apply(function () {
          vm.username = res.data.user_name;
          vm.email = res.data.email;
          vm.firstname = res.data.first_name;
          vm.lastname = res.data.last_name;
          vm.phone = res.data.phone;
          vm.birthday = res.data.birthday;
          vm.gender = vm.sexOption[res.data.gender_type_id];
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

    function showPassword($event) {
      focus('test');
      if (vm.inputType == 'password') {
        vm.inputType = 'text';
      } else {
        vm.inputType = 'password';
      }
      angular.element('#' + $event.currentTarget.id).parent().removeClass('has-error');
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

    function keyDownRequired($event) {
      angular.element('#' + $event.currentTarget.id).parent().removeClass('has-error');
    }

    function submit() {
      GAEUI.pageLoading().play();
      if (vm.passwordWarning) {
        focus('password');
        GAEUI.pageLoading().stop();
        return false;
      }
      if (id) {
        apiUrl = 'start/update';
        successMessage = 'Update customer complete';
        errorMessage = 'Can not update customer';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Create customer complete';
        errorMessage = 'Can not create customer';
      }
      var dataSend = {
        "id": id || '',
        "username": vm.username || '',
        "first_name": vm.firstname || '',
        "last_name": vm.lastname || '',
        "birthday": vm.birthday || '',
        "gender": vm.gender && vm.gender.value || '',
        "email": vm.email || '',
        "phone": vm.phone || '',
        "tag": vm.tag || '',
        "password": vm.password || '',
        "profile_pic": vm.fileModel,
        "group_id": vm.customerGroup && vm.customerGroup.customer_group_id || ''
      };
      CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
        if (res.ok) {
          GAEUI.pageLoading().stop();
          $cookies.putObject('cus_list_noti', {'message': successMessage, 'time':res.data.time}, {'path': '/'});
          $window.location.href = CUR_MODULE.data.app_url + 'start?timestamp=' + res.data.time;
        } else {
          angular.forEach(res.data, function (value, key) {
            if (value === 'required') {
              angular.element('#' + key).parent().addClass('has-error');
              if (key === 'password') {
                angular.element('#' + key).next().next().text('ห้ามเว้นว่าง');
                angular.element('#' + key).next().next().removeClass('hide');
              } else {
                angular.element('#' + key).next().text('ห้ามเว้นว่าง');
                angular.element('#' + key).next().removeClass('hide');
              }
            }
          });
          GAEUI.pageLoading().stop();
          GAEUI.notification().playError(errorMessage);
        }
      });
    }
  }

})();