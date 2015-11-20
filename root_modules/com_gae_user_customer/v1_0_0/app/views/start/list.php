<div ng-app="customer">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Add Customer</a>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <input type="text" ng-model="search" class="new-search-btn" placeholder="Search Here">
        </div>
    </div>
    <div class="row customer-list" ng-controller="listdata">
        <div class="col-lg-12">
            <div class="row customer-filter">
                <div class="col-sm-2">
                    <select class="form-control ng-pristine ng-valid ng-touched">
                        <option value="">Bulk Action</option>
                        <option value="3">Delete Selected</option>
                    </select>
                </div>
                <div class="col-sm-2">0 item selected</div>
                <div class="col-sm-2">total {{total}} customers</div>
                <div class="col-sm-3"></div>
                <div class="col-sm-3">
                    <select ng-model="sortList" ng-change="sort(sortList)" class="form-control">
                        <option value="">Sort By Date Added</option>
                        <option value="update_time">Sort By Date Modified</option>
                        <option value="user_name">Sort By Name</option>
                        <option value="order">Sort By Order</option>
                        <option value="pay">Sort By Total Pay</option>
                    </select>
                </div>
            </div>
            <div class="row customer-limit">
                <div class="col-sm-1">
                    <select ng-model="limitList" ng-change="changeLimit(limitList)" class="form-control">
                        <option value="">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-sm-11">records per page</div>
            </div>
            <div class="row customer-table">
                <table class="datatable table tbl-restyled">
                    <thead>
                    <tr>
                        <th style="width: 31px;">
                            <button class="circle-small-warning" type="button">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </th>
                        <th style="width: 137px;">Name</th>
                        <th style="width: 127px;">Username</th>
                        <th style="width: 246px;">Email</th>
                        <th style="width: 70px;">Order</th>
                        <th style="width: 70px;">Total Pay</th>
                        <th style="width: 166px;">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr dir-paginate="customer in customers|orderBy:sortKey:reverse|filter:search|itemsPerPage:limit">
                        <td align="center">
                            <button class="xChoose circle-small-warning" type="button">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                        </td>
                        <td>
                            <br>

                            <div class="tag-group-name">
                                No Group
                            </div>
                            <div class="tag-customer" ng-show="user.tag">
                                Tag:
                                <div class="list">{{user.tag}}</div>
                            </div>
                        </td>
                        <td>
                            <div ng-show="customer.image_id" class="circle-size-80">
                                <img
                                    src="<?php echo root_url(), 'root_images/'; ?>{{customer.file_dir}}r100_{{customer.file_name}}">
                            </div>
                            <div ng-hide="customer.image_id" class="circle-size-80"></div>
                            {{customer.user_name}}
                        </td>
                        <td>{{customer.email}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="text-center">
                            <a href="<?php echo $curModule->app_url; ?>start/detail?id={{customer.customer_id}}">
                                <button type="button" class="btn-circle-orange"
                                        style="background-color: #C2A717;">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </button>
                            </a>
                            <a href="">
                                <button type="button" class="btn-circle-orange">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                            </a>
                            <button class="btn-circle-red" type="button"
                                    confirmed-click="clickOnDelete({{customer.customer_id}})"
                                    ng-confirm-click="Confirm ?">
                                <span class="glyphicon glyphicon-trash"></span>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
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
        </div>
    </div>
</div>
