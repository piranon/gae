angular.module('customerGroup').controller('AddController', function ($scope, $rootScope, $timeout, $window) {
  var id = getUrlParameter('id'),
      apiUrl,
      errorMessage;
  $scope.response = [];
  $scope.customers = [];
  $scope.customersSelected = [];
  $scope.customersSelectedId = [];
  $scope.clickOnSubmit = submit;
  $scope.selectedCustomer = function (seleted) {
    addCustomer(seleted);
  };
  $scope.submitCustomerInGroup = function () {
    addCustomer($scope.inputCustomer);
  };
  $scope.removeCustomer = function (id) {
    removeCustomer(id);
  };

  if (id) {
    var dataSend = {
      "id": id
    };
    CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
      $scope.$apply(function () {
        $scope.name = res.data.name;
        $scope.description = res.data.description;
        //$scope.customersSelected = res.data.customers;
        angular.forEach(res.data.customers, function (value, key) {
          value.image_url = null;
          if (value.image_id) {
            value.image_url = GURL.root_url() + 'root_images/' + value.file_dir + 'r100_' + value.file_name;
          }
          $scope.customersSelected.push(value);
          $scope.customersSelectedId.push(value.customer_id);
        });
      });
    });
  }
  CUR_MODULE.apiGet("start/customer_list").then(function (res) {
    $scope.response = res.data;
    $scope.$apply(function () {
      angular.forEach(res.data, function (value, key) {
        $scope.customers.push(value.first_name + ' ' + value.last_name);
      });
    });
  });

  function submit() {
    if ($scope.name && $scope.customersSelectedId.length > 0) {
      if (id) {
        apiUrl = 'start/update';
        errorMessage = 'Can not update customer group';
      } else {
        apiUrl = 'start/add';
        errorMessage = 'Can not create customer group';
      }
      var dataSend = {
        "id": id || '',
        "name": $scope.name || '',
        "description": $scope.description || '',
        "customer_ids": $scope.customersSelectedId || ''
      };
      CUR_MODULE.apiPost(apiUrl, dataSend).then(function (res) {
        if (res.ok) {
          $window.location.href = CUR_MODULE.data.app_url + 'start';
        } else {
          alert(errorMessage);
        }
      });
    } else {
      alert('Please fill-in required field');
    }
  }

  function removeCustomer(id) {
    $scope.customersSelected = $scope.customersSelected.filter(function (obj) {
      return obj.customer_id != id;
    });
    console.log($scope.customersSelectedId);
    $scope.customersSelectedId.splice($scope.customersSelectedId.indexOf(id), 1);
    console.log($scope.customersSelectedId);
  }

  function addCustomer(seleted) {
    var isFound = false,
        isAdded = false;
    angular.forEach($scope.response, function (value, key) {
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