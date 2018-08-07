// require jQuery
function Omega(abspath){
    this.abspath = abspath;
    this.html = new OmegaHtml(this);
    this.ajax = new OmegaAjax(this);
    this.modal = new OmegaModal(this);
    this.mvc = new OmegaMvc(this);
    this.plugin = new OmegaPlugin(this);
    this.location = new OmegaLocation(this);
    this.notice = new OmegaNotice(this);

    $(function(){
        $('.delete').click(function(){
            _this = $(this);
            omega.modal.confirm(__('Do you really want to delete this ?'), function(yes){
                if(yes)
                    $(location).attr('href', _this.data('url'));
            }, 'btn-danger');
            return false;
        });
    });
}
Omega.prototype = {
	//---- Public method ----//
	initSummerNote: function (selector) {
		var _this = this;
		$(selector).each(function () {
			var $this = $(this);
			var param = {
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['help', ['help']]
                ],
				height: $this.is('[height]') ? $this.attr('height') : 350,

				minHeight: null,             // set minimum height of editor
				maxHeight: null,             // set maximum height of editor

				focus: false,                 // set focus to editable area after initializing summernote
				onKeyup: function (e) {
					$this.val($(this).code());
					$this.change(); //To update any action binded on the control
				},
				onPaste: function(evt){
					evt.preventDefault();
					// Capture pasted data
					var text = evt.originalEvent.clipboardData.getData('text/plain'),
						html = evt.originalEvent.clipboardData.getData('text/html');
					// Clean up html input
					if (html) {
						html = Word_Entity_Scrubber.scrub(html);
						html = CleanWordPastedHTML(html);
					}
					// Do the
					var $dom = $('<div class="pasted"/>').html(html || text);
					$dom.find('meta').remove();
					$dom.find('link').remove();
					$dom.find('style').remove();
					$dom.find('*').removeAttr('class').removeAttr('style');
					$this.summernote('insertNode', $dom[0]);
					return false;
				}
			};

			var editor = $this.summernote(param);
			var $toolbar = $this.next('.note-editor').find('.note-toolbar');
			var $btngroup = $('<div class="note-omega btn-group"></div>');
            var $btnL = $('<button class="btn btn-default btn-sm btn-small" data-toggle="summernote-tooltip" title="'+__('Media Library')+'"><i class="fa fa-folder"></i></button>');
            var $btnM = $('<button class="btn btn-default btn-sm btn-small" data-toggle="summernote-tooltip" title="'+__('Insert a module')+'"><i class="fa fa-object-group"></i></button>');

			$btnL.rsMediaChooser({
				multiple: false,
				allowedMedia: [
					'picture', 'music', 'video', 'document'
				],
				doneFunction: function (data) {
					var html = '';
					switch (data.type) {
						case 'picture':
							html = '<img src="' + data.path + '" title="' + data.name + '" />';
							break;
                        case 'music':
                            html = '\
								<audio controls>\
									<source type="' + data.mime + '" src="' + data.path + '">\
									'+__('Your browser does not support the audio tag')+'.\
								</audio>\
							';
                            break;
                        case 'video':
                            html = '\
								<video controls>\
									<source src="' + data.path + '" type="' + data.mime + '">\
									'+__('Your browser does not support the video tag')+'.\
								</video>\
							';
                            break;
						default:
							html = '<a href="' + data.path + '">' + data.name + '</a>';
							break;
					}
					$this.summernote('editor.insertText', html);

				}
			});

			$btnM.rsModuleChooser({
				doneFunction: function (id) {
					var module = '[module=' + id + '][/module]';

					$this.summernote('editor.insertText', module);
				}
			});

			$btngroup.append($btnL);
			$btngroup.append($btnM);
			$toolbar.append($btngroup);

			$('[data-toggle="summernote-tooltip"]').tooltip({
				placement: 'bottom'
			});
		});
	},

	initDatePicker: function (selector) {
        $(selector).datepicker({
            format: 'yyyy-mm-dd',
		});
	}
	//---- Private method ----//
};




function CleanWordPastedHTML(sTextHTML) {
	var sStartComment = "<!--", sEndComment = "-->";
	while (true) {
		var iStart = sTextHTML.indexOf(sStartComment);
		if (iStart == -1) break;
		var iEnd = sTextHTML.indexOf(sEndComment, iStart);
		if (iEnd == -1) break;
		sTextHTML = sTextHTML.substring(0, iStart) + sTextHTML.substring(iEnd + sEndComment.length);
	}
	return sTextHTML;
}



