(function() {
  'use strict';

  angular
      .module('category')
      .controller('ListController', ListController);

  function ListController($scope, $timeout, $cookies, $window, focus) {
    var vm = this,
        cateId,
        notification,
        apiUrl,
        successMessage,
        errorMessage;
    vm.title = "Create Attribute Group for Variants & Specification";
    vm.title_desc = "สร้างกลุ่มของคุณลักษณะสินค้า เพื่อให้เป็นตัวเลือกสินค้าหรือสเปคสินค้า";
    vm.items = [];
    vm.total = 0;
    vm.limit = 10;
    vm.selectedDeleteId = [];
    vm.deleteAll = false;
    vm.onClickBulkDeleteAll = onClickBulkDeleteAll;
    vm.imageProfile = '';
    vm.placeholderSubCateName = '';
    vm.clickOnUpload = clickOnUpload;
    vm.addCategory = addCategory;
    vm.displaySubCateForm = false;
    vm.attributeTypeId = 1;
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
    vm.onClickEdit = function (id) {
      onClickEdit(id);
    };
    vm.createSubCate = function (id, name, type) {
      createSubCate(id, name, type);
    };
    vm.onClickEditSubCate = function (id, name, type) {
      onClickEditSubCate(id, name, type);
    };
    vm.onClickExpand = function (lv, id, $event) {
      onClickExpand(lv, id, $event);
    };

    function onClickExpand(lv, id, $event) {
      var element = angular.element($event.target).parent();
      if (element.hasClass('btn-expand')) {
        element.removeClass('btn-expand');
        element.addClass('btn-expand-up');
        angular.element('#cate-' + lv + '-box-' + id).removeClass('hide');
      } else {
        element.removeClass('btn-expand-up');
        element.addClass('btn-expand');
        angular.element('#cate-' + lv + '-box-' + id).addClass('hide');
      }
    }

    function onClickEditSubCate(id, name, type) {
      vm.displaySubCateForm = true;
      cateId = id;
      if (name) {
        vm.subCategoryName = name;
      }
      angular.element('.btn-add').addClass('btn-save');
      angular.element('.btn-add').removeClass('btn-add');
      vm.title = "Edit Sub Category";
      vm.title_desc = "แก้ไขหมวดสินค้าย่อย";
      focus('sub_category_name');
    }

    function createSubCate(id, name, type) {
      if (!vm.displaySubCateForm) {
        vm.displaySubCateForm = true;
      }
      vm.parentId = id;
      vm.placeholderSubCateName = name;
      vm.attributeTypeId = type;
      vm.title = "Create Attribute Group for Variants & Specification";
      vm.title_desc = "สร้างกลุ่มของคุณลักษณะสินค้า เพื่อให้เป็นตัวเลือกสินค้าหรือสเปคสินค้า";
      focus('sub_category_name');
    }

    function onClickEdit(id) {
      vm.displaySubCateForm = false;
      cateId = id;
      angular.element('#pic-icon').removeClass('ng-hide');
      var element = '#btn-edit-' + id;
      var name = angular.element(element).data('name');
      var imageId = angular.element(element).data('image_id');
      var image = angular.element(element).data('image');
      if (name) {
        vm.categoryName = angular.element(element).data('name');
      }
      if (imageId) {
        vm.imageProfile = angular.element(element).data('image');
      }
      angular.element('.btn-add').addClass('btn-save');
      angular.element('.btn-add').removeClass('btn-add');
      vm.title = "Edit Attribute Group for Variants & Specification";
      vm.title_desc = "แก้ไขกลุ่มของคุณลักษณะสินค้า เพื่อให้เป็นตัวเลือกสินค้าหรือสเปคสินค้า";
    }

    notification = $cookies.getObject('cus_list_noti');
    if (notification && notification.time == getUrlParameter('timestamp')) {
      GAEUI.notification().playComplete(notification.message);
      $cookies.remove('cus_list_noti', {'path': '/'});
    }

    fetchListing();

    function fetchListing() {
      CUR_MODULE.apiGet("start/listing").then(function (res) {
        $scope.$apply(function () {
          vm.items = res.data.items;
          vm.total = res.data.items.length;
        });
      });
    }

    function onChangeBulkDelete(action) {
      GAEUI.confirmBox().play("Are you sure?","please confirm your action.",function(bool){
        if(bool){
          GAEUI.confirmBox().stop();
          GAEUI.pageLoading().play();
          if (vm.selectedDeleteId.length === 0) {
            vm.bulkDelete = "";
            GAEUI.pageLoading().stop();
            GAEUI.notification().playError('Please select some category');
          } else {
            if (action == 1 || action == 2) {
              apiUrl = 'start/bulk_update_type';
              successMessage = 'Update attribute complete';
              errorMessage = 'Can not update attribute';
            } else if (action == 3) {
              apiUrl = 'start/bulk_delete';
              successMessage = 'Delete category complete';
              errorMessage = 'Can not delete category';
            }
            var dataSend = {
              'ids': vm.selectedDeleteId,
              'type': action
            };
            CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
              vm.selectedDeleteId = [];
              vm.bulkDelete = "";
              if (res.ok) {
                fetchListing();
                GAEUI.pageLoading().stop();
                GAEUI.notification().playComplete(successMessage);
              } else {
                GAEUI.pageLoading().stop();
                GAEUI.notification().playError(errorMessage);
              }
            }).onProgress(function(percent){
              GAEUI.pageLoading().updateProgress(percent);
            });
          }
        } else {
          vm.selectedDeleteId = [];
          vm.bulkDelete = "";
        }
        GAEUI.confirmBox().stop();
      },"Done");
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
          vm.selectedDeleteId.push(value.attribute_id);
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
      var dataSend = {
        "id": id,
        "status": status
      };
      console.log(dataSend);
      CUR_MODULE.apiPost('start/update_status', dataSend).then(function (res) {
        if (res.ok) {
          fetchListing();
          GAEUI.pageLoading().stop();
          GAEUI.notification().playComplete("Update status complete");
        } else {
          GAEUI.pageLoading().stop();
          GAEUI.notification().playError('Cannot update status');
        }
      }).onProgress(function(percent){
        GAEUI.pageLoading().updateProgress(percent);
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

    function addCategory(isSubCate) {
      GAEUI.pageLoading().play();
      if (cateId) {
        apiUrl = 'start/update';
        successMessage = 'Update category complete';
        errorMessage = 'Can not update category';
      } else {
        apiUrl = 'start/add';
        successMessage = 'Create category complete';
        errorMessage = 'Can not create category';
      }
      if (isSubCate) {
        var dataSend = {
          "id": cateId || '',
          "category_name": vm.subCategoryName || '',
          "parent_id": vm.parentId || '',
          "attribute_type_id": vm.attributeTypeId || ''
        };
      } else {
        var dataSend = {
          "id": cateId || '',
          "category_name": vm.categoryName || '',
          "profile_pic": vm.fileModel,
          "attribute_type_id": vm.attributeTypeId || ''
        };
      }
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
          vm.parentId = '';
        }
      }).onProgress(function(percent){
        GAEUI.pageLoading().updateProgress(percent);
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