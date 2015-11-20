angular.module('customer').controller('CustomerAddCtrl', function ($scope, $rootScope, $timeout, $window, GAEAPI) {
  $scope.inputType = 'password';
  $scope.showPassword = function(){
    if ($scope.inputType == 'password')
      $scope.inputType = 'text';
    else
      $scope.inputType = 'password';
  };
  $scope.clickOnUpload = function () {
    $timeout(function () {
      angular.element('#imageCategory').trigger('click');
    }, 100);
  };
  $scope.clickOnSubmit = function () {
    $timeout(function () {
      angular.element('#submit').trigger('click');
    }, 100);
  };
  $scope.submit = function () {
    var isValid = $scope.username && $scope.email && $scope.firstname && $scope.lastname && $scope.password;
    if (isValid) {
      var dataSend = {
        "username": $scope.username || '',
        "first_name": $scope.firstname || '',
        "last_name": $scope.lastname || '',
        "birthday": $scope.birthday || '',
        "gender": $scope.gender || '',
        "email": $scope.email || '',
        "phone": $scope.phone || '',
        "tag": $scope.tag || '',
        "password": $scope.password || '',
        "profile_pic": $scope.fileModel
      };
      CUR_MODULE.apiPost('start/add', dataSend).then(function (res) {
        if (res.ok) {
          $window.location.href = CUR_MODULE.data.app_url + 'start';
        } else {
          alert("Error: Can not create customer");
        }
      });
    } else {
      alert("Please fill-in required field");
    }
  };
});
angular.module('customer').directive("fileread", [function () {
  return {
    scope: {
      fileread: "="
    },
    link: function (scope, element, attributes) {
      element.bind("change", function (changeEvent) {
        var reader = new FileReader();
        reader.onload = function (loadEvent) {
          scope.$apply(function () {
            scope.fileread = loadEvent.target.result;
          });
        }
        reader.readAsDataURL(changeEvent.target.files[0]);
      });
    }
  }
}]);