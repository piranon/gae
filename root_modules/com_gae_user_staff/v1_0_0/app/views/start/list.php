<div class="gae_manager_view-footer"></div><!--gae_manager_view-header-->

<div ng-app="staff" ng-controller="ListController as list">

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
                        {{list.selectedDeleteId.length}} staff selected from total {{list.total}} staffs
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
                        <th style="width: 179px; cursor: pointer;" ng-click="list.onClickSort('first_name')">
                            Staff Name
                        </th>
                        <th style="width: 150px; cursor: pointer;" ng-click="list.onClickSort('user_name')">Staff Pic
                        </th>
                        <th style="width: 200px; cursor: pointer;" ng-click="list.onClickSort('email')">Email/Phone</th>
                        <th style="width: 120px;">User Role</th>
                        <th style="width: 75px;">Last Login</th>
                        <th style="width: 70px;"></th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in list.customers|orderBy:list.sortKey:list.reverse|filter:list.search|itemsPerPage:list.limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button"
                                    ng-class="{'active-discount' : list.deleteSelected(customer.staff_id)}"
                                    ng-click="list.onClickBulkDelete(customer.staff_id)">
                            </button>
                        </td>
                        <td>
                            <div class="tag-name">
                                <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.staff_id}}">
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
                            <div class="tag-username">{{customer.user_name}}</div>
                        </td>
                        <td>
                            <div class="tag-email">{{customer.email}}</div>
                            <div class="tag-tel">{{customer.phone}}</div>
                        </td>
                        <td>0</td>
                        <td>0</td>
                        <td class="text-center">
                            <a ng-show="customer.status == 1"
                               ng-click="list.setStatusBlock(customer.staff_id, customer.status)"
                               class="btn-block">
                                <span></span>
                            </a>
                            <a ng-show="customer.status == 2"
                               ng-click="list.setStatusBlock(customer.staff_id, customer.status)"
                               class="btn-block btn-block-selected">
                                <span></span>
                            </a>
                            <a href="<?php echo $curModule->app_url; ?>start/add?id={{customer.staff_id}}"
                               class="btn-edit">
                                <span></span>
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
                    <img ng-src="<?php echo $curModule->file_url; ?>icon/icon_dashobard_staff.png">

                    <div>ยังไม่มีรายชื่อเจ้าหน้าที่ ทำการเพิ่มเจ้าหน้าที่ได้เองโดยกดที่ปุ่ม Add New Staff</div>
                </div>
            </div>
        </div>
    </div>
</div>
