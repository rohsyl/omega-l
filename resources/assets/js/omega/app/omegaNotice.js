(function (define) {
    define(['jquery', 'toastr'], function ($, toastr) {

        let OmegaNotice = function (root){

            this.root = root;
        };
        OmegaNotice.prototype = {
            //---- Public method ----//
            info : function(title, message){
                if(typeof title !== 'undefined') message = '<strong>' + title + '</strong><br />';
                toastr.info(message);
            },

            success: function(title, message){
                if(typeof title !== 'undefined') message = '<strong>' + title + '</strong><br />';
                toastr.success(message);
            },

            error: function(title, message){
                if(typeof title !== 'undefined') message = '<strong>' + title + '</strong><br />';
                toastr.error(message);
            },

            warning: function(title, message){
                if(typeof title !== 'undefined') message = '<strong>' + title + '</strong><br />';
                toastr.warning(message);
            },
            //---- Private method ----//
        };

        return OmegaNotice;
    });


}(typeof define === 'function' && define.amd ? define : function (deps, factory) {
    if (typeof module !== 'undefined' && module.exports) { //Node
        module.exports = factory(require('jquery'), require('toastr'));
    }
}));
