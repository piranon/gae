<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="staffGroup" ng-controller="ListController as list">

    <!-- ADD MODULE HTML BY AUTO LAYOUT -->
    <div class="gae_manager_view-module_bar-left">
        <div id="gae_module_bar_btn__1">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Create User Role</a>
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

    <div class="customer-list">
        <div class="module-container">
            <div class="row customer-filter">
                <div class="col-sm-3">
                    <select ng-model="list.bulkDelete" ng-change="list.onChangeBulkDelete(list.bulkDelete)"
                            class="form-control ng-pristine ng-valid ng-touched bulk-delete">
                        <option value="">Bulk Action</option>
                        <option value="1">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <span ng-show="list.customers">
                        {{list.selectedDeleteId.length}} role selected from total {{list.total}} roles
                    </span>
                </div>
                <div class="col-sm-3">
                    <select ng-model="list.limitList" ng-change="list.onChangeLimit(limitList)"
                            class="form-control view-limit">
                        <option value="">View 10</option>
                        <option value="25">View 25</option>
                        <option value="50">View 50</option>
                        <option value="100">View 100</option>
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
                            User Role Name
                        </th>
                        <th style="width: 150px; cursor: pointer;" ng-click="list.onClickSort('count_staff')">No. of
                            Staff
                        </th>
                        <th style="width: 130px; cursor: pointer;" ng-click="list.onClickSort('updated')">Updated</th>
                        <th style="width: 80px;" ng-click="list.onClickSort('created')">Created</th>
                        <th style="width: 70px;"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in list.customers|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : list.deleteSelected(customer.staff_group_id)}"
                                    ng-click="list.onClickBulkDelete(customer.staff_group_id)">
                            </button>
                        </td>
                        <td>
                            <div class="tag-name">
                                <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.staff_group_id}}">
                                    {{customer.name}}
                                </a>
                            </div>
                        </td>
                        <td>{{customer.count_staffs}}</td>
                        <td>{{customer.update_time}}</td>
                        <td>{{customer.create_time}}</td>
                        <td class="text-center">
                            <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.staff_group_id}}"
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
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/icon_dashobard_staff.png">

                    <div>ยังไม่มีระดับการเข้าถึงระบบหลังร้าน ทำการสร้างได้โดยกดที่ปุ่ม Create User Role</div>
                </div>
            </div>
        </div>
    </div>
</div>
