

(function (define) {
    define(['jquery'], function ($) {
        let OmegaPluginMvc = function (root){
            this.root = root;
        };
        OmegaPluginMvc.prototype = {
            //---- Public method ----//
            url: function(plugin, action, args){
                if (typeof args === 'undefined') { args = {}; }
                var url = this.root.abspath + 'plugin/run/' + plugin + '/' + action;
                $.each( args, function(key, value){
                    url += '&' + key + '=' + value;
                });
                return url;
            }
            //---- Private method ----//
        };
        return OmegaPluginMvc;
    });

}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));