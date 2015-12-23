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
                    Create Main Category
                </div>
            </div>
            <div class="row content-desc">
                <div class="col-sm-12">
                    สร้างหมวดสินค้าหลัก
                </div>
            </div>
            <div class="create-category" ng-show="!list.displaySubCateForm">
                <div>
                    <div class="create-category-label">Category Name</div>
                    <div class="create-category-desc">ชื่อหมวดสินค้า</div>
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
                    <div class="create-category-label">Label Color</div>
                    <div class="create-category-desc">สีพื้นป้าย</div>
                </div>
                <div>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $("#colorPicker").tinycolorpicker();
                            $("#colorPicker2").tinycolorpicker();
                        });
                    </script>
                    <div id="colorPicker" class="colorPicker">
                        <a class="color">
                            <div class="colorInner"></div>
                        </a>

                        <div class="track" ng-click="list.colorPick('#colorPicker');"></div>
                        <ul class="dropdown">
                            <li></li>
                        </ul>
                        <input type="hidden" class="colorInput" id="labelColor">
                    </div>
                </div>
                <div>
                    <div class="create-category-label">Font Color</div>
                    <div class="create-category-desc">สีตัวอักษร</div>
                </div>
                <div>
                    <div id="colorPicker2" class="colorPicker">
                        <a class="color">
                            <div class="colorInner"></div>
                        </a>

                        <div class="track"></div>
                        <ul class="dropdown">
                            <li></li>
                        </ul>
                        <input type="hidden" class="colorInput" id="fontColor">
                    </div>
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
            <div class="table-list">
                <div class="table-list-head">
                    <div>
                        <button class="circle-small-warning" type="button" ng-click="list.onClickBulkDeleteAll()"
                                ng-class="{'active-discount' : list.deleteAll}">
                        </button>
                    </div>
                    <div>Icon</div>
                    <div>Category Label</div>
                    <div>Category Name</div>
                    <div>Visibility</div>
                    <div>Reorder</div>
                </div>
                <div class="table-row"
                     dir-paginate="(key, item) in list.items|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit">
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
                        <div class="item-label"
                             style="background-color:{{item.label_color}}; color: {{item.font_color}}">
                            {{item.name}}
                        </div>
                    </div>
                    <div>
                        <div>
                            <a class="btn-expand">
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
                        <div class="cate-lv2-box">
                            <a class="btn-expand btn-expand-lv2" ng-show="item.cate_child_count">
                                <span></span>
                            </a>
                            <!-- lv2 -->
                            <div ng-repeat="(key2, v2) in item.cate_child" class="cate-lv-2">
                                <div class="clear"></div>
                                <div style="width: 20px; float:left;" ng-show="key2">&nbsp;</div>
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
                                <div ng-repeat="(key3, v3) in v2.cate_child" class="cate-lv-3">
                                    <div class="clear"></div>
                                    <a class="btn-expand btn-expand-lv3" ng-show="!key3">
                                        <span></span>
                                    </a>

                                    <div style="width: 30px; float:left;" ng-show="key3">&nbsp;</div>
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
                                    <div ng-repeat="(key4, v4) in v3.cate_child" class="cate-lv-4">
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
                    <div><a class="btn-re-oder"><span></span></a></div>
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

                    <div>ยังไม่มีหมวดสินค้า ทำการเพิ่มหมวดสินค้าได้ที่ด้านบน</div>
                </div>
            </div>
        </div>
    </div>
</div>
