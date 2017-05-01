(function () {
    'use strict';

    function Button(){
        return {
            restrict: 'E',
            link: function( scope, el, attrs ) {
            }
        }
    }

    angular
    .module('ProvisionTracker.Components.Button', [])
    .directive('button', [Button]);
})();
