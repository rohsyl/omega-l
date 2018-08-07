function OmegaLocation(root){
	this.root = root;
}
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
