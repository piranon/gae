(function() {
  'use strict';

  angular
      .module('staff')
      .controller('ListController', ListController);

  function ListController($scope, $window) {
    var vm = this;
    vm.customers = [];
    vm.total = 0;
    vm.limit = 10;
    vm.selectedDeleteId = [];
    vm.deleteAll = false;
    vm.onClickBulkDeleteAll = onClickBulkDeleteAll;
    vm.onChangeLimit = function (limitList) {
      vm.limit = limitList || 10;
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
    vm.deleteSelected = function (id) {
      return vm.selectedDeleteId.indexOf(id) > -1;
    };
    vm.setStatusBlock = function (id, status) {
      setStatusBlock(id, status);
    };

    CUR_MODULE.apiGet("start/listing").then(function (res) {
      $scope.$apply(function () {
        vm.customers = res.data;
        vm.total = res.data.length;
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
          "ids": vm.selectedDeleteId
        };
        CUR_MODULE.apiPost('start/bulk_delete', dataSend).then(function (res) {
          if (res.ok) {
            $window.location.href = CUR_MODULE.data.app_url + 'start';
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
          vm.selectedDeleteId.push(value.staff_id);
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

    function setStatusBlock(id, status) {
      var dataSend = {
        "id": id,
        "status": status
      };
      CUR_MODULE.apiPost('start/update_status', dataSend).then(function (res) {
        if (res.ok) {
          $window.location.href = CUR_MODULE.data.app_url + 'start';
        } else {
          alert('Cannot update status');
        }
      });
    }
  }

})();
