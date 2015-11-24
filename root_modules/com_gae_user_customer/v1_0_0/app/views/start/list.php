<div ng-app="customer"  ng-controller="ListController as list">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Add Customer</a>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <input type="text" ng-model="list.search" class="new-search-btn" placeholder="Search Here">
        </div>
    </div>
    <div class="row customer-list">
        <div class="col-lg-12">
            <div class="row customer-filter">
                <div class="col-sm-2">
                    <select ng-model="list.bulkDelete" ng-change="list.onChangeBulkDelete(bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-2">{{list.selectedDeleteId.length}} item selected</div>
                <div class="col-sm-2">total {{list.total}} customers</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <select ng-model="list.limitList" ng-change="list.onChangeLimit(limitList)" class="form-control">
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
                            <button class="circle-small-warning" type="button" ng-click="list.onClickBulkDeleteAll()"
                                    ng-class="{'active-discount' : list.deleteAll}">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </th>
                        <th style="width: 137px; cursor: pointer;" ng-click="list.onClickSort('first_name')">Name/Group</th>
                        <th style="width: 127px; cursor: pointer;" ng-click="list.onClickSort('user_name')">Username</th>
                        <th style="width: 246px; cursor: pointer;" ng-click="list.onClickSort('email')">Email/Phone</th>
                        <th style="width: 70px;">Order</th>
                        <th style="width: 70px;">Total Pay</th>
                        <th style="width: 166px;">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in list.customers|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : list.deleteSelected(list.customer.customer_id)}"
                                    ng-click="list.onClickBulkDelete(customer.customer_id)">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </td>
                        <td>
                            <div class="tag-name">
                                <a href="<?php echo $curModule->app_url; ?>start/detail?id={{customer.customer_id}}">
                                    {{customer.first_name}} {{customer.last_name}}
                                </a>
                            </div>
                            <div class="tag-group-name">
                                <div ng-repeat="group in customer.groups">
                                    <a href="<?php echo base_url(); ?>module/app/15/start/detail?id={{group.customer_group_id}}">
                                        {{group.name}}
                                    </a>
                                </div>
                            </div>
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
                        <td class="text-center">
                            <button type="button" ng-show="customer.status == 1"
                                    ng-click="list.setStatusBlock(customer.customer_id, customer.status)"
                                    class="btn-block">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                            <button type="button" ng-show="customer.status == 2"
                                    ng-click="list.setStatusBlock(customer.customer_id, customer.status)"
                                    class="btn-block btn-block-selected">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                            <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.customer_id}}"
                               class="btn-edit">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
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
            <div ng-hide="list.customers" class="row no-cusotmer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/shape.png">

                    <div>ยังไม่มีรายชื่อลูกค้า ทำการเพิ่มลูกค้าสามาชิกได้เองโดยกดที่ปุ่ม Add customer</div>
                </div>
            </div>
        </div>
    </div>
</div>
