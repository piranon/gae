<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="customerGroup" ng-controller="DetailController as detail">

    <!-- ADD MODULE HTML BY AUTO LAYOUT -->
    <div class="gae_manager_view-module_bar-left">
        <div id="gae_module_bar_btn__1">
            <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Back</a>
        </div>
    </div>

    <div class="gae_manager_view-module_bar-right">
        <div id="gae_module_bar_btn__1"></div>
    </div>

    <div class="gae_manager_view-header"></div><!--gae_manager_view-header-->

    <div class="row customer-list">
        <div class="module-container">
            <div class="row group-info">
                <div class="col-lg-9">
                    <div class="group-name">{{detail.group.name}}</div>
                    <div class="group-customers">{{detail.total}} customers</div>
                    <div class="group-description">{{detail.group.description}}</div>
                </div>
                <div class="col-lg-3">
                    <div class="detail-complete-order">
                        <div class="desc">Completed Order</div>
                        <div class="info">0.00</div>
                        <div class="desc2">From Total 0.00 THB</div>
                    </div>
                </div>
            </div>
            <div class="row customer-filter">
                <div class="col-sm-3">
                    <select ng-model="detail.bulkDelete" ng-change="detail.onChangeBulkDelete(detail.bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-6">{{detail.selectedDeleteId.length}} customers selected from total {{detail.total}}
                    customers
                </div>
                <div class="col-sm-3">
                    <select ng-model="detail.limitList" ng-change="detail.onChangeLimit(detail.limitList)"
                            class="form-control view-limit">
                        <option value="">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="row customer-table">
                <table class="datatable table tbl-restyled">
                    <thead>
                    <tr>
                        <th style="width: 31px;">
                            <button class="circle-small-warning" type="button" ng-click="detail.onClickBulkDeleteAll()"
                                    ng-class="{'active-discount' : detail.deleteAll}">
                            </button>
                        </th>
                        <th style="width: 137px; cursor: pointer;" ng-click="detail.onClickSort('first_name')">Name</th>
                        <th style="width: 127px; cursor: pointer;" ng-click="detail.onClickSort('user_name')">Username
                        </th>
                        <th style="width: 246px; cursor: pointer;" ng-click="detail.onClickSort('email')">Email/Phone
                        </th>
                        <th style="width: 70px;">Order</th>
                        <th style="width: 70px;">Total Pay</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in detail.customers|orderBy:detail.sortKey:reverse|filter:detail.search|itemsPerPage:detail.limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : detail.deleteSelected(customer.customer_id)}"
                                    ng-click="detail.onClickBulkDelete(customer.customer_id)">
                            </button>
                        </td>
                        <td>
                            <br>
                            <a href="<?php echo $curModule->app_url; ?>start/detail?id={{customer.customer_id}}">
                                {{customer.first_name}} {{customer.last_name}}
                            </a>

                            <div class="tag-customer" ng-show="customer.tag">
                                Tag:
                                <div class="list">{{customer.tag}}</div>
                            </div>
                        </td>
                        <td>
                            <div ng-show="customer.image_id" class="circle-size-80">
                                <img
                                    ng-src="<?php echo root_url(), 'root_images/'; ?>{{customer.file_dir}}r100_{{customer.file_name}}">
                            </div>
                            <div ng-hide="customer.image_id" class="circle-size-80"></div>
                            {{customer.user_name}}
                        </td>
                        <td>
                            <div>{{customer.email}}</div>
                            <div>{{customer.phone}}</div>
                        </td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" ng-show="detail.customers.length">
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
            <div ng-hide="detail.customers.length" class="row no-cusotmer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/shape_customer.png">

                    <div>ไม่มีลูกค้าที่ถูกจัดเข้ากลุ่มนี้</div>
                </div>
            </div>
        </div>
    </div>
</div>
