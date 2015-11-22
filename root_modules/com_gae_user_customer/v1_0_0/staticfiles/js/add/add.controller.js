angular.module('customer').controller('CustomerAddCtrl', function ($scope, $rootScope, $timeout, $window, GAEAPI) {
  var id = getUrlParameter('id'),
      apiUrl,
      errorMessage;
  $scope.imageProfile = '';
  $scope.inputType = 'password';
  $scope.groupOption = [];
  $scope.sexOption = [
    {name: 'male', value: '1'},
    {name: 'female', value: '2'}
  ];
  if (id) {
    var dataSend = {
      "id": id
    };
    CUR_MODULE.apiGet('start/detail', dataSend).then(function (res) {
      $scope.$apply(function () {
        $scope.username = res.data.user_name;
        $scope.email = res.data.email;
        $scope.firstname = res.data.first_name;
        $scope.lastname = res.data.last_name;
        $scope.phone = res.data.phone;
        $scope.birthday = res.data.birthday;
        $scope.gender = $scope.sexOption[res.data.gender_type_id];
        $scope.tag = res.data.tag;
        $scope.password = res.data.password;
        if (res.data.image_id) {
          $scope.imageProfile = GURL.root_url() + 'root_images/' + res.data.file_dir + 'r200_' + res.data.file_name;
        }
      });
    });
  }

  CUR_MODULE.apiGet('start/list_group').then(function (res) {
    $scope.$apply(function () {
      $scope.groupOption = res.data;
    });
  });

  $scope.showPassword = function () {
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
    if ($scope.username && $scope.email && $scope.firstname && $scope.lastname && $scope.password) {
      if (id) {
        apiUrl = 'start/update';
        errorMessage = 'Can not update customer';
      } else {
        apiUrl = 'start/add';
        errorMessage = 'Can not create customer';
      }
      var dataSend = {
        "id": id || '',
        "username": $scope.username || '',
        "first_name": $scope.firstname || '',
        "last_name": $scope.lastname || '',
        "birthday": $scope.birthday || '',
        "gender": $scope.gender && $scope.gender.value || '',
        "email": $scope.email || '',
        "phone": $scope.phone || '',
        "tag": $scope.tag || '',
        "password": $scope.password || '',
        "profile_pic": $scope.fileModel,
        "group_id": $scope.customerGroup && $scope.customerGroup.customer_group_id || ''
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