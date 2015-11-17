var userCustomer = angular.module('userCustomer', ['ngRoute', 'GAEAPI', 'file-model']);
userCustomer.controller('CustomerAddCtrl', function ($scope, $rootScope, $timeout, $window, GAEAPI) {
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
    if ($scope.username && $scope.password && $scope.password2) {
      if ($scope.password === $scope.password2) {
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
        }
        CUR_MODULE.apiPost('start/add', dataSend).then(function (res) {
          if (res.ok && res.data.customer_id) {
            $window.location.href = CUR_MODULE.data.app_url + 'start';
          } else {
            alert("Error: Can not create customer");
          }
        });
      } else {
        alert("Password does not match!");
      }
    } else {
      alert("Please fill-in required field");
    }
  };
});
userCustomer.directive("fileread", [function () {
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
function PreviewImage() {
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("imageCategory").files[0]);
  oFReader.onload = function (oFREvent) {
    document.getElementById("area-inner-image").src = oFREvent.target.result;
    document.getElementById("area-inner-image").setAttribute('style', 'width:auto !important;');
  };
}
$('.date').datepicker({
  format: "yyyy-mm-dd",
  language: "th",
  autoclose: true,
  todayHighlight: true
});