(function() {
  'use strict';

  angular
      .module('customerGroup')
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

    fetchListing();

    function fetchListing() {
      CUR_MODULE.apiGet("start/listing").then(function (res) {
        $scope.$apply(function () {
          vm.customers = res.data;
          vm.total = res.data.length;
        });
      });
    }

    notification = $cookies.getObject('cus_g_list_noti');
    if (notification && notification.time == getUrlParameter('timestamp')) {
      GAEUI.notification().playComplete(notification.message);
      $cookies.remove('cus_g_list_noti', {'path': '/'});
    }

    function onChangeBulkDelete(action) {
      if (action != 1) {
        return false;
      }
      GAEUI.pageLoading().play();
      if (vm.selectedDeleteId.length === 0) {
        GAEUI.pageLoading().stop();
        GAEUI.notification().playError('Please select some customer group');
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
            GAEUI.notification().playComplete("Delete customer group complete");
          } else {
            GAEUI.pageLoading().stop();
            GAEUI.notification().playError('Can not delete customer group');
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
          vm.selectedDeleteId.push(value.customer_group_id);
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