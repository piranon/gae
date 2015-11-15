app.value('registerPageArray', ["", "signup2", "signup3", "signup4", "setup1", "setup2", "setup31"]);

app.config(function ($routeProvider, $locationProvider, $httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    $httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";
    
    $routeProvider
    .when('/', {
        templateUrl: base_ngview_url() + "sign/signup1.html",
        pageIndex: 0
    })
    .when('/signup2', {
        templateUrl: base_ngview_url() + "sign/signup2.html",
        pageIndex: 1
    })
    .when('/signup3', {
        templateUrl: base_ngview_url() + "sign/signup3.html",
        pageIndex: 2
    })
    .when('/signup4', {
        templateUrl: base_ngview_url() + "sign/signup4.html",
        pageIndex: 3
    })
    .when('/setup1', {
        templateUrl: base_ngview_url() + "sign/setup1.html",
        pageIndex: 4
    })
    .when('/setup2', {
        templateUrl: base_ngview_url() + "sign/setup2.html",
        pageIndex: 5
    })
    .when('/setup31', {
        templateUrl: base_ngview_url() + "sign/setup3_1.html",
        pageIndex: 6
    })
    .when('/setup32', {
        templateUrl: base_ngview_url() + "sign/setup3_2.html",
        pageIndex: 31
    })
    .when('/login', {
        templateUrl: base_ngview_url() + "sign/signin.html",
                pageIndex: 20, // manual index page
                animation: "navViewFade"
            })
    .when('/forgotpassword', {
        templateUrl: base_ngview_url() + "sign/forgotpassword.html",
        pageIndex: 21,
        animation: "navViewFade"
    })
    .when('/termofservice', {
        templateUrl: base_ngview_url() + "sign/termofservice.html",
        pageIndex: 41
    })
    .when('/setup4', {
        templateUrl: base_ngview_url() + "sign/setup4.html",
        pageIndex: 99
    })
    .otherwise({
        templateUrl: base_ngview_url() + "error/pageNotFound.html",
        pageIndex: -1
    });
});

app.controller('ctrl', function ($scope, $rootScope, $location, registerPageArray, GAESERVICE) {
    // data serway
    $scope.serway1_parent = {id: "", type: "", img: "", title_en: "", title_th: ""};
    $scope.serway1_child = [];
    $scope.serway2_parent = {id: "", type: "", img: "", title_en: "", title_th: ""};
    $scope.serway2_child = [];
    $scope.serway3_parent = {id: "", type: "", img: "", title_en: "", title_th: ""};
    $scope.serway3_child = [];
    
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

        // when route start
        // if serway page
        if ($scope.currPageIndex === 4) {
            GAESERVICE.register_serway_list('sign_serway1').then(function (response) {
                if (response.ok === 1) {
                    var r = response.data;
                    //console.log(r);
                    $scope.serway1_parent = {
                        serway_id: r.serway_id,
                        select_type: r.select_type,
                        image_url: r.image_url,
                        title_en: r.title.en,
                        title_th: r.title.th
                    };
                    if (r.sub_data.length > 0) {
                        var res = r.sub_data;
                        $scope.serway1_child = [];
                        for (var i = 0; i < res.length; i++) {
                            $scope.serway1_child.push({
                                image_url: res[i].image_url,
                                select_type: res[i].select_type,
                                serway_id: res[i].serway_id,
                                title_en: res[i].title.en,
                                title_th: res[i].title.th
                            });
                        }
                    }
                }
            });
} else if ($scope.currPageIndex === 5) {
    GAESERVICE.register_serway_list('sign_serway2').then(function (response) {
        if (response.ok === 1) {
            var r = response.data;
                    //console.log(r);
                    $scope.serway2_parent = {
                        serway_id: r.serway_id,
                        select_type: r.select_type,
                        image_url: r.image_url,
                        title_en: r.title.en,
                        title_th: r.title.th
                    };
                    if (r.sub_data.length > 0) {
                        var res = r.sub_data;
                        $scope.serway2_child = [];
                        for (var i = 0; i < res.length; i++) {
                            $scope.serway2_child.push({
                                image_url: res[i].image_url,
                                select_type: res[i].select_type,
                                serway_id: res[i].serway_id,
                                title_en: res[i].title.en,
                                title_th: res[i].title.th
                            });
                        }
                    }
                }
            });
}

});

