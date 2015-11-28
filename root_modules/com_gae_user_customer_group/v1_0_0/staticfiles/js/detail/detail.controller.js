(function() {
  'use strict';

  angular
      .module('customerGroup')
      .controller('DetailController', DetailController);

  function DetailController($scope, $window) {
    var vm = this;
    var id = getUrlParameter('id');
    vm.group = [];
    vm.customers = [];
    vm.total = 0;
    vm.limit = 10;
    vm.selectedDeleteId = [];
    vm.deleteAll = false;
    vm.onClickBulkDeleteAll = onClickBulkDeleteAll;
    vm.onChangeLimit = function (limitList) {
      vm.limit = limitList || 10;
    };
    vm.deleteSelected = function (id) {
      return vm.selectedDeleteId.indexOf(id) > -1;
    };
    vm.onChangeBulkDelete = function (action) {
      onChangeBulkDelete(action);
    };
    vm.onClickSort = function (keyname) {
      onClickSort(keyname);
    };
    vm.onClickBulkDelete = function (id) {
      onClickBulkDelete(id);
    };

    var dataSend = {
      "id": id
    };
    CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
      $scope.$apply(function () {
        vm.group = res.data;
        vm.customers = res.data.customers;
        vm.total = res.data.customers.length;
      });
    });

    function onChangeBulkDelete(action) {
      if (action != 1) {
        return false;
      }
      if (vm.selectedDeleteId.length === 0) {
        alert('Please select some customer');
      } else {
        var dataSend = {
          "id": id,
          "customerIds": vm.selectedDeleteId
        };
        CUR_MODULE.apiPost('start/bulk_delete_customer', dataSend).then(function (res) {
          if (res.ok) {
            $window.location.href = CUR_MODULE.data.app_url + 'start/detail?id=' + id;
          } else {
            alert("Error: Can not delete customer");
          }
        });
      }
    }

    function onClickSort(keyname) {
      vm.sortKey = keyname || 'create_time';
      if (vm.reverse) {
        vm.reverse = false;
      } else {
        vm.reverse = true;
      }
    }

    function onClickBulkDeleteAll() {
      if (vm.deleteAll) {
        vm.deleteAll = false;
        vm.selectedDeleteId = [];
      } else {
        vm.deleteAll = true;
        vm.selectedDeleteId = [];
        angular.forEach(vm.customers, function (value, key) {
          vm.selectedDeleteId.push(value.customer_id);
        });

      }
    }

    function onClickBulkDelete(id) {
      if (vm.selectedDeleteId.indexOf(id) > -1) {
        vm.selectedDeleteId.splice(vm.selectedDeleteId.indexOf(id), 1);
      } else {
        vm.selectedDeleteId.push(id);
      }
    }
  }

})();