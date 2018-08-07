function OmegaPluginMvc(root){
	this.root = root;
}
OmegaPluginMvc.prototype = {
	//---- Public method ----//
	url: function(plugin, action, args){
		if (typeof args === 'undefined') { args = {}; }
		var url = this.root.abspath + 'plugin/ajax?plugin=' + plugin + '&action=' + action;
		$.each( args, function(key, value){
			url += '&' + key + '=' + value;
		});
		return url;
	}
	//---- Private method ----//
};