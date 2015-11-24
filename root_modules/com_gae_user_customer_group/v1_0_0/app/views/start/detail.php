<div ng-app="customerGroup">
    <div class="top-navigation">
        <div class="row module-container">
            <div class="col-md-4">
                <a class="btn-cancle" href="<?php echo $curModule->app_url; ?>start">Back</a>
            </div>
            <div class="col-md-4 topic-page">Customer Group Detail</div>
        </div>
    </div>
    <div class="row customer-list" ng-controller="DetailController">
        <div class="module-container">
            <div class="row group-info">
                <div class="col-lg-9">
                    <div class="group-name">{{group.name}}</div>
                    <div class="group-customers">{{total}} customers</div>
                    <div class="group-description">{{group.description}}</div>
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
                    <select ng-model="bulkDelete" ng-change="onChangeBulkDelete(bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-6">{{selectedDeleteId.length}} customers selected from total {{total}} customers
                </div>
                <div class="col-sm-3">
                    <select ng-model="limitList" ng-change="onChangeLimit(limitList)" class="form-control view-limit">
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
                            <button class="circle-small-warning" type="button" ng-click="onClickBulkDeleteAll()"
                                    ng-class="{'active-discount' : deleteAll}">
                            </button>
                        </th>
                        <th style="width: 137px; cursor: pointer;" ng-click="onClickSort('first_name')">Name</th>
                        <th style="width: 127px; cursor: pointer;" ng-click="onClickSort('user_name')">Username</th>
                        <th style="width: 246px; cursor: pointer;" ng-click="onClickSort('email')">Email/Phone</th>
                        <th style="width: 70px;">Order</th>
                        <th style="width: 70px;">Total Pay</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in customers|orderBy:sortKey:reverse|filter:search|itemsPerPage:limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : deleteSelected(customer.customer_id)}"
                                    ng-click="onClickBulkDelete(customer.customer_id)">
                            </button>
                        </td>
                        <td>
                            <br>
                            <a href="<?php echo $curModule->app_url; ?>start/detail?id={{customer.customer_id}}">
                                {{customer.first_name}} {{customer.last_name}}
                            </a>

                            <div class="tag-customer" ng-show="user.tag">
                                Tag:
                                <div class="list">{{user.tag}}</div>
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
            <div class="row" ng-show="customers">
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
            <div ng-hide="customers" class="row no-cusotmer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/shape_customer.png">

                    <div>ไม่มีลูกค้าที่ถูกจัดเข้ากลุ่มนี้</div>
                </div>
            </div>
        </div>
    </div>
</div>
