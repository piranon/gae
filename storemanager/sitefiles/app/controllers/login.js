app.value('registerPageArray', ["", "login1", "forgotpassword"]);

app.config(function ($routeProvider, $locationProvider, $httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    delete $httpProvider.defaults.headers.common['X-Requested-With'];
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    
    $routeProvider
    .when('/', {
        templateUrl: base_ngview_url() + "login/signin.html",
        pageIndex: 0
    })
    .when('/login1', {
        templateUrl: base_ngview_url() + "login/login1.html",
        pageIndex: 1
    })
    .when('/forgotpassword', {
        templateUrl: base_ngview_url() + "login/forgotpassword.html",
        pageIndex: 2,
        animation: "navViewFade"
    })
    .otherwise({
        templateUrl: base_ngview_url() + "error/pageNotFound.html",
        pageIndex: -1
    });
});

app.controller('ctrl', function ($scope, $rootScope, $location, registerPageArray, GAESERVICE) {

    $rootScope.$on('$routeChangeStart', function (event, currRoute, prevRoute) {
        var cr = 0, pr = -1;
        if (currRoute.pageIndex) {
            cr = parseInt(currRoute.pageIndex);
        }
        if (prevRoute) {
            pr = parseInt(prevRoute.pageIndex);
        }

        if ((pr >= 0) && (cr >= 0)) {
            var animationName = "navViewPrev";
            if (cr > pr) {
                animationName = "navViewNext";
            }
            $rootScope.animation = animationName;
        } else {
            $rootScope.animation = 'navViewFade';
        }
        $scope.currPageIndex = cr;
    });

    $rootScope.$on('$routeChangeSuccess', function (scope, next, currRoute) {
        var cr = $scope.currPageIndex;
        $scope.showNavPrevBtn = true;
        $scope.showNavNextBtn = true;

        if (cr <= 0) {
            $scope.showNavPrevBtn = false;
        }
        if (cr >= registerPageArray.length) {
            $scope.showNavNextBtn = false;
        }
    });

    // define global angular parameter
    $scope.input = {
        email: "", password: "",email2:""
    };
    $scope.allow1 = false;
    $scope.allow2 = false;

    $scope.checkEmailLogin = function () {
        if (validateEmail($scope.input.email)) {
            $scope.allow1 = true;
            $("#errorNoti-1").hide();
        } else {
            $scope.allow1 = false;
            $("#errorNoti-1").show();
        }
    };

    $scope.checkPassLogin = function () {
        if ($scope.input.password.length >= 6) {
            $scope.allow2 = true;
            $('#errorNoti-2').hide();
        } else {
            $scope.allow2 = false;
            $('#errorNoti-2').show();
        }
    };

    $scope.reqLogin = function () {
        if ($scope.allow1 === true && $scope.allow2 === true) {
            var dataArray = {
                txt_email: $scope.input.email,
                txt_password: $scope.input.password
            };
            GAESERVICE.owner_login(dataArray).then(function (response) {
                console.log(response);
                if(response.ok === 1){
                    // success login
                } else {
                    // fail login
                    $("#errorNoti-1").hide();
                    $('#errorNoti-2').hide();
                    $('#errorNoti-3').show();
                }
            });
        } 
    };

    $scope.reqForgotPassword = function(){
        if($scope.input.email2 !== ""){
            GAESERVICE.owner_forgot_password({txt_email:$scope.input.email2}).then(function(response){
                if(response.ok===1){
                    window.location.href = '#/';
                }
            });
        }
    }

    function getPrevPageName() {
        var pageIndex = ($scope.currPageIndex - 1);
        if (pageIndex < 0) {
            pageIndex = 0;
        }
        return registerPageArray[pageIndex];
    }

    function getNextPageName() {
        var pageIndex = ($scope.currPageIndex + 1);
        if (pageIndex >= registerPageArray.length) {
            pageIndex = (registerPageArray.length - 1)
        }
        return registerPageArray[pageIndex];
    }

    function validateEmail(email) {
        // http://stackoverflow.com/a/46181/11236
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

    $scope.navViewClickPrev = function () {
        window.location.href = "#/" + getPrevPageName();
    };

    $scope.navViewClickNext = function () {
        window.location.href = "#/" + getNextPageName();
    };

});