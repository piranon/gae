	app.directive('animateJelly', ['$animate', function($animate) {
	  return function(scope, element, attrs) {
	    element.on('click', function() {
	      $animate.removeClass(element, 'jelly');
	      if(element.hasClass('jelly')) {
	        $animate.removeClass(element, 'jelly');
	      } else {
	        $animate.addClass(element, 'jelly');
	      }
	    });
	    element.on('mouseenter', function() {
	    	$animate.removeClass(element, 'jelly');
	      if(element.hasClass('jelly')) {
	        $animate.removeClass(element, 'jelly');
	      } else {
	        $animate.addClass(element, 'jelly');
	      }
	    });
	  };
	}]);