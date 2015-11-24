(function() {
  'use strict';

  angular
      .module('customer')
      .factory('focus', focus);

  function focus($timeout, $window) {
    return function(id) {
      $timeout(function() {
        var element = $window.document.getElementById(id);
        if(element)
          element.focus();
      });
    };
  }

})();
