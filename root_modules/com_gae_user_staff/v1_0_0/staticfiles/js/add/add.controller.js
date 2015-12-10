(function() {
  'use strict';

  angular
      .module('staff')
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
    vm.password = '';
    vm.passwordWarning = false;
    vm.checkPassword = checkPassword;
    vm.showPassword = showPassword;
    vm.clickOnUpload = clickOnUpload;
    vm.clickOnSubmit = clickOnSubmit;
    vm.submit = submit;
    vm.shopAdminAdded = false;
    vm.isShopAdmin = false;
    vm.keyDownRequired = function ($event) {
      keyDownRequired($event);
    };
    vm.changeRequired = function ($event) {
      changeRequired($event);
    };

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

    CUR_MODULE.apiGet('start/get_shop_admin').then(function (res) {
      $scope.$apply(function () {
        if (res.data && res.data.id) {
          if (res.data.id == id) {
            vm.isShopAdmin = true;
          } else {
            vm.shopAdminAdded = true;
          }
        }
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

    function keyDownRequired($event) {
      angular.element('#' + $event.currentTarget.id).parent().removeClass('has-error');
    }

    function changeRequired(id) {
      angular.element('#' + id).parent().removeClass('has-error');
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
        successMessage = 'Update staff complete';
        errorMessage = 'Can not update staff';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Create staff complete';
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
        "group_id": vm.customerGroup && vm.customerGroup.staff_group_id || '',
        "is_shop_admin": vm.isShopAdmin ? '1' : '0'
      };
      CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
        if (res.ok) {
          GAEUI.pageLoading().stop();
          $cookies.putObject('staff_list_noti', {'message': successMessage, 'time':res.data.time}, {'path': '/'});
          $window.location.href = CUR_MODULE.data.app_url + 'start?timestamp=' + res.data.time;
        } else {
          angular.forEach(res.data, function (value, key) {
            if (value === 'required') {
              angular.element('#' + key).parent().addClass('has-error');
              if (key === 'password') {
                angular.element('#' + key).next().next().text('ห้ามเว้นว่าง');
                angular.element('#' + key).next().next().removeClass('hide');
              } else if (key === 'group_id') {
                angular.element('#' + key).next().text('กรุณาเลือก');
                angular.element('#' + key).next().removeClass('hide');
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