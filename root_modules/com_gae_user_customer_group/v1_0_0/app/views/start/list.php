<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="customerGroup" ng-controller="ListController as list">

    <!-- ADD MODULE HTML BY AUTO LAYOUT -->
    <div class="gae_manager_view-module_bar-left">
        <div id="gae_module_bar_btn__1">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Create Customer Group</a>
        </div>
    </div>

    <div class="gae_manager_view-module_bar-right">
        <div id="gae_module_bar_btn__1"></div>
    </div>

    <div class="gae_manager_view-header">
        <div class="box-search">
            <div class="module-container">
                <input type="text" ng-model="list.search" class="new-search-btn" placeholder="Search Here">
            </div>
        </div>
    </div><!--gae_manager_view-header-->

    <div class="row customer-list">
        <div class="module-container">
            <div class="row customer-filter">
                <div class="col-sm-3">
                    <select ng-model="list.bulkDelete" ng-change="list.onChangeBulkDelete(list.bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-6">{{list.selectedDeleteId.length}} group selected from total {{list.total}} groups
                </div>
                <div class="col-sm-3">
                    <select ng-model="list.limitList" ng-change="list.onChangeLimit(list.limitList)"
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
                        <th style="width: 40px;">
                            <button class="circle-small-warning" type="button" ng-click="list.onClickBulkDeleteAll()"
                                    ng-class="{'active-discount' : list.deleteAll}">
                            </button>
                        </th>
                        <th style="width: 200px; cursor: pointer;" ng-click="list.onClickSort('name')">
                            Customer group name
                        </th>
                        <th style="width: 170px; cursor: pointer;" ng-click="list.onClickSort('count_customers')">
                            No. of customer
                        </th>
                        <th style="width: 100px; cursor: pointer;" ng-click="list.onClickSort('update_time')">Updated
                        </th>
                        <th style="width: 100px; cursor: pointer;" ng-click="list.onClickSort('create_time')">Created
                        </th>
                        <th style="width: 100px;"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in list.customers|orderBy:list.sortKey:reverse|filter:list.search|itemsPerPage:list.limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : list.deleteSelected(customer.customer_group_id)}"
                                    ng-click="list.onClickBulkDelete(customer.customer_group_id)">
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
                        <td class="list-action">
                            <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.customer_group_id}}"
                               class="btn-edit">
                                <span></span>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row" ng-show="list.customers.length">
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
            <div ng-hide="list.customers.length" class="row no-cusotmer">
                <div class="col-xs-12">
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/shape.png">

                    <div>ยังไม่มีกลุ่มลูกค้า ทำการสร้างกลุ่มลูกค้าได้โดยกดที่ปุ่ม Create Customer Group</div>
                </div>
            </div>
        </div>
    </div>
</div>
