var mediaChooserInstance = 0;

(function($){
  var RsMediaChooser = function(elem, options){
      this.$button = $(elem);
      
      this.settings = $.extend({}, $.fn.rsMediaChooser.defaults, options || {});

    };

    RsMediaChooser.prototype = {
    	
    // ================ PUBLIC ================= //
    		
    init: function() {
		var $this = this;

		if($this.settings.url == undefined)
			$this.settings.url = route('media.library.modal');

		this.$button.click(function(e){
            e.preventDefault();
			var args = {
				rootId : $this.settings.rootId,
				rights : $this.settings.rights,
                inception : $this.settings.inception
			};
			omega.ajax.query($this.settings.url, args, 'GET', function(html){
				var o = $this.parseScript(html);
				var mid = omega.modal.open(__('Select media'), o.html, __('Choose'), function(){
					var $media = $('#omega-modal-'+mid+' .modal-body').find('.icon.selected');

					if ($media.length > 1) {
						if($this.settings.multiple == true) {

							var data = [];

							$media.each(function(){
								if ($.inArray($(this).data('type'), $this.settings.allowedMedia) != -1) {

									data.push({
										icon: $(this).data('icon'),
										name: $(this).data('name'),
										parent: $(this).data('parent'),
										ext: $(this).data('ext'),
										type: $(this).data('type'),
										size: $(this).data('size'),
										path: $(this).data('path'),
										id: $(this).data('id'),
										title:  $(this).data('title'),
										description:  $(this).data('description')
									});
								}
							});

							$this.settings.doneFunction(data, $this.$button);

							omega.modal.hide(mid);
						}
						else {
							alert('Multiple selection denied');
						}
					}
					else if ($media.length == 1) {
                        console.log($media.data('type'));
                        console.log($this.settings.allowedMedia);
						if ($.inArray($media.data('type'), $this.settings.allowedMedia) != -1) {

							console.log($media);
							var data = {
								icon: $media.data('icon'),
								name: $media.data('name'),
								parent: $media.data('parent'),
								ext: $media.data('ext'),
								type: $media.data('type'),
								size: $media.data('size'),
								path: $media.data('path'),
								id: $media.data('id'),
								title:  $media.data('title'),
								description:  $media.data('description')
							};

							$this.settings.doneFunction(data, $this.$button);

							omega.modal.hide(mid);
						}
						else {
							alert('Unallowed media type');
						}
					}
					else {
						//alert('No selection');
					}
				}, 'modal-lg');
				$this.runScript(o.scripts);
			});
		});
		
      return this;
    },
	
    // ================ PRIVATE ================ //

	parseScript: function (_source) {
		var source = _source;
		var scripts = [];

		// Strip out tags
		while(source.toLowerCase().indexOf("<script") > -1 || source.toLowerCase().indexOf("</script") > -1) {
			var s = source.toLowerCase().indexOf("<script");
			var s_e = source.indexOf(">", s);
			var e = source.toLowerCase().indexOf("</script", s);
			var e_e = source.indexOf(">", e);

			// Add to scripts array
			scripts.push(source.substring(s_e+1, e));
			// Strip from source
			source = source.substring(0, s) + source.substring(e_e+1);
		}


		// Return the cleaned source
		return  {
			html: source,
			scripts : scripts
		};
	},

	runScript: function(scripts) {
		// Loop through every script collected and eval it
		for(var i=0; i<scripts.length; i++) {
			try {
				if (scripts[i] != '')
				{
					try  {          //IE
						execScript(scripts[i]);
					}
					catch(ex)           //Firefox
					{
						window.eval(scripts[i]);
					}

				}
			}
			catch(e) {
				// do what you want here when a script fails
				// window.alert('Script failed to run - '+scripts[i]);
				if (e instanceof SyntaxError) console.log (e.message+' - '+scripts[i]);
			}
		}
	}
  };

  $.fn.rsMediaChooser = function(options) {
    return this.each(function() {
    	var rsMediaChooser = new RsMediaChooser(this, options).init();
    	$(this).data("rsMediaChooser", rsMediaChooser);
    });
  };
  $.fn.rsMediaChooser.defaults = {
	url : undefined,
	rootId : 1,
	rights : 'mkdir,rn,rm,refresh,upload,download,copy,cut,paste',
	multiple: false,
    inception: false,
	allowedMedia: [
		'folder', 'picture', 'video', 'document', 'music', 'video_ext'
	],
	doneFunction: function(data)
	{
		$('[data-mediachooser="text"]').val(data);
	}
  };
  $.fn.rsMediaChooser.settings = {};
  
})(jQuery);
