<div ng-app="category" ng-controller="ListController as list">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4"></div>
            <div class="col-md-4 topic-page">Brands</div>
        </div>
    </div>
    <div class="box-search">
        <div class="module-container">
            <input type="text" ng-model="list.search" class="new-search-btn" placeholder="Search Here">
        </div>
    </div>
    <div class="customer-list">
        <div class="module-container">
            <div class="row content-header">
                <div class="col-sm-12">
                    Edit Brand
                </div>
            </div>
            <div class="row content-desc">
                <div class="col-sm-12">
                    แก้ไขยี่ห้อสินค้า
                </div>
            </div>
            <div class="create-category" ng-show="!list.displaySubCateForm">
                <div>
                    <strong>Logo</strong><br>
                    ตราสินค้า
                </div>
                <div>
                    <div ng-click="list.clickOnUpload(); $event.stopPropagation();">
                        <div class="area-inner-container">
                            <img id="area-inner-image" src="{{list.imageProfile}}">
                        </div>
                        <span ng-hide="list.imageProfile" id="pic-icon"></span>
                    </div>
                    <div class="hide">
                        <input type="file" file-model='list.fileModel' id="imageCategory" onchange="PreviewImage();">
                    </div>
                </div>
                <div>
                    <div class="create-category-label">Category Name</div>
                    <div class="create-category-desc">ชื่อหมวดสินค้า</div>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" ng-model="list.categoryName" id="category_name"
                           ng-keydown="list.keyDownRequired($event)">

                    <div class="add-warning hide" ng-hide='list.categoryName'></div>
                </div>
                <div>
                    <a class="btn-add" ng-click="list.addCategory(false);">
                        <span></span>
                    </a>
                </div>
            </div>
            <div class="list-filter">
                <div>
                    <select ng-model="list.bulkDelete" ng-change="list.onChangeBulkDelete(list.bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Show Selected</option>
                        <option value="2">Hide Selected</option>
                        <option value="3">Delete Selected</option>
                    </select>
                </div>
                <div>&nbsp;
                    <div ng-show="list.total">
                        {{list.selectedDeleteId.length}} brand selected from total {{list.total}} brands
                    </div>
                </div>
                <div>
                    <select ng-model="list.limitList" ng-change="list.onChangeLimit(limitList)"
                            class="form-control view-limit">
                        <option value="">View 10</option>
                        <option value="25">View 25</option>
                        <option value="50">View 50</option>
                        <option value="100">View 100</option>
                    </select>
                </div>
            </div>
            <div class="table-list" id="sortable">
                <div class="table-list-head">
                    <div>
                        <button class="circle-small-warning" type="button" ng-click="list.onClickBulkDeleteAll()"
                                ng-class="{'active-discount' : list.deleteAll}">
                        </button>
                    </div>
                    <div>Icon</div>
                    <div>Category Label</div>
                    <div></div>
                </div>
                <div class="table-row"
                     dir-paginate="(key, item) in list.items|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit"
                     id="id_{{item.referral_id}}||{{item.sort_index}}">
                    <div>
                        <button class="xChoose circle-small-warning" type="button"
                                ng-class="{'active-discount' : list.deleteSelected(item.referral_id)}"
                                ng-click="list.onClickBulkDelete(item.referral_id)">
                        </button>
                    </div>
                    <div>
                        <img ng-show="item.image_id" width="70" height="70"
                             ng-src="<?php echo root_url(), 'root_images/'; ?>{{item.file_dir}}r100_{{item.file_name}}">
                        <img ng-hide="item.image_id" width="70" height="70"
                             ng-src="<?php echo $curModule->file_url; ?>icon/image_upload.png">
                    </div>
                    <div>{{item.name}}</div>
                    <div>
                        <a ng-show="item.status == 1"
                           ng-click="list.setStatusBlock(item.referral_id, 2)"
                           class="item-show">
                            Show
                        </a>
                        <a ng-show="item.status == 2"
                           ng-click="list.setStatusBlock(item.referral_id, 1)"
                           class="item-hide">
                            hide
                        </a>
                    </div>
                    <div><a class="btn-edit"><span></span></a></div>
                </div>
            </div>
            <div class="row" ng-show="list.total">
                <div class="col-xs-6">
                    <dir-pagination-controls
                        template-url="<?php echo $curModule->file_url; ?>template/summary-pagination.html">
                    </dir-pagination-controls>
                </div>
                <div class="col-xs-6">
                    <div class="dataTables_paginate paging_bootstrap">
                        <dir-pagination-controls
                            max-size="5"
                            direction-links="true"
                            boundary-links="true">
                        </dir-pagination-controls>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div ng-hide="list.total" class="clearfix row no-customer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/no_item.png">

                    <div>ยังไม่มียี่ห้อสินค้า ทำการเพิ่มยี่ห้อสินค้าได้ที่ด้านบน</div>
                </div>
            </div>
        </div>
    </div>
</div>