$rootScope.$on('$routeChangeSuccess', function (scope, next, currRoute) {
    var cr = $scope.currPageIndex;
    $scope.showNavPrevBtn = true;
    $scope.showNavNextBtn = true;

    if (cr <= 0) {
        $scope.showNavPrevBtn = false;
    }
        /*if (cr >= registerPageArray.length) {
         $scope.showNavNextBtn = false;
     }*/
 });

    // define global angular parameter
    $scope.input = {
        email: "", username: "", firstname: "", lastname: "", password: "", password2: "", country: "Thailand", tel: ""
    };
    $scope.survey = {
        first: "",
        second: "",
        third: "",
        third_otner: ""
    };
    $scope.checkError = {
        email: 0, page2: 0
    };
    $scope.countryList = ["Thailand", "thailand"];
    $scope.allowNext_1 = false;
    $scope.allowNext_2 = false;
    $scope.allowNext_3 = false;
    $scope.allowNext_4 = false;
    $scope.allowNext_5 = false;
    $scope.allowNext_6 = false;
    $scope.allowNext_7 = false;
    $scope.allowNavigate = false;
    // data to resiger
    $scope.registerData = {
        txt_email: $scope.input.email,
        txt_password: $scope.input.password,
        txt_storeName: $scope.input.username,
        txt_fristName: $scope.input.firstname,
        txt_lastName: $scope.input.lastname,
        txt_country: 1,
        txt_mobilePhone: "0844444444",
        txt_acceptedTerm: 1,
        txt_serway: []
    };
    $scope.prepSerway = {
        first: "",second:"",third:""
    };

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

    $scope.checkEmailValid1 = function () {
        if (validateEmail($scope.input.email)) {
            $scope.allowNext_1 = true;
        } else {
            $scope.allowNext_1 = false;
        }
    };

    $scope.checkPage2 = function () {
        if ($scope.input.username !== "" && $scope.input.firstname !== "" && $scope.input.lastname !== "") {
            $scope.allowNext_2 = true;
        } else {
            $scope.allowNext_2 = false;
        }
    };

    $scope.checkPage3Pass1 = function () {
        if ($scope.input.password.length >= 8) {
            $('#errorNoti').hide();
        } else {
            $('#errorNoti').show();
        }
    };

    $scope.checkPage3Pass2 = function () {
        if ($scope.input.password.length >= 8 && $scope.input.password2 >= 8) {
            if ($scope.input.password === $scope.input.password2) {
                $scope.allowNext_3 = true;
                $('#errorNoti').hide();
            }
        } else {
            $('#errorNoti').show();
        }
    };

    $scope.checkPage4Tel = function () {
        /*if ($scope.input.tel.length <= 9) {
            if ($.inArray($scope.input.country, $scope.countryList) >= 0) {
                var text = $scope.input.tel;
                text = text.replace(/(\d{3})(\d{3})(\d{3})/, "+66-$1-$2-$3");
                $scope.allowNext_4 = true;
                return $scope.input.tel = text.replace("+66-0", "+66-");
            }
        } else if ($scope.input.tel.length >= 10) {
            if ($.inArray($scope.input.country, $scope.countryList) >= 0) {
                var text = $scope.input.tel;
                text = text.replace(/(\d{3})(\d{3})(\d{4})/, "+66-$1-$2-$3");
                $scope.allowNext_4 = true;
                return $scope.input.tel = text.replace("+66-0", "+66-");
            }
        }*/
        if($scope.input.tel.length > 7){
            return $scope.allowNext_4 = true;
        }
    };

    $scope.doSurvey1 = function (number) {
        $scope.allowNext_5 = true;
        return $scope.survey.first = number;
    };

    $scope.doSurvey2 = function (number) {
        $scope.allowNext_6 = true;
        return $scope.survey.second = number;
    };

    $scope.doSurvey31 = function (number) {
        $scope.allowNext_7 = true;
        return $scope.survey.third = number;
    };


    $scope.checkSerwayThirdOther = function () {
        if ($scope.survey.third_otner !== "" && $scope.survey.third_otner.length > 0) {
            return $scope.allowNext_7 = true;
        }
    };

    $scope.navViewClickPrev = function () {
        window.location.href = "#/" + getPrevPageName();
        /*switch ($scope.currPageIndex) {
         case 0 :
         break;
         case 1 :
         if ($scope.allowNext_1 === true) {
         window.location.href = "#/" + getPrevPageName();
         }
         break;
         case 2 :
         if ($scope.allowNext_2 === true) {
         window.location.href = "#/" + getPrevPageName();
         }
         break;
         case 2 :
         if ($scope.allowNext_3 === true) {
         window.location.href = "#/" + getPrevPageName();
         }
         break;
     }*/
 };

 $scope.navViewClickNext = function () {
    switch ($scope.currPageIndex) {
        case 0 :
        if ($scope.allowNext_1 === true) {
                    // send data check email
                    var data = {txt_owner_email: $scope.input.email}; // set parameter
                    // call service api
                    GAESERVICE.checkEmailExist(data).then(function (response) {
                        // console.log(response);
                        // check result
                        if (response.ok === 1) { // true
                            $('#errorNoti').hide();
                            window.location.href = "#/" + getNextPageName();
                        } else { // false
                            $('#errorNoti').show();
                        }
                    });
                }
                break;
                case 1 :
                // send data to check username
                var data = {username: $scope.input.username}; // set parameter
                // call service api
                GAESERVICE.checkUserExist(data).then(function (response) {
                    // check result
                    if (response.ok === 1 && $scope.allowNext_2 === true) { // true
                        $('#errorNoti').hide();
                        window.location.href = "#/" + getNextPageName();
                    } else { // false
                        $('#errorNoti').show();
                    }
                });
                break;
                case 2 :
                if ($scope.allowNext_3 === true) {
                    window.location.href = "#/" + getNextPageName();
                }
                break;
                case 3 :
                if ($scope.allowNext_4 === true) {
                    window.location.href = "#/" + getNextPageName();
                }
                break;
                case 4 :
                // first serway
                if ($scope.allowNext_5 === true) {
                    $scope.prepSerway.first = {
                        serway_id: $scope.serway1_parent.serway_id,
                        sub_data: [{serway_id:$scope.survey.first}]
                    };
                    window.location.href = "#/" + getNextPageName();
                }
                break;
                case 5 :
                // second serway
                if ($scope.allowNext_6 === true) {
                    $scope.prepSerway.second = {
                        serway_id: $scope.serway2_parent.serway_id,
                        sub_data: [{serway_id:$scope.survey.second}]
                    };
                    GAESERVICE.register_sub_serway_list($scope.survey.second).then(function(response){
                        if(response.ok === 1){
                            var res = response.data;
                            $scope.serway3_child = [];
                            for (var i = 0; i < res.length; i++) {
                                $scope.serway3_child.push({
                                    image_url: res[i].image_url,
                                    select_type: res[i].select_type,
                                    serway_id: res[i].serway_id,
                                    title_en: res[i].title.en,
                                    title_th: res[i].title.th
                                });
                            }
                        }
                        //console.log($scope.serway3_child);
                    });
                    window.location.href = "#/" + getNextPageName();
                }
                break;
                case 6 :
                // third serway (second parent)
                if ($scope.allowNext_7 === true) {
                    if ($scope.survey.third === 0 || $scope.survey.third === "") {
                        window.location.href = "#/setup32";
                    } else {
                        $scope.prepSerway.third = {
                            serway_id: $scope.serway2_parent.serway_id,
                            sub_data: [{serway_other:$scope.survey.third}]
                        };
                        // start sending register data
                        $scope.registerData.txt_serway.push($scope.prepSerway.first);
                        $scope.registerData.txt_serway.push($scope.prepSerway.second);
                        $scope.registerData.txt_serway.push($scope.prepSerway.third);
                        var sendData = {
                            registerData: $scope.registerData
                        };
                        var registerSend = angular.toJson(sendData);
                        GAESERVICE.register_post(registerSend).then(function(response){
                            if(response.ok===1){
                                console.log(response);
                                window.location.href = "#/setup4";
                            }
                        });                        
                    }
                }
                break;
                case 31 :
                $scope.prepSerway.third = {
                    serway_id: $scope.serway2_parent.serway_id,
                    sub_data: [{serway_other:$scope.survey.third_otner}]
                };
                // start sending register data
                $scope.registerData.txt_serway.push($scope.prepSerway.first);
                $scope.registerData.txt_serway.push($scope.prepSerway.second);
                $scope.registerData.txt_serway.push($scope.prepSerway.third);
                var sendData = {
                    registerData: $scope.registerData
                };
                var registerSend = angular.toJson(sendData);
                GAESERVICE.register_post(registerSend).then(function(response){
                 if(response.ok===1){
                    console.log(response);
                    window.location.href = "#/setup4";
                }
            });     
                break;
            }
        };

        $scope.takeLogin = function(){
            return window.location.href = 'member/login/';
        };

        $scope.redirecTo = function (url) {
            window.location.href = url;
        };

        $scope.showTOS = function () {
            return window.location.href = '#/termofservice';
        };

    });
