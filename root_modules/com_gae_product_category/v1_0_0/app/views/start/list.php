<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="category" ng-controller="ListController as list">

    <div class="gae_manager_view-header">
        <div class="box-search">
            <div class="module-container">
                <input type="text" ng-model="list.search" class="new-search-btn" placeholder="Search Here">
            </div>
        </div>
    </div>
    <!--gae_manager_view-header-->

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
                    <div class="create-category-label">
                        Category Name
                    </div>
                    <div class="create-category-desc">
                        ชื่อหมวดสินค้า
                    </div>
                    <div class="create-category-parent-name">
                        <strong>{{list.placeholderSubCateName}}</strong>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" ng-model="list.subCategoryName" id="sub_category_name"
                               ng-keydown="list.keyDownRequired($event)">

                        <div class="add-warning hide" ng-hide='list.subCategoryName'></div>
                    </div>
                    <a class="btn-add extra-btn" ng-click="list.backCreateSubCate();">
                        <span></span>
                    </a>
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
                    <div>Category Label</div>
                    <div>Category Name</div>
                    <div>Visibility</div>
                    <div>Reorder</div>
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
                        <div class="item-label"
                             style="background-color:{{item.label_color}}; color: {{item.font_color}}">
                            {{item.name}}
                        </div>
                    </div>
                    <div>
                        <div>
                            <a class="btn-expand" ng-click="list.onClickExpand('lv2', item.referral_id, $event)"
                               ng-show="item.cate_child.length > 0">
                                <span></span>
                            </a>

                            <div class="item-name">{{item.name}} ({{item.cate_child_count}})</div>
                            <a class="btn-add-s"
                               ng-click="list.createSubCate(item.referral_id, 0, 0, item.name, '', '')">
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
                                <a class="btn-expand" ng-click="list.onClickExpand('lv3', v2.referral_id, $event)"
                                   ng-show="v2.cate_child.length > 0">
                                    <span></span>
                                </a>

                                <div class="item-name">{{v2.name}} ({{v2.cate_child_count}})</div>
                                <a class="btn-add-s"
                                   ng-click="list.createSubCate(item.referral_id, v2.referral_id, 0, item.name, v2.name, '')">
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
                                <div class="cate-lv3-box hide" id="cate-lv3-box-{{v2.referral_id}}">
                                    <div ng-repeat="(key3, v3) in v2.cate_child" class="cate-lv-3">
                                        <div class="clear"></div>
                                        <a class="btn-expand"
                                           ng-click="list.onClickExpand('lv4', v3.referral_id, $event)"
                                           ng-show="v3.cate_child.length > 0">
                                            <span></span>
                                        </a>

                                        <div class="item-name">{{v3.name}} ({{v3.cate_child_count}})</div>
                                        <a class="btn-add-s"
                                           ng-click="list.createSubCate(item.referral_id, v2.referral_id, v3.referral_id, item.name, v2.name, v3.name)">
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
                                        <div class="cate-lv4-box hide" id="cate-lv4-box-{{v3.referral_id}}">
                                            <div ng-repeat="(key4, v4) in v3.cate_child" class="cate-lv-4">
                                                <div class="clear"></div>
                                                <div class="item-name">{{v4.name}} ({{v4.cate_child_count}})</div>
                                                <a class="btn-edit"
                                                   ng-click="list.onClickEditSubCate(v4.referral_id, v4.name)">
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
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $(".btn-expand").click(function () {
                                if ($(this).attr("class") != 'btn-expand') {
                                    $(this).removeClass("btn-expand");
                                    $(this).addClass("btn-expand-up");
                                } else {
                                    $(this).removeClass("btn-expand-up");
                                    $(this).addClass("btn-expand");
                                }
                            });
                        });
                    </script>
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