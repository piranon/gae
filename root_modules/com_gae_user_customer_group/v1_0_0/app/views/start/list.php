<div ng-app="customerGroup">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Customer Group Name</a>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
    </div>
    <div class="row customer-list" ng-controller="ListController">
        <div class="col-lg-12">
            <div class="row customer-filter">
                <div class="col-sm-2">
                    <select ng-model="bulkDelete" ng-change="onChangeBulkDelete(bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-2">{{selectedDeleteId.length}} item selected</div>
                <div class="col-sm-2">total {{total}} customers</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <select ng-model="limitList" ng-change="onChangeLimit(limitList)" class="form-control">
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
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </th>
                        <th style="width: 207px; cursor: pointer;" ng-click="onClickSort('name')">
                            Customer group name
                        </th>
                        <th style="width: 157px; cursor: pointer;" ng-click="onClickSort('count_customers')">
                            No. of customer
                        </th>
                        <th style="width: 127px; cursor: pointer;" ng-click="onClickSort('update_time')">Updated</th>
                        <th style="width: 127px; cursor: pointer;" ng-click="onClickSort('create_time')">Created</th>
                        <th style="width: 70px;"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in customers|orderBy:sortKey:reverse|filter:search|itemsPerPage:limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : deleteSelected(customer.customer_group_id)}"
                                    ng-click="onClickBulkDelete(customer.customer_group_id)">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </td>
                        <td>
                            <a href="<?php echo $curModule->app_url; ?>start/detail?id={{customer.customer_group_id}}">
                                {{customer.name}}
                            </a>
                        </td>
                        <td>{{customer.count_customers}}</td>
                        <td>{{customer.update_time}}</td>
                        <td>{{customer.create_time}}</td>
                        <td>
                            <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.customer_group_id}}"
                               class="btn-edit text-center">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
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
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/shape.png">

                    <div>ยังไม่มีกลุ่มลูกค้า ทำการสร้างกลุ่มลูกค้าได้โดยกดที่ปุ่ม Create Customer Group</div>
                </div>
            </div>
        </div>
    </div>
</div>
