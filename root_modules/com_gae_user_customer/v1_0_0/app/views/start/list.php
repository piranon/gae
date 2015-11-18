<link rel="stylesheet" href="<?php echo $curModule->file_url; ?>/css/base.css">
<style>
    .sort-icon {
        font-size: 9px;
        margin-left: 5px;
    }
    th {
        cursor:pointer;
    }
</style>
<div ng-app="angularTable">
    <div class="row top-navigation">
        <div class="col-md-4">
            <a class="btn-add" href="<?php echo $curModule->app_url; ?>start/add">Add Customer</a>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <input class="new-search-btn" id="table-search" type="text" placeholder="Search Here">
        </div>
    </div>
    <div role="main" class="container theme-showcase">
        <div class="" style="margin-top:90px;">
            <div class="col-lg-8">
                <div class="page-header">
                    <h2 id="tables">Search Sort and Pagination in Angular js</h2>
                </div>
                <form class="form-inline">
                    <div class="form-group">
                        <label >Search</label>
                        <input type="text" ng-model="search" class="form-control" placeholder="Search">
                    </div>
                </form>
                <div class="bs-component" ng-controller="listdata">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th ng-click="sort('id')">Id
                                <span class="glyphicon sort-icon" ng-show="sortKey=='id'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                            </th>
                            <th ng-click="sort('first_name')">First Name
                                <span class="glyphicon sort-icon" ng-show="sortKey=='first_name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                            </th>
                            <th ng-click="sort('last_name')">Last Name
                                <span class="glyphicon sort-icon" ng-show="sortKey=='last_name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                            </th>
                            <th ng-click="sort('hobby')">Hobby
                                <span class="glyphicon sort-icon" ng-show="sortKey=='hobby'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr dir-paginate="user in users|orderBy:sortKey:reverse|filter:search|itemsPerPage:5">
                            <td>{{user.id}}</td>
                            <td>{{user.first_name}}</td>
                            <td>{{user.last_name}}</td>
                            <td>{{user.hobby}}</td>
                        </tr>
                        </tbody>
                    </table>
                    <dir-pagination-controls
                        max-size="5"
                        direction-links="true"
                        boundary-links="true" >
                    </dir-pagination-controls>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var app = angular.module('angularTable', ['angularUtils.directives.dirPagination']);

    app.controller('listdata',function($scope, $http){
        $scope.users = []; //declare an empty array
        var response = [{"id":1,"first_name":"Heather","last_name":"Bell","hobby":"Eating"},
        {"id":2,"first_name":"Andrea","last_name":"Dean","hobby":"Gaming"},
        {"id":3,"first_name":"Peter","last_name":"Barnes","hobby":"Reading Books"},
        {"id":4,"first_name":"Harry","last_name":"Bell","hobby":"Youtubing"},
        {"id":5,"first_name":"Deborah","last_name":"Burns","hobby":"Fishing"},
        {"id":6,"first_name":"Larry","last_name":"Kim","hobby":"Skipping"},
        {"id":7,"first_name":"Jason","last_name":"Wallace","hobby":"Football"},
        {"id":8,"first_name":"Carol","last_name":"Williams","hobby":"Baseball"},
        {"id":9,"first_name":"Samuel","last_name":"Olson","hobby":"Programming"},
        {"id":10,"first_name":"Donna","last_name":"Evans","hobby":"Playing DOTA"},
        {"id":11,"first_name":"Lois","last_name":"Butler","hobby":"Gaming"},
        {"id":12,"first_name":"Daniel","last_name":"Hill","hobby":"surfing"},
        {"id":13,"first_name":"Matthew","last_name":"Torres","hobby":"cycling"},
        {"id":14,"first_name":"Jerry","last_name":"Hernandez","hobby":"Music"},
        {"id":15,"first_name":"Christopher","last_name":"Carpenter","hobby":"Football"},
        {"id":16,"first_name":"Harold","last_name":"West","hobby":"Gaming"},
        {"id":17,"first_name":"Carol","last_name":"Hicks","hobby":"Youtubing"},
        {"id":18,"first_name":"Bonnie","last_name":"Davis","hobby":"Partying"},
        {"id":19,"first_name":"Nancy","last_name":"Banks","hobby":"Photography"},
        {"id":20,"first_name":"Walter","last_name":"Freeman","hobby":"Tweeting"},
        {"id":21,"first_name":"Louis","last_name":"Gonzales","hobby":"Bloging"},
        {"id":22,"first_name":"Jean","last_name":"Watkins","hobby":"Bloging"},
        {"id":23,"first_name":"Albert","last_name":"Harris","hobby":"Music"},
        {"id":24,"first_name":"Billy","last_name":"Owens","hobby":"Camping"},
        {"id":25,"first_name":"Russell","last_name":"Patterson","hobby":"Singing"}];
//        $http.get("/mock.json").success(function(response){
            $scope.users = response;  //ajax request to fetch data into $scope.data
//        });
        $scope.sort = function(keyname){
            $scope.sortKey = keyname;   //set the sortKey to the param passed
            $scope.reverse = !$scope.reverse; //if true make it false and vice versa
        }
    });
</script>