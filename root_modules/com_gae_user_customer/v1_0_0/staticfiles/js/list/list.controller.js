(function() {
  'use strict';

  angular
      .module('customer')
      .controller('ListController', ListController);

  function ListController($scope, $window, $cookies) {
    var vm = this;
    var notification;
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

    notification = $cookies.getObject('cus_list_noti');
    if (notification && notification.time == getUrlParameter('timestamp')) {
      GAEUI.notification().playComplete(notification.message);
      $cookies.remove('cus_list_noti', {'path': '/'});
    }

    fetchListing();

    function fetchListing() {
      CUR_MODULE.apiGet("start/listing").then(function (res) {
        $scope.$apply(function () {
          vm.customers = res.data;
          vm.total = res.data.length;
        });
      });
    }

    function onChangeBulkDelete(action) {
      if (action != 1) {
        return false;
      }
      GAEUI.pageLoading().play();
      if (vm.selectedDeleteId.length === 0) {
        GAEUI.pageLoading().stop();
        GAEUI.notification().playError('Please select some customer');
      } else {
        var dataSend = {
          "ids": vm.selectedDeleteId
        };
        CUR_MODULE.apiPost('start/bulk_delete', dataSend).then(function (res) {
          vm.selectedDeleteId = [];
          vm.bulkDelete = "";
          if (res.ok) {
            fetchListing();
            GAEUI.pageLoading().stop();
            GAEUI.notification().playComplete("Delete customer complete");
          } else {
            GAEUI.pageLoading().stop();
            GAEUI.notification().playError('Can not delete customer');
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

    function setStatusBlock(id, status) {
      GAEUI.pageLoading().play();
      switchStatus(id, status);
      var dataSend = {
        "id": id,
        "status": status
      };
      CUR_MODULE.apiPost('start/update_status', dataSend).then(function (res) {
        if (res.ok) {
          GAEUI.pageLoading().stop();
          GAEUI.notification().playComplete("Update status complete");
        } else {
          GAEUI.pageLoading().stop();
          GAEUI.notification().playError('Cannot update status');
        }
      });
    }

    function switchStatus(id, status) {
      angular.forEach(vm.customers, function (value, key) {
        if (value.customer_id == id) {
          if (status == 1) {
            vm.customers[key].status = 2;
          } else {
            vm.customers[key].status = 1;
          }
        }
      });
    }

  }

})();
