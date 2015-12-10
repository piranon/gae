(function() {
  'use strict';

  angular
      .module('customerGroup')
      .controller('AddController',AddController);

  function AddController($scope, $window, $cookies) {
    var vm = this;
    var id = getUrlParameter('id'),
        apiUrl,
        successMessage,
        errorMessage;
    vm.response = [];
    vm.customers = [];
    vm.customersSelected = [];
    vm.customersSelectedId = [];
    vm.clickOnSubmit = submit;
    vm.selectedCustomer = function (seleted) {
      addCustomer(seleted);
    };
    vm.submitCustomerInGroup = function () {
      addCustomer(vm.inputCustomer);
    };
    vm.removeCustomer = function (id) {
      removeCustomer(id);
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
          vm.name = res.data.name;
          vm.description = res.data.description;
          //vm.customersSelected = res.data.customers;
          angular.forEach(res.data.customers, function (value, key) {
            value.image_url = null;
            if (value.image_id) {
              value.image_url = GURL.root_url() + 'root_images/' + value.file_dir + 'r100_' + value.file_name;
            }
            vm.customersSelected.push(value);
            vm.customersSelectedId.push(value.customer_id);
          });
        });
      });
    }
    CUR_MODULE.apiGet("start/customer_list").then(function (res) {
      vm.response = res.data;
      $scope.$apply(function () {
        angular.forEach(res.data, function (value, key) {
          vm.customers.push(value.first_name + ' ' + value.last_name);
        });
      });
    });

    function submit() {
      GAEUI.pageLoading().play();
      if (id) {
        apiUrl = 'start/update';
        successMessage = 'Update customer group complete';
        errorMessage = 'Can not update customer group';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Create customer group complete';
        errorMessage = 'Can not create customer group';
      }
      var dataSend = {
        "id": id || '',
        "name": vm.name || '',
        "description": vm.description || '',
        "customer_ids": vm.customersSelectedId || ''
      };
      CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
        if (res.ok) {
          GAEUI.pageLoading().stop();
          $cookies.putObject('cus_g_list_noti', {'message': successMessage, 'time':res.data.time}, {'path': '/'});
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
      });
    }

    function removeCustomer(id) {
      vm.customersSelected = vm.customersSelected.filter(function (obj) {
        return obj.customer_id != id;
      });
      vm.customersSelectedId.splice(vm.customersSelectedId.indexOf(id), 1);
    }

    function addCustomer(seleted) {
      var isFound = false,
          isAdded = false;
      angular.forEach(vm.response, function (value, key) {
        var name = value.first_name + ' ' + value.last_name;
        if (name != seleted) {
          return true;
        }
        if (vm.customersSelectedId.indexOf(value.customer_id) > -1) {
          isAdded = true;
          return true;
        }
        value.image_url = null;
        if (value.image_id) {
          value.image_url = GURL.root_url() + 'root_images/' + value.file_dir + 'r100_' + value.file_name;
        }
        vm.customersSelectedId.push(value.customer_id);
        vm.customersSelected.unshift(value);
        isFound = true;
      });
      vm.inputCustomer = '';
      if (isAdded) {
        isFound = true;
        alert('The customer has already added');
      }
      if (!isFound) {
        alert('Not found customer');
      }
    }

    function keyDownRequired($event) {
      angular.element('#' + $event.currentTarget.id).parent().removeClass('has-error');
    }
  }

})();