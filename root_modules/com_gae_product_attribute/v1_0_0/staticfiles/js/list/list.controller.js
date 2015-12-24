(function() {
  'use strict';

  angular
      .module('category')
      .controller('ListController', ListController);

  function ListController($scope, $timeout, $cookies, $window) {
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
    vm.createSubCate = function (id, name) {
      createSubCate(id, name);
    };
    vm.onClickEditSubCate = function (element) {
      onClickEditSubCate(element);
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

    function onClickEditSubCate(id, name) {
      vm.displaySubCateForm = true;
      cateId = id;
      if (name) {
        vm.subCategoryName = name;
      }
      angular.element('.btn-add').addClass('btn-save');
      angular.element('.btn-add').removeClass('btn-add');
      vm.title = "Edit Sub Category";
      vm.title_desc = "แก้ไขหมวดสินค้าย่อย";
    }

    function createSubCate(id, name) {
      if (!vm.displaySubCateForm) {
        vm.displaySubCateForm = true;
      }
      vm.parentId = id;
      vm.placeholderSubCateName = name;
      vm.title = "Create Attribute Group for Variants & Specification";
      vm.title_desc = "สร้างกลุ่มของคุณลักษณะสินค้า เพื่อให้เป็นตัวเลือกสินค้าหรือสเปคสินค้า";
    }

    function onClickEdit(id) {
      vm.displaySubCateForm = false;
      cateId = id;
      angular.element('#pic-icon').removeClass('ng-hide');
      angular.element('#colorPicker .colorInner').removeAttr("style");
      angular.element('#colorPicker2 .colorInner').removeAttr("style");
      var element = '#btn-edit-' + id;
      var name = angular.element(element).data('name');
      var imageId = angular.element(element).data('image_id');
      var image = angular.element(element).data('image');
      var label = angular.element(element).data('label');
      var font = angular.element(element).data('font');
      if (name) {
        vm.categoryName = angular.element(element).data('name');
      }
      if (imageId) {
        vm.imageProfile = angular.element(element).data('image');
      }
      if (label !== '#eee') {
        angular.element('#colorPicker .colorInner').css('background', label);
      }
      if (font !== '#666') {
        angular.element('#colorPicker2 .colorInner').css('background', font);
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
          vm.sortIndex = ++res.data.order;
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
            if (action == 1) {
              apiUrl = 'start/bulk_show';
              successMessage = 'Update status category complete';
              errorMessage = 'Can not update status category';
            } else if (action == 2) {
              apiUrl = 'start/bulk_hide';
              successMessage = 'Update status category complete';
              errorMessage = 'Can not update status category';
            } else if (action == 3) {
              apiUrl = 'start/bulk_delete';
              successMessage = 'Delete category complete';
              errorMessage = 'Can not delete category';
            }
            var dataSend = {
              "ids": vm.selectedDeleteId
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
          vm.selectedDeleteId.push(value.referral_id);
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
          "parent_id": vm.parentId || ''
        };
      } else {
        var dataSend = {
          "id": cateId || '',
          "category_name": vm.categoryName || '',
          "parent_id": vm.parentId || '',
          "sort_index": vm.sortIndex || '',
          "profile_pic": vm.fileModel,
          "label_color": angular.element('#labelColor').val() || '',
          "font_color": angular.element('#fontColor').val() || ''
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
      });
    }

    $(document).ready(function () {
      var sort;
      $("#sortable").sortable({
        handle: ".btn-re-oder",
        start: function( event, ui ) {
          sort = $( "#sortable" ).sortable( "serialize", { key: "id" } );
        },
        update: function (event, ui) {
          var dataSend = {
            'sort': sort,
            'sorted': $( "#sortable" ).sortable( "serialize", { key: "id" } )
          };
          CUR_MODULE.apiPost('start/update_sort', dataSend).then(function (res) {
            if (res.ok) {
              fetchListing();
              GAEUI.notification().playComplete("Update sort complete");
            } else {
              GAEUI.notification().playError('Cannot update sort');
            }
          });
        }
      });
    });

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