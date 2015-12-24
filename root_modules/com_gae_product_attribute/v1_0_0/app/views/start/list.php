<div ng-app="category" ng-controller="ListController as list">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4"></div>
            <div class="col-md-4 topic-page">Categories</div>
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
                    {{list.title}}
                </div>
            </div>
            <div class="row content-desc">
                <div class="col-sm-12">
                    {{list.title_desc}}
                </div>
            </div>
            <div class="create-category" ng-show="!list.displaySubCateForm">
                <div>
                    <div class="create-category-label">Attribute Group Name</div>
                    <div class="create-category-desc">ชื่อกลุ่มคุณลักษณะ</div>
                    <div class="form-group">
                        <input type="text" class="form-control" ng-model="list.categoryName" id="category_name"
                               ng-keydown="list.keyDownRequired($event)">

                        <div class="add-warning hide" ng-hide='list.categoryName'></div>
                    </div>
                </div>
                <div>Icon</div>
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
                    <div>
                        <button class="circle-small-warning" type="button">
                        </button>
                    </div>
                    <div>
                        <button class="circle-small-warning" type="button">
                        </button>
                    </div>
                </div>
                <div>
                    <div>Set as Product Option (Variant)</div>
                    <div>ตั้งให้เป็นตัวเลือกสินค้า</div>
                    <div>Set as Specification</div>
                    <div>ตั้งให้เป็นสเปคสินค้า</div>
                </div>
                <div>
                    <a class="btn-add" ng-click="list.addCategory(false);">
                        <span></span>
                    </a>
                </div>
            </div>
            <div class="create-category create-sub-category" ng-show="list.displaySubCateForm">
                <div>
                    <div class="create-category-label">Category Name</div>
                    <div class="create-category-desc">ชื่อหมวดสินค้า</div>
                    <div class="form-group">
                        <input type="text" class="form-control" ng-model="list.subCategoryName" id="category_name"
                               ng-keydown="list.keyDownRequired($event)" placeholder="{{list.placeholderSubCateName}}">

                        <div class="add-warning hide" ng-hide='list.subCategoryName'></div>
                    </div>
                </div>
                <div>
                    <a class="btn-add" ng-click="list.addCategory(true);">
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
                    <div ng-show="list.items">
                        {{list.selectedDeleteId.length}} category selected from total {{list.total}} categories
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
                    <div>Attribute Group & Class</div>
                    <div>Specification</div>
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
                    <div>
                        <div class="item-label">
                            {{item.name}}
                        </div>
                    </div>
                    <div>
                        <div>
                            <a class="btn-expand" ng-click="list.onClickExpand('lv2', item.referral_id, $event)">
                                <span></span>
                            </a>

                            <div class="item-name">{{item.name}} ({{item.cate_child_count}})</div>
                            <a class="btn-add-s" ng-click="list.createSubCate(item.referral_id, item.name)">
                                <span></span>
                            </a>
                            <a class="btn-edit" id="btn-edit-{{item.referral_id}}"
                               ng-click="list.onClickEdit(item.referral_id)"
                               data-referral_id="{{item.referral_id}}"
                               data-name="{{item.name}}"
                               data-image_id="{{item.image_id}}"
                               data-image="<?php echo root_url(), 'root_images/'; ?>{{item.file_dir}}r100_{{item.file_name}}"
                               data-label="{{item.label_color}}"
                               data-font="{{item.font_color}}">
                                <span></span>
                            </a>
                            <a class="btn-del-s" ng-click="list.setStatusBlock(item.referral_id, 0)">
                                <span></span>
                            </a>
                        </div>
                        <div class="clear"></div>
                        <div class="cate-lv2-box hide" id="cate-lv2-box-{{item.referral_id}}">
                            <!-- lv2 -->
                            <div ng-repeat="(key2, v2) in item.cate_child" class="cate-lv-2">
                                <div class="clear"></div>
                                <a class="btn-expand" ng-click="list.onClickExpand('lv3', v2.referral_id, $event)">
                                    <span></span>
                                </a>

                                <div class="item-name">{{v2.name}} ({{v2.cate_child_count}})</div>
                                <a class="btn-add-s" ng-click="list.createSubCate(v2.referral_id, v2.name)">
                                    <span></span>
                                </a>
                                <a class="btn-edit" ng-click="list.onClickEditSubCate(v2.referral_id, v2.name)">
                                    <span></span>
                                </a>
                                <a class="btn-del-s" ng-click="list.setStatusBlock(v2.referral_id, 0)">
                                    <span></span>
                                </a>

                                <div class="clear"></div>
                                <!-- lv3 -->
                                <div ng-repeat="(key3, v3) in v2.cate_child" class="cate-lv-3 hide"
                                     id="cate-lv3-box-{{v2.referral_id}}">
                                    <div class="clear"></div>
                                    <a class="btn-expand" ng-click="list.onClickExpand('lv4', v3.referral_id, $event)">
                                        <span></span>
                                    </a>

                                    <div class="item-name">{{v3.name}} ({{v3.cate_child_count}})</div>
                                    <a class="btn-add-s" ng-click="list.createSubCate(v3.referral_id, v3.name)">
                                        <span></span>
                                    </a>
                                    <a class="btn-edit" ng-click="list.onClickEditSubCate(v3.referral_id, v3.name)">
                                        <span></span>
                                    </a>
                                    <a class="btn-del-s" ng-click="list.setStatusBlock(v3.referral_id, 0)">
                                        <span></span>
                                    </a>

                                    <div class="clear"></div>
                                    <!-- lv4 -->
                                    <div ng-repeat="(key4, v4) in v3.cate_child" class="cate-lv-4 hide"
                                         id="cate-lv4-box-{{v3.referral_id}}">
                                        <div class="clear"></div>
                                        <div class="item-name">{{v4.name}} ({{v4.cate_child_count}})</div>
                                        <a class="btn-add-s" ng-click="list.createSubCate(v4.referral_id, v4.name)">
                                            <span></span>
                                        </a>
                                        <a class="btn-edit" ng-click="list.onClickEditSubCate(v4.referral_id, v4.name)">
                                            <span></span>
                                        </a>
                                        <a class="btn-del-s" ng-click="list.setStatusBlock(v4.referral_id, 0)">
                                            <span></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo $curModule->file_url; ?>icon/fa-check.png"
                             ng-show="item.attribute_type_id == 1">
                        <img src="<?php echo $curModule->file_url; ?>icon/fa-th-list.png"
                             ng-show="item.attribute_type_id == 2">
                    </div>
                </div>
            </div>
            <div class="row" ng-show="list.items">
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
            <div ng-hide="list.items" class="clearfix row no-customer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/no_item.png">

                    <div>ยังไม่มีคุณลักษณะสินค้า ทำการเพิ่มคุณลักษณะได้ที่ด้านบน</div>
                </div>
            </div>
        </div>
    </div>
</div>