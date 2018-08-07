function OmegaNotice(root){
	this.root = root;
}
OmegaNotice.prototype = {
	//---- Public method ----//
	info : function(title, message){
        if(typeof title == 'undefined') title = '';
        $.growl({ title : title, message: message });
    },

    success: function(title, message){
        if(typeof title == 'undefined') title = '';
        $.growl.notice({ title : title, message: message });
    },

    error: function(title, message){
        if(typeof title == 'undefined') title = '';
        $.growl.error({ title : title, message: message });
    },

    warning: function(title, message){
        if(typeof title == 'undefined') title = '';
        $.growl.warning({ title : title, message: message });
    },
	//---- Private method ----//
};
