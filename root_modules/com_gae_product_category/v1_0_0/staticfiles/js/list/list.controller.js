(function() {
  'use strict';

  angular
      .module('category')
      .controller('ListController', ListController);

  function ListController($scope, $timeout, $cookies, $window) {
    var vm = this,
        id = getUrlParameter('id'),
        notification,
        apiUrl,
        successMessage,
        errorMessage;
    vm.items = [];
    vm.total = 0;
    vm.limit = 10;
    vm.selectedDeleteId = [];
    vm.deleteAll = false;
    vm.onClickBulkDeleteAll = onClickBulkDeleteAll;
    vm.imageProfile = '';
    vm.clickOnUpload = clickOnUpload;
    vm.addCategory = addCategory;
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
    vm.keyDownRequired = function ($event) {
      keyDownRequired($event);
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
          vm.items = res.data;
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
        vm.bulkDelete = "";
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
        angular.forEach(vm.items, function (value, key) {
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
      angular.forEach(vm.items, function (value, key) {
        if (value.customer_id == id) {
          if (status == 1) {
            vm.items[key].status = 2;
          } else {
            vm.items[key].status = 1;
          }
        }
      });
    }

    function clickOnUpload() {
      $timeout(function () {
        angular.element('#imageCategory').trigger('click');
      }, 100);
    }

    function keyDownRequired($event) {
      angular.element('#' + $event.currentTarget.id).parent().removeClass('has-error');
    }

    function addCategory() {
      GAEUI.pageLoading().play();
      if (vm.passwordWarning) {
        focus('password');
        GAEUI.pageLoading().stop();
        return false;
      }
      if (id) {
        apiUrl = 'start/update';
        successMessage = 'Update category complete';
        errorMessage = 'Can not update category';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Create category complete';
        errorMessage = 'Can not create category';
      }
      var dataSend = {
        "id": id || '',
        "category_name": vm.categoryName || '',
        "parent_id": vm.parentId || '',
        "sort_index": vm.sortIndex || '',
        "profile_pic": vm.fileModel,
        "label_color": angular.element('#labelColor').val() || '',
        "font_color": angular.element('#fontColor').val() || ''
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
              angular.element('#' + key).next().text('ห้ามเว้นว่าง');
              angular.element('#' + key).next().removeClass('hide');
            }
          });
          GAEUI.pageLoading().stop();
          GAEUI.notification().playError(errorMessage);
        }
      });
    }

  }

})();
function PreviewImage() {
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("imageCategory").files[0]);
  oFReader.onload = function (oFREvent) {
    document.getElementById("area-inner-image").src = oFREvent.target.result;
    document.getElementById("area-inner-image").setAttribute('style', 'width:auto !important;');
    document.getElementById("pic-icon").style.display = "none";
  };
}