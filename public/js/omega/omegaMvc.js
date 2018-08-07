function OmegaMvc(root){
	this.root = root;
}
OmegaMvc.prototype = {
	//---- Public method ----//
	url: function(controller, action, args){
		if (typeof args === 'undefined') { args = {}; }
		var url = this.root.abspath  + controller + '/' + action;
		$.each( args, function(key, value){
			url += '&' + key + '=' + value;
		});
		return url;
	}
	//---- Private method ----//
};
