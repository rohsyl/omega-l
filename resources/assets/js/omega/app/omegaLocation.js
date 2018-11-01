window.$ = window.jQuery = require('jquery');

(function (define) {
    define(['jquery'], function ($) {

        OmegaLocation = function (root){
			this.root = root;
		};
		OmegaLocation.prototype = {
			//---- Public method ----//
			reload: function(){
				location.reload();
			},

			load: function(url){
				$(location).attr('href',url);
			}
			//---- Private method ----//
		};

		return OmegaLocation

	});

}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));
