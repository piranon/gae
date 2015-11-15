app.value('registerPageArray', ["", "login1", "forgotpassword"]);

app.config(function ($routeProvider, $locationProvider, $httpProvider) {
	$httpProvider.defaults.useXDomain = true;
	delete $httpProvider.defaults.headers.common['X-Requested-With'];
	$httpProvider.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

	$routeProvider
	.when('/', {
		templateUrl: base_ngview_url() + "dashboard/default.html",
		pageIndex: 0
	})
	.when('/create/:id', {
		templateUrl: base_ngview_url() + "dashboard/create.html",
		pageIndex: 2
	})
	.when('/forgotpassword', {
		templateUrl: base_ngview_url() + "login/forgotpassword.html",
		pageIndex: 2,
		animation: "navViewFade"
	})
	.when('/subscription', {
		templateUrl: base_ngview_url() + "dashboard/subscription.html",
		pageIndex: 91
	})
	.otherwise({
		templateUrl: base_ngview_url() + "error/pageNotFound.html",
		pageIndex: -1
	});
});

app.controller('ctrl', function ($scope, $rootScope, $location, registerPageArray, GAESERVICE, $routeParams) {

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
		//console.log("current param is...");
		//console.log($routeParams);
	});

    // define global angular parameter
    $scope.text = {
    	welcomeScreen: "Hello, Good Morning. Welcome to your store center at the first time."
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
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
    }

    $scope.navViewClickPrev = function () {
    	window.location.href = "#/" + getPrevPageName();
    };

    $scope.navViewClickNext = function () {
    	window.location.href = "#/" + getNextPageName();
    };

    $scope.route = function(path){
    	return $location.path(path);
    };

    $scope.dashboard = function(index){
    	switch(index){
    		case 1 : 
    		$location.path('/');
    		$scope.text.welcomeScreen = 'Hello, Good Morning. Welcome to your store center at the first time.';
    		break;
    		case 2 : 
    		$location.path('/subscription');
    		$scope.text.welcomeScreen = "Welcome text change too! this is cool!!!";
    		break;
    		case 3 : 
    		$location.path('/accountSetting');
    		break;
    		case 4 : 
    		$location.path('/signout');
    		break;
    	}
    };

});