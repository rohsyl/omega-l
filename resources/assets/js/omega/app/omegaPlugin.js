let OmegaPluginMvc = require('./omegaPluginMvc');

(function (define) {
    define(['jquery'], function ($) {
        let OmegaPlugin = function (root){
            this.root = root;
            this.mvc = new OmegaPluginMvc(root);
        };
        OmegaPlugin.prototype = {
            //---- Public method ----//

            //---- Private method ----//
        };

        return OmegaPlugin;
    });

}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'));
    }
}));