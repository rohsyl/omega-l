(function (define) {
    define(['jquery'], function ($) {

    	let OmegaMvc = function (root){
			this.root = root;
		};
		OmegaMvc.prototype = {
			//---- Public method ----//
			url: function(controller, action, args){
				if (typeof args === 'undefined') { args = {}; }
				var url = this.root.abspath + controller + '/' + action;
				$.each( args, function(key, value){
					url += '&' + key + '=' + value;
				});
				return url;
			},

			url_manual: function(url){
				return this.root.abspath + url;
			}
			//---- Private method ----//
		};
		return OmegaMvc;
	});


}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));
