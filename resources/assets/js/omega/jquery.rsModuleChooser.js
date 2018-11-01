(function($){
  var RsModuleChooser = function(elem, options){
	  var $this = this;
      this.$button = $(elem);
      
      this.settings = $.extend({}, $.fn.rsModuleChooser.defaults, options || {});

    };

    RsModuleChooser.prototype = {
    	
    // ================ PUBLIC ================= //
    		
    init: function() {

		var $this = this;

		this._initModal();
		
		this.$button.click(function(e){
			
			var $thisButton = $(this);
			
            e.preventDefault();
			$this.$modal.modal('show');

			$.ajax({
				url : 'index.php?page=modulearea&function=listplugin', // La ressource cibl�e
				type : 'GET', // Le type de la requ�te HTTP.
				dataType : 'json'
			}).done(function(data) {

				var $modalBody = $this.$modal.find('.modal-body');
				
				$modalBody.empty();
                $modalBody.append('<p id="title">Select a plugin :</p>');
                $modalBody.append('<div class="list-group">');

                $.each(data.plugins, function(){

                    $modalBody.append('\
						<a href="#" class="list-group-item plugin-item"\
							data-type="plugin"\
							data-pluginid="'+this.pluginId+'"\
							data-toggle="tooltip"\
							data-placement="right">\
								'+this.pluginName+'\
						</a>');

                });
                $modalBody.append('<\div>');

                $plugin = $('.plugin-item');
				
				$plugin.click(function(e){
					e.preventDefault();
                    var id = $(this).data('pluginid');
                    var text = $(this).html();

                    $.ajax({
						url : 'index.php?page=modulearea&function=listmodulebyplugin&pluginid=' + id, // La ressource cibl�e
						type : 'GET', // Le type de la requ�te HTTP.
						dataType : 'json'
					}).done(function(data) {

                        $modalBody.empty();
                        $modalBody.append('<p id="title">Select a module of '+ text +' :</p>');
                        $modalBody.append('<div class="list-group">');

                        $.each(data.modules, function(){

                            $modalBody.append('\
								<a href="#" class="list-group-item module-item"\
									data-type="module"\
									data-moduleid="'+this.moduleId+'"\
									data-toggle="tooltip"\
									data-placement="right">\
										'+this.moduleName+'\
								</a>');

                        });
                        $modalBody.append('<\div>');

                        $module = $('.module-item');

                        $module.click(function(e){
							e.preventDefault();
                            var id = $(this).data('moduleid');
							$this.settings.doneFunction(id, $modalBody, $thisButton);
							$this.$modal.modal('hide');
							return false;
                        });
                    });
					return false;
                });
			});
			return false;
		});
      return this;
    },
	
 
	_initModal: function() {
		
		var $modalFade  = $('<div class="modal fade" id="modulechooser-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>');
		var $modalDialog = $('<div class="modal-dialog"></div>');
		var $modalContent = $('<div class="modal-content"></div>');
		var $modalHeader = $('<div class="modal-header"></div>');
		var $modalBody = $('<div class="modal-body"></div>');
		var $modalFooter = $('<div class="modal-footer"></div>');
		var $modalTimes = $('<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
		var $modalTitle = $('<h4 class="modal-title" id="myModalLabel">Module</h4>');
		var $modalBtnClose = $('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');

		$modalFooter.append($modalBtnClose);

		$modalHeader.append($modalTimes);
		$modalHeader.append($modalTitle);

		$modalContent.append($modalHeader);
		$modalContent.append($modalBody);
		$modalContent.append($modalFooter);
		$modalDialog.append($modalContent);

		$modalFade.append($modalDialog);

		$('body').append($modalFade);

		this.$modal = $('#modulechooser-modal');
	}
  };

  $.fn.rsModuleChooser = function(options) {
    return this.each(function() {
    	var rsModuleChooser = new RsModuleChooser(this, options).init();
    	$(this).data("rsModuleChooser", rsModuleChooser);
    });
  };
  $.fn.rsModuleChooser.defaults = {
	doneFunction: function(id)
	{
		$('[data-modulechooser="text"]').val(id);
	}
  };
  $.fn.rsModuleChooser.settings = {};
  
})(jQuery);
