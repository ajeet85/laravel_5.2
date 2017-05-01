(function () {
    'use strict';

    function Select(){
        return {
            restrict: 'E',
            link: function( scope, el, attrs ) {

                el.on('change', function( e ){
                    if( attrs.autoSubmit == 'true' ) {
                        var value = e.target.value
                        e.target.form.submit();
                    }
                });
            }
        }
    }

    angular
    .module('ProvisionTracker.Components.Select', [])
    .directive('select', [Select]);
})();
