<link rel="stylesheet" href="<?php echo $curModule->file_url; ?>/css/base.css">
<style>
    .col-lg-12 {
        padding-left: 7px;
        padding-right: 7px;
    }

    body {
        margin: 0;
        outline: 0;
        border: 0;
        font-size: 16px;
        font-weight: normal;
        color: #454547;
        font-family: 'Source Sans Pro', sans-serif;
        background-color: #ffffff;
    }

    body {
        background-size: 100%;
        position: relative;
        height: 100%;
    }

    .customer-list {
        clear: both;
        margin-top: 15px;
    }

    .customer-filter {
        margin-top: 10px;
    }

    .customer-filter .col-sm-6 {
        text-align: right;
    }

    .customer-filter > div + div, .customer-filter > div + div + div {
        color: #ff7522;
    }

    .customer-limit {
        margin-top: 10px;
    }

    .customer-table {
        margin-top: 10px;
    }

    table.table {
        clear: both;
        margin-top: 6px !important;
        margin-bottom: 6px !important;
        max-width: none !important;
    }

    .tbl-restyled {
        width: 100%;
        height: auto;
        position: relative;
        font-size: .9em;
        border: 0px !important;
    }

    .circle-small-warning {
        background-color: inherit;
        border: 0px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        outline: 0px;
        border: 1px solid #c8c8c8;
        background-color: white;
        color: white;
        margin: 9px 7px 0 0;
        float: left;
    }

    .table > thead:first-child > tr:first-child > th {
        color: #666;
        font-weight: bold;
        font-size: 13px;
        vertical-align: middle;
    }

    .circle-small-warning:hover {
        background-color: #ff3500;
    }

    .circle-small-warning .glyphicon {
        font-size: .9em;
        margin-left: -0.1em;
    }

    .tbl-restyled tbody tr td {
        border: 0px solid !important;
        padding-top: 7px;
        background-color: white !important;
        border-left: 0px !important;
        border-right: 0px !important;
        line-height: 2.5em;
        font-size: 1.2em;
    }

    .tbl-restyled tbody tr td .xChoose .glyphicon {
        position: relative;
        top: -8px;
        left: -1px;
    }

    .datatable tbody {
        font-size: 12px;
    }

    .tbl-restyled tbody tr {
        padding-bottom: 10px;
        border: 0px !important;
        border-bottom: 1px solid #E4E2E2 !important;
    }

    .tag-group-name {
        background-color: #333333;
        width: 70%;
        color: white;
        text-align: center;
        height: 26px;
        border-radius: 20px;
        line-height: 2.4em;
        font-weight: 300;
        font-size: .8em;
    }

    .tag-customer {
        clear: both;
        color: #ff5000;
        font-size: .85em;
    }

    .tag-customer .list {
        text-decoration: underline;
        display: inline;
        margin-left: 5px;
        padding-bottom: 3px;
    }

    .btn-circle-orange {
        float: left;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        outline: 0px;
        border: 0px;
        background-color: #f9a157;
        color: white;
        margin: 0 5px;
        -webkit-transition: all 0.5s linear;
        -o-transition: all 0.5s linear;
        -moz-transition: all 0.5s linear;
        transition: all 0.5s linear;
    }

    .btn-circle-red {
        float: left;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        outline: 0px;
        border: 0px;
        background-color: #ff1d1d;
        color: white;
        margin: 0 5px;
        -webkit-transition: all 0.5s linear;
        -o-transition: all 0.5s linear;
        -moz-transition: all 0.5s linear;
        transition: all 0.5s linear;
    }

    .circle-size-80 img {
        max-height: 80px;
        height: 80px;
        width: auto;
        border-radius: 50%;
    }

    div.dataTables_info {
        padding-top: 8px;
    }

    .dataTables_info {
        clear: both;
        float: left;
    }

    div.dataTables_paginate {
        float: right;
        margin: 0;
        margin-right: 8px;
    }

    .dataTables_paginate {
        float: right;
        text-align: right;
    }

    div.dataTables_paginate ul.pagination {
        margin: 2px;
    }

    .pagination {
        font-family: sans-serif;
        font-size: 11px;
        font-weight: 100 !important;
    }

    .pagination > .active > a {
        border-color: white;
        background-color: #FCD4AF !important;
        color: #490303 !important;
    }

    .pagination > li > a, .pagination > li > span {
        background-color: #ff7217 !important;
        color: white !important;
        font-weight: 100;
        font-family: sans-serif;
        margin: 0 2px 02px;
        border: 0px;
        border-radius: 5px;
    }
</style>
<div ng-app="angularTable">
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
                                <img src="<?php echo root_url(), 'root_images/'; ?>{{customer.file_dir}}r100_{{customer.file_name}}">
                            </div>
                            <div ng-hide="customer.image_id" class="circle-size-80"></div>
                            {{customer.user_name}}
                        </td>
                        <td>{{customer.email}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="text-center">
                            <a href="#">
                                <button type="button" class="btn-circle-orange"
                                        style="background-color: #C2A717;">
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                </button>
                            </a>
                            <a href="#">
                                <button type="button" class="btn-circle-orange">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </button>
                            </a>
                            <a href="#">
                                <button class="btn-circle-red" type="button">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-xs-6">
<!--                    <div class="dataTables_info" id="DataTables_Table_0_info">-->
<!--                        Showing {{range.lower}} to {{range.upper}} of {{total}} entries-->
<!--                    </div>-->
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
<script>
    var app = angular.module('angularTable', ['angularUtils.directives.dirPagination']);

    app.controller('listdata', function ($scope) {
        $scope.customers = [];
        $scope.total = 0;
        $scope.limit = 10;
        CUR_MODULE.apiGet("start/listing").then(function (res) {
            $scope.$apply(function () {
                $scope.customers = res.data;
                $scope.total = res.data.length
            });
        });
        $scope.changeLimit = function (limitList) {
            $scope.limit = limitList || 10;
        };
        // sort
        $scope.sort = function (keyname) {
            if (keyname == 'order' || keyname == 'pay') {
                return false;
            }
            $scope.sortKey = keyname || 'create_time';   //set the sortKey to the param passed
            $scope.reverse = true;
        }
    });
</script>