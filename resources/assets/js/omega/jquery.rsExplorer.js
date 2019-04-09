var rsExplorerInstance = 0;
(function($){
  var RsExplorer = function(elem, options){
      rsExplorerInstance++;
	  var $this = this;
      this.$main = $(elem);
      
      this.settings = $.extend({}, $.fn.rsExplorer.defaults, options || {});

	  this.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
	  
      if(this.settings.siteUrl == undefined)
	  {
    	  $.error('siteUrl is undefined');
	  }
      if(this.settings.uploaderUrl == undefined)
	  {
    	  $.error('uploaderUrl is undefined');
	  }
      if(this.settings.gifLoader == undefined)
	  {
    	  $.error('gifLoader is undefined');
	  }

      this.parent = this.settings.rootId;
      
      this.actionButton = {
		mkdir: {
			icon: 'glyphicon glyphicon-plus',
			iconType: 'bs',
			text: __('Add folder'),
			action: function(_this){
				omega.modal.prompt(__("Create a new folder"), "", "", function(newfolder){
                    $this._action('mkdir', {
                            parent: $this.parent,
                            newfolder: newfolder
                        },
                        __("Folder succefully created"),
                        __("Error while creating a folder")
					);
				});
			}
		},
	    mkvideo: {
            icon: 'glyphicon glyphicon-facetime-video',
            iconType: 'bs',
            text: 'Youtube / Vimeo',
            action: function(_this){
                omega.modal.prompt(__('Create a new video from youtube or vimeo'), '', __('Paste here the url of the Youtube / Vimeo video'), function(value){
                    console.log(value);
                    if(value.length > 0){
                        $this._action('mkvideo', {
								parent: $this.parent,
								url: value
							},
							__("Youtube/Vimeo video added"),
							__("Error while adding video")
						);
                    }
                });

            }
	    },
		rm: {
			icon: 'glyphicon glyphicon-trash',
			iconType: 'bs',
			text: __('Remove element'),
			action: function(_this){
				var $selected = $this.$main.find('.selected');
				if($selected.length == 1)
				{
					omega.modal.confirm(__('Do you really want to delete this element ?'), function(yes){
                        if (yes) {
                            $this._action('delete', {
                                    parent: $this.parent,
                                    media: {
                                        id: $selected.data('id'),
                                        type: $selected.data('type')
                                    },
                                    multi: 0
                                },
                                __("Item succefully deleted"),
                                __("Error while deleting this item")
                            );
                        }
					});
				}
				else if($selected.length > 1)
				{
					omega.modal.confirm(__('Do you really want to delete these elements ?') + ' ('+$selected.length+')', function(yes){
                        if (yes) {

                            var files = [];

                            $selected.each(function(i){
                                files.push({
                                    id: $(this).data('id'),
                                    type: $(this).data('type')
                                });
                            });

                            $this._action('delete', {
                                    parent: $this.parent,
                                    media: JSON.stringify(files),
                                    multi: 1
                                },
                                __('Items succefully deleted') + ' ('+$selected.length+')',
                                __('Error while deleting these items') + ' ('+$selected.length+')'
                            );
                        }
					});
				}
				else
				{
					omega.notice.warning(undefined, __("Please select an element"));
				}
			}
		},
		rn: {
			icon: 'glyphicon glyphicon-pencil',
			iconType: 'bs',
			text: __('Rename element'),
			action: function(_this){
				var $selected = $this.$main.find('.selected');
				if($selected.length == 1)
				{
					var oldname = $selected.data('name');
					omega.modal.prompt(__("Rename") + " " + oldname, oldname, '', function(newname){
                        if (newname != null) {
                            $this._action('rn', {
                                    id: $selected.data('id'),
                                    newname: newname
                                },
                                __("Element succefully renamed"),
                                __("Error while renaming an element")
							);
                        }
					});
				}
                else
                {
                    omega.notice.warning(undefined, __("Please select an element"));
                }
			}
		},
		refresh: {
			cssclass: 'hidden-xs',
			icon: 'glyphicon glyphicon-refresh',
			iconType: 'bs',
			text: __('Refresh'),
			action: function(_this){
				$this._load();
				return false;
			}
		},
		upload: {
			icon: 'glyphicon glyphicon-cloud-upload',
			iconType: 'bs',
			text: __('Upload files'),
			action: function(_this){
				$this._uploader();
				return false;
			}
		},
		download: {
			icon: 'glyphicon glyphicon-cloud-download',
			iconType: 'bs',
			text: __('Download selected file'),
			action: function(_this){
				
				var $selected = $this.$main.find('.selected');
				if($selected.length == 1)
				{
					if($selected.data('type') == 'folder')
					{
						return false;
					}
					else
					{
						var url = $selected.data('path');
						var name = $selected.data('name');
						_this.attr('download', name);
						_this.attr('href', url);
						return true;
					}
				}
			}
		},
		copy: {
			icon: 'fa fa-files-o', 
			iconType: 'fa',
			text: __('Copy'),
			action: function(_this){
				var $selected = $this.$main.find('.selected');
				if($selected.length >= 1) {
					_this.css('background-color', '#ccc');
					var files = [];
					
					$selected.each(function(i){
						files.push($(this).data('id'));
					});
					
					$this._startCopingOrMoving($this.parent, files, 'copy');
				}
				else
				{
					$.growl.error({title: '', message: __('You must select one or more files before !')})
				}
			}
		},
		cut: {
			icon: 'fa fa-scissors', 
			iconType: 'fa',
			text: __('Cut'),
			action: function(_this){
				var $selected = $this.$main.find('.selected');
				if($selected.length >= 1) {
					_this.css('background-color', '#ccc');
					var files = [];
					
					$selected.each(function(i){
						files.push($(this).data('id'));
					});
					
					$this._startCopingOrMoving($this.parent, files, 'move');
				}
				else
				{
					$.growl.error({title: '', message: __('You must select one or more files before !')})
				}
			}
		},
		paste: {
			icon: 'fa fa-clipboard', 
			iconType: 'fa',
			text: __('Paste'),
			action: function(_this){
				$('#rsexaction'+rsExplorerInstance).find('a').css('background-color', 'transparent');
				$this._finalizedCopingOrMoving($this.parent);
			}
		}
      };
      
    };

    RsExplorer.prototype = {
    	
    // ================ PUBLIC ================= //
    		
    init: function() {
      this._initDOM();
      this._load();
      return this;
    },

    // ================ PRIVATE ================ //

    _initDOM: function() {

		var _this = this;
    	var actionDiv 	= $('<div></div>');
		var bcrumb  	= $('<div></div>');
    	var divRow  	= $('<div style="margin-right: 0px;"></div>');
    	var divCol8 	= $('<div></div>');
    	var divCol4 	= $('<div></div>');
			
		actionDiv
			.attr('class', 'action rs-action')
			.attr('id', 'rsexaction'+rsExplorerInstance);
		
    	$.each(this.actionButton, function(key, value){

			if(_this.settings.rights.indexOf(key) != -1) {
				var a = $('<a></a>');
				var span = $('<span></span>');
				if (this.iconType == 'bs') {
					span = $('<span></span>');
					span.attr('class', this.icon);
				}
				else if (this.iconType == 'fa') {
					span = $('<i></i>');
					span.attr('class', this.icon);
				}

				a.attr('href', '#')
					.data('rsex-action', key)
					.append(span)
					.append(' <span class="hidden-xs">' + this.text + '</span>');

				actionDiv.append(a);
			}
    	});
		
		bcrumb
			.attr('id', 'rsbcrumb'+rsExplorerInstance)
			.css({
				'margin-top': '30px',
				'margin-bottom': '20px',
			});		

		divCol8
			.attr('class', 'col-md-8')
			.attr('id', 'rsexcontentpane'+rsExplorerInstance)
			.css({
				'margin-bottom': '20px'
			});
			
		divCol4
			.attr('class', 'col-md-4')
			.attr('id', 'rsexrightpane'+rsExplorerInstance)
			.css({
				'background-color': '#F5F5F5',
				'padding-bottom': '15px',
				'visibility' : 'hidden'
			});

    	divRow
			.attr('class', 'row')
			.append(divCol8)
			.append(divCol4);
    	
    	this.$main
			.append(actionDiv)
			.append(bcrumb)
			.append(divRow);
    	
    	this.$contentPane = $('#rsexcontentpane'+rsExplorerInstance);
    	this.$rightPane = $('#rsexrightpane'+rsExplorerInstance);
    	this.$action = $('#rsexaction'+rsExplorerInstance);
        this.$bcrumb = $('#rsbcrumb'+rsExplorerInstance);
    	this._createBreadCrumb([]);
    	this._setButtonOnClick();
    	
    },
    
    _createBreadCrumb: function(bc) {
    	
    	var $this = this;

		var bcrumb = '<ol class="breadcrumb"><li><a data-parent="'+$this.settings.rootId + '" >' +
			'<span class="glyphicon glyphicon-home"></span></a></li>&nbsp;';

		var displayItem = true;
		var homeAlreadyProcessed = false;
		for (var i = 0; i < bc.length; i++)
		{
			displayItem = true;
			if($this.settings.rootId !== 1)
			{
				if(!homeAlreadyProcessed)
				{
					homeAlreadyProcessed = $this.settings.rootId === bc[i].id;
					displayItem = false;
				}
				else
				{
					displayItem = true;
				}
			}

			if(displayItem) bcrumb += '<li><a class="file-nav" data-parent="' + bc[i].id + '">' + bc[i].name + '</a></li>';
		}

		bcrumb += '</ol>';
		this.$bcrumb.html(bcrumb);
		
		this.$bcrumb.find('li a').click(function(){
			$this.parent = $(this).data('parent');
			$this._load();
		});
    },

    _setButtonOnClick: function() {
    	
    	var $this = this;
    	
    	this.$action.find('a').on('click', function(){
    		
    		var a = $(this).data('rsex-action');
    		$this.actionButton[a].action($(this));
    	});
    },
    
    _setContentOnClick: function() {
    	var $this = this;
    	this.$icons = $('.icon');
    	
    	this.$icons.attr('unselectable', 'on')
        .css('user-select', 'none')
        .on('selectstart', false);
    	if(this.isMobile) {
			this.$icons.on('doubletap', function (e){
				$(this).trigger('dblclick');
			});
			this.$icons.on('press', function(e){
				$(this).toggleClass('selected').attr('unselectable', 'on')
				.css('user-select', 'none')
				.on('selectstart', false);
			});
		}
    	this.$icons.on('click', function(e){
    		
    		var _this = $(this);
			
    		if( e.shiftKey ) {
    			var $selected = $this.$main.find('.selected');

    			var last = $this.$icons.index($this.lastSelected);
    			var first = $this.$icons.index(this);
    			var start = Math.min(first, last);
    			var end = Math.max(first, last);
    			for( var i = start; i <= end; i++) {
    				$this.$icons.eq(i).addClass('selected');
    			}
    		}
    		else {
    			$this.lastSelected = this;
				// Deselect all icon and select the current one
				if ( !(e.ctrlKey) ) {
					$this.$icons.each(function(){
						$(this).removeClass('selected');
					});
					_this.addClass('selected');
				}
				
				if( e.ctrlKey ) {
					_this.toggleClass('selected');
				}
    		}

			var infopane = $('<div></div>').attr('id', 'file-info');
            infopane.append('<h4 class="page-header" style="margin-top : 15px"><span class="' + _this.data('icon') + '"></span>&nbsp;&nbsp;' + _this.data('name') + '</h4>');
            var dl = $('<dl></dl>');
            if(_this.data('type') != 'folder'){
                dl.append('<dt>Extension</dt><dd>' + _this.data('ext') + '</dd>');
                dl.append('<dt>MIME</dt><dd>' + _this.data('mime') + '</dd>');
			}
            dl.append('<dt>Size</dt><dd>' + $this._formatSizeUnits(_this.data('size')) + '</dd>');
            if(_this.data('type') != 'folder')
            	dl.append('<dt>Url</dt><dd>' + _this.data('path') + '</dd>');
            dl.append('<br/>');
			if(_this.data('title') != null)
                dl.append('<dt>Title</dt><dd>' + _this.data('title') + '</dd>');
			if(_this.data('description') != null)
                dl.append('<dt>Description</dt><dd>' + _this.data('description') + '</dd>');
            dl.append('<br/>');
            infopane.append(dl);
            infopane.append('<button class="btn btn-default btn-xs btn-edit-meta" data-media-id="'+_this.data('id')+'"><i class="fa fa-pencil"></i> '+ __('Set title and description') +'</button>');


			if( _this.data('type') == 'document' ||
				_this.data('type') == 'picture')
            	infopane.append('<button class="btn btn-default btn-xs btn-replace-media" data-media-id="'+_this.data('id')+'"><i class="fa fa-paperclip"></i> '+ __('Replace this file') +'</button>');

            if(_this.data('type') == 'video_ext' && !$this.settings.inception)
                infopane.append(' <button class="btn btn-default btn-xs btn-edit-thumbnail" data-media-id="'+_this.data('id')+'"><i class="fa fa-picture-o"></i> '+__('Set video thumbnail')+'</button>');

			$this.$rightPane.empty();
			$this.$rightPane.css('visibility', 'visible');
			$this.$rightPane.append(infopane);
			$this.$rightPane.append('<br />');

			//Load the preview
			var type = _this.data('type');
			var url = _this.data('path');
			var text = _this.data('text');
			var mime = _this.data('mime');
			var thumbnailUrl = _this.data('thumbnailUrl');

			if(type == 'picture') {
				var img = $('<img />');
				 img.attr('width', '100%')
					.attr('src', url)
					.attr('title', text);
					
				$this.$rightPane.append(img);
			}
			else if(type == 'music') {
				$this.$rightPane.append('\
					<audio width="100%" controls>\
						<source type="'+mime+'" src="'+url+'">\
						'+__('Your browser does not support the audio tag')+'.\
					</audio>\
				');
			}
			else if(type == 'video') {
				$this.$rightPane.append('\
					<video width="100%" controls>\
						<source src="'+url+'" type="'+mime+'">\
						'+__('Your browser does not support the video tag')+'.\
					</video>\
				');
			}
            else if(type == 'video_ext' && thumbnailUrl != ''){
                var img = $('<img />');
                img.attr('width', '100%')
                    .attr('src', thumbnailUrl+"?rnd="+Math.random())
                    .attr('title', text);

                $this.$rightPane.append(img);
			}
			else {
				$this.$rightPane.append('<p style="margin-top : 50px; margin-bottom : 50px;" class="text-center">'+__('No preview') +'</p> ');
			}

			$('.btn-edit-meta').click(function(){
				var id = $(this).data('media-id');
				var url = route('media.edit', { id : id });
				omega.ajax.query(url, {}, 'GET', function(html){
					var modalId = omega.modal.open(__('Edit Media'), html, __('Save'), function(){
                        var $form = $('#editMediaForm');
						url = route('media.update', { id : id });
						var args = $form.serialize();
						console.log(args);
						omega.ajax.query(url, args, 'POST', function(){
							omega.modal.hide(modalId);
							$this._load(function(){
								$this._focusItem(id);
							});
						});
					});
				});
			});

			if( _this.data('type') == 'document' ||
				_this.data('type') == 'picture') {
				$('.btn-replace-media').click(function(){
					var id = $(this).data('media-id');
					$this._uploader(id);
				});
			}

            if(_this.data('type') == 'video_ext' && !$this.settings.inception)
				$('.btn-edit-thumbnail').rsMediaChooser({
					multiple: false,
					inception: true,
					allowedMedia: ['picture'],
					doneFunction: function (data, button) {
						var id = button.data('media-id');
						url = route('media.update.thumbnail', { id : id });
						var mediaId = data.id;
						omega.ajax.query(url, { mediaId : mediaId }, 'POST', function(){
							$this._load(function(){
								$this._focusItem(id);
							});
						});
					}
				});
    	});
    	
    	this.$icons.on('dblclick', function(e){
    		if($(this).data('type') == 'folder')
    		{
	    		$this.parent = $(this).data('id');
	    		$this._load();
    		}
    		else
    		{
    			window.open($(this).data('path'));
    		}
    	});
    	$(function () {
		  $('[data-toggle="tooltip"]').tooltip()
		})
    },

	_focusItem : function(id) {
		this.$icons.each(function(){
			if(id == $(this).data('id'))
			{
				$(this).trigger('click');
			}
		});
	},

    _load: function(callback) {

    	var $this = this;
    	$this.$contentPane.html('<div class="text-center"><img src="'+this.settings.gifLoader+'" /></div>');
    	$this.$rightPane.empty();
		$this.$rightPane.css('visibility', 'hidden');
    	$.ajax({
    		url : omega.mvc.url('media', 'dc'),
	        type: 'POST',
	        dataType: 'json',
	        data: { parent: $this.parent }
    	}).done(function(json) {
        	$this.$contentPane.empty();
			if(json.content.length == 0)
			{
				$this.$contentPane.append('<p class="text-center">'+__('This folder is empty ...')+'</p>');
			}
    		$.each(json.content, function(){

				var name = this.name.length > 12 ? this.name.substring(0, 12) + ' ...' : this.name;

    			var elem = $('<div class="icon"></div>');
				var icon = $('<div class="row"><span class="picture-icon ' + this.icon + '"></span></div>');
				var text = $('<div class="row text-icon">' + name + '</div>');

    			elem.attr('data-toggle', 'tooltip')
    				.attr('data-placement', 'bottom')
    				.attr('title', this.name)
					.data('id', this.id)
    				.data('ext', this.ext)
					.data('type', this.type)
					.data('size', this.size)
					.data('name', this.name)
					.data('parent', this.parent)
					.data('mime', this.mime)
					.data('icon', this.icon)
					.data('path', this.path)
					.data('title', this.title)
					.data('description', this.description)
                    .data('thumbnailUrl', this.thumbnailUrl)
					.append(icon)
					.append(text);
    			
    			$this.$contentPane.append(elem);
    		});
        	$this._createBreadCrumb(json.breadcrumb);
    	    $this._setContentOnClick();

			if (typeof callback !== 'undefined') {
				callback();
			}
    	});
    }, 
    
    _action: function(_action, _data, _successMessage, _errorMessage) {
    	var $this = this;
    	$this.$contentPane.html('<div class="text-center"><img src="'+this.settings.gifLoader+'" /></div>');
    	$this.$rightPane.empty();
    	$.ajax({
    		url : omega.mvc.url('media', _action),
	        type: 'POST',
	        dataType: 'json',
	        data: _data
    	}).done(function(){
    		$this._load();
            omega.notice.success(undefined, _successMessage);
    	}).fail(function(){
            omega.notice.error(undefined, _errorMessage);
    	});
    },
    
    _combinePath: function(first, second) {

		var partA = first.split('\\');
    	var partB = second.split('\\');
    	var aPart = $.merge(partA, partB);
    	var path = '';
    	$.each(aPart, function(){
    		if(this != '') 
    		{
    			path += this + '\\';
    		}
    	});
    	return path;
    },
    
	_formatSizeUnits: function (bytes){
        if      (bytes>=1000000000) {bytes=(bytes/1000000000).toFixed(2)+' GB';}
        else if (bytes>=1000000)    {bytes=(bytes/1000000).toFixed(2)+' MB';}
        else if (bytes>=1000)       {bytes=(bytes/1000).toFixed(2)+' KB';}
        else if (bytes>1)           {bytes=bytes+' bytes';}
        else if (bytes==1)          {bytes=bytes+' byte';}
        else                        {bytes='0 byte';}
        return bytes;
	},
	
    _uploader: function(replace) {



    	var $this = this;
		var url = this.settings.uploaderUrl;
		var args = { parent : $this.parent, isModal: 1 };

		if (typeof replace !== 'undefined') {
			args.replace = replace
		}

		omega.ajax.query(url, args, 'GET', function(html){
			omega.modal.open(__('Upload'), html, undefined, undefined, 'modal-lg');
			omega.modal.onHide(function(){
				$this._load(function(){
					if (typeof replace !== 'undefined') {
						$this._focusItem(replace);
					}
				});

			});
		});
    },
    
    _startCopingOrMoving: function(_copyParentSource, _filesToCopy, _mode) {
    	
    	this.isCopingOrMoving = true;
    	this.copyParentSource = _copyParentSource;
    	this.filesToCopy = _filesToCopy;
    	this.mode = _mode;
    }, 
    
    _finalizedCopingOrMoving: function(_copyDestination) {

		if(this.filesToCopy != undefined)
		{
			var $this = this;
			this.isCopingOrMoving = false;
			this.copyDestination = _copyDestination;

			var data = {
				mode: $this.mode,
				fileList: JSON.stringify($this.filesToCopy),
				newparent: $this.copyDestination
			};
			$this.filesToCopy = undefined;
			this._action('copyormove', data, __('Success'), __('Failed'));
		}
		else
		{
            omega.notice.warning(undefined, __("Nothing in clipboard"));
		}
    }
  };

  $.fn.rsExplorer = function(options) {
    return this.each(function() {
    	var rsExplorer = new RsExplorer(this, options).init();
    	$(this).data("rsExplorer", rsExplorer);
    });
  };
  $.fn.rsExplorer.defaults = {
	  rights : [
		  'mkdir', 'rm', 'rn', 'refresh', 'upload', 'download', 'copy', 'cut', 'paste', 'mkvideo'
	  ],
	  rootId : 1,
	  siteUrl: undefined,
	  uploaderUrl: undefined,
	  gifLoader: undefined,
      inception: false
  };
  $.fn.rsExplorer.settings = {};
  
})(jQuery);