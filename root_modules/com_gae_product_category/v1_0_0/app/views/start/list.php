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
            <div class="create-category">
                <div>
                    <div class="create-category-label">Category Name</div>
                    <div class="create-category-desc">ชื่อหมวดสินค้า</div>
                    <div><input type="text" class="form-control"></div>
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

                        <div class="track"></div>
                        <ul class="dropdown">
                            <li></li>
                        </ul>
                        <input type="hidden" class="colorInput"/>
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
                        <input type="hidden" class="colorInput"/>
                    </div>
                </div>
                <div>
                    <a href="#" class="btn-add">
                        <span></span>
                    </a>
                </div>
            </div>
            <div class="list-filter">
                <div>
                    <select ng-model="list.bulkDelete" ng-change="list.onChangeBulkDelete(list.bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div>&nbsp;
                    <div ng-show="list.customers">{{list.selectedDeleteId.length}} customer selected from total
                        {{list.total}} customers
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
                        <!--                <table class="datatable table tbl-restyled">-->
<!--                    <thead>-->
<!--                    <tr>-->
<!--                        <th style="">-->
<!--                            <button class="circle-small-warning" type="button" ng-click="list.onClickBulkDeleteAll()"-->
<!--                                    ng-class="{'active-discount' : list.deleteAll}">-->
<!--                            </button>-->
<!--                        </th>-->
<!--                        <th style="cursor: pointer;" ng-click="list.onClickSort('first_name')">-->
<!--                            Icon-->
<!--                        </th>-->
<!--                        <th style="cursor: pointer;" ng-click="list.onClickSort('user_name')">Category-->
<!--                            Label-->
<!--                        </th>-->
<!--                        <th style="cursor: pointer;" ng-click="list.onClickSort('email')">Category Name</th>-->
<!--                        <th style="">Visibility</th>-->
<!--                        <th style=" ">Reorder</th>-->
<!--                    </tr>-->
<!--                    </thead>-->
<!---->
<!--                    <tbody>-->
<!--                    <tr dir-paginate="(key, customer) in list.customers|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit">-->
<!--                        <td align="center">-->
<!--                            <button class="xChoose circle-small-warning" type="button"-->
<!--                                    ng-class="{'active-discount' : list.deleteSelected(customer.customer_id)}"-->
<!--                                    ng-click="list.onClickBulkDelete(customer.customer_id)">-->
<!--                            </button>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div class="tag-name">-->
<!--                                <a href="--><?php //echo $curModule->app_url; ?><!--start/detail?id={{customer.customer_id}}">-->
<!--                                    {{customer.first_name}} {{customer.last_name}}-->
<!--                                </a>-->
<!--                            </div>-->
<!--                            <div class="tag-group-name">-->
<!--                                <div ng-repeat="group in customer.groups">-->
<!--                                    <a href="--><?php //echo base_url(); ?><!--module/app/15/start/detail?id={{group.customer_group_id}}">-->
<!--                                        {{group.name}}-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="tag-customer" ng-show="customer.tag">-->
<!--                                Tag:-->
<!--                                <div class="list">{{customer.tag}}</div>-->
<!--                            </div>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div ng-show="customer.image_id" class="circle-size-80">-->
<!--                                <img-->
<!--                                    ng-src="--><?php //echo root_url(), 'root_images/'; ?><!--{{customer.file_dir}}r100_{{customer.file_name}}">-->
<!--                            </div>-->
<!--                            <div ng-hide="customer.image_id" class="circle-size-80"></div>-->
<!--                            <div class="tag-username">{{customer.user_name}}</div>-->
<!--                        </td>-->
<!--                        <td>-->
<!--                            <div class="tag-email">{{customer.email}}</div>-->
<!--                            <div class="tag-tel">{{customer.phone}}</div>-->
<!--                        </td>-->
<!--                        <td>0</td>-->
<!--                        <td class="text-center">-->
<!--                            <a ng-show="customer.status == 1"-->
<!--                               ng-click="list.setStatusBlock(customer.customer_id, customer.status)"-->
<!--                               class="btn-block">-->
<!--                                <span></span>-->
<!--                            </a>-->
<!--                            <a ng-show="customer.status == 2"-->
<!--                               ng-click="list.setStatusBlock(customer.customer_id, customer.status)"-->
<!--                               class="btn-block btn-block-selected">-->
<!--                                <span></span>-->
<!--                            </a>-->
<!--                            <a href="--><?php //echo $curModule->app_url; ?><!--start/add?id={{customer.customer_id}}"-->
<!--                               class="btn-edit">-->
<!--                                <span></span>-->
<!--                            </a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    </tbody>-->
<!--                </table>-->
            </div>
            <div class="row" ng-show="list.customers">
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
            <div ng-hide="list.customers" class="clearfix row no-customer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/no_item.png">

                    <div>ยังไม่มีหมวดสินค้า ทำการเพิ่มหมวดสินค้าได้ที่ด้านบน</div>
                </div>
            </div>
        </div>
    </div>
</div>
