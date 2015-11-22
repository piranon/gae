angular.module('customerGroup').controller('AddController', function ($scope, $rootScope, $timeout, $window) {
  $scope.response = [];
  $scope.customers = [];
  $scope.customersSelected = [];
  $scope.customersSelectedId = [];
  $scope.clickOnSubmit = submit;
  $scope.selectedCustomer = function(seleted){
    addCustomer(seleted);
  };
  $scope.submitCustomerInGroup = function () {
    addCustomer($scope.inputCustomer);
  };
  $scope.removeCustomer = function (id) {
    removeCustomer(id);
  };

  CUR_MODULE.apiGet("start/customer_list").then(function (res) {
    $scope.response = res.data;
    $scope.$apply(function () {
      angular.forEach(res.data, function(value, key) {
        $scope.customers.push(value.first_name + ' ' + value.last_name);
      });
    });
  });

  function submit() {
    if ($scope.name && $scope.customersSelectedId.length > 0) {
      var dataSend = {
        "name": $scope.name || '',
        "description": $scope.description || '',
        "customer_ids": $scope.customersSelectedId || ''
      };
      CUR_MODULE.apiPost('start/add', dataSend).then(function (res) {
        if (res.ok) {
          $window.location.href = CUR_MODULE.data.app_url + 'start';
        } else {
          alert('Can not create customer group');
        }
      });
    } else {
      alert('Please fill-in required field');
    }
  }

  function removeCustomer(id) {
    $scope.customersSelected = $scope.customersSelected.filter(function( obj ) {
      return obj.customer_id != id;
    });
    console.log($scope.customersSelectedId);
    $scope.customersSelectedId.splice($scope.customersSelectedId.indexOf(id),1);
    console.log($scope.customersSelectedId);
  }

  function addCustomer(seleted) {
    var isFound = false,
        isAdded = false;
    angular.forEach($scope.response, function(value, key) {
      var name = value.first_name + ' ' + value.last_name;
      if (name != seleted) {
        return true;
      }
      if ($scope.customersSelectedId.indexOf(value.customer_id) > -1) {
        isAdded = true;
        return true;
      }
      value.image_url = null;
      if (value.image_id) {
        value.image_url = GURL.root_url() + 'root_images/' + value.file_dir + 'r100_' + value.file_name;
      }
      $scope.customersSelectedId.push(value.customer_id);
      $scope.customersSelected.unshift(value);
      isFound = true;
    });
    $scope.inputCustomer = '';
    if (isAdded) {
      isFound = true;
      alert('The customer has already added');
    }
    if (!isFound) {
      alert('Not found customer');
    }
  }

});
angular.module('customerGroup').directive('addCustomer', function(){
  return {
    template: '\
      <div class="row">\
        <div class="col-md-3"></div>\
          <div class="col-md-8"><div>\
            <div class="row">\
              <div class="col-md-12 customer-selected-box">\
                <div class="row">\
                  <div class="col-md-2">\
                    <div class="circle-size-80">\
                      <img ng-show="customerSelected.image_url" src="{{customerSelected.image_url}}">\
                    </div>\
                  </div>\
                  <div class="col-md-10">\
                    <div class="name">{{customerSelected.first_name}} {{customerSelected.last_name}}</div>\
                    <div class="username">{{customerSelected.user_name}}</div>\
                  </div>\
                </div>\
              </div>\
            </div>\
          </div>\
        </div>\
        <div class="col-md-1">\
          <a href="" class="btn-circle-gray" ng-click="removeCustomer(customerSelected.customer_id);">\
            <span class="glyphicon glyphicon-trash"></span>\
          </a>\
        </div>\
      </div>',
    scope: false
  };
});
function getUrlParameter(param, dummyPath) {
  var sPageURL = dummyPath || window.location.search.substring(1),
      sURLVariables = sPageURL.split(/[&||?]/),
      res;

  for (var i = 0; i < sURLVariables.length; i += 1) {
    var paramName = sURLVariables[i],
        sParameterName = (paramName || '').split('=');

    if (sParameterName[0] === param) {
      res = sParameterName[1];
    }
  }

  return res;
}