function OmegaModal(root){
	this.root = root;
	this.countModal = 0;
	this.hideCallback = undefined;
    this.htmlIdPre = 'omega-modal';
}
OmegaModal.prototype = {
	//---- Public method ----//
	open: function(title, content, submitText, submitCallback, modalDialogClass, modalButtonClass) {
		this.countModal++;
		var $this = this;

		if(typeof modalDialogClass === 'undefined') { modalDialogClass = '';}
        if(typeof modalButtonClass === 'undefined') { modalButtonClass = 'btn-primary';}
		if(typeof submitText === 'undefined') { submitText = '';}

		var html = this._createHtml(title, content, submitText, modalDialogClass, modalButtonClass);

		var $modal = $(html);
		$('body').append($modal);

		if(typeof submitCallback !== 'undefined'){
			$("#"+this.htmlIdPre+"-button-"+this.countModal).click(function(){submitCallback();});
		}

		$modal.modal('show');
		$modal.on('hidden.bs.modal', function (e) {
			if(typeof $this.hideCallback !== 'undefined') { $this.hideCallback(); }
			$(this).remove();
		});
		return this.countModal;
	},


	hide: function(id) {
        var $modal = this.__getModalById(id);
        $modal.modal('hide');
        window.setTimeout( function(){$modal.remove()}, 500 );
	},

	updateBody: function(id, html)
	{
        var $modal = this.__getModalById(id);
        $modalBody = $modal.find('.modal-body');
        $modalBody.empty();
        $modalBody.html(html);
	},

    alert: function(text, callback){
        this.countModal++;
        var html = this._createHtml(__('Alert'), text, '', 'modal-sm', 'btn-primary');
        var $modal = $(html);
        $('body').append($modal);
        $modal.modal('show');
        $modal.on('hide.bs.modal', function (e) {
            if(typeof callback !== 'undefined') {
                callback();
            }
        });
    },

	confirm: function(title, callback, modalButtonClass) {

        if(typeof modalButtonClass === 'undefined') { modalButtonClass = 'btn-primary';}
        this.countModal++;
        var _this = this;
        var mid = this.countModal;
        var html = this._createHtml(__('Confirm'), title, __('Yes'), 'modal-sm', modalButtonClass);
        var $modal = $(html);
        $('body').append($modal);
        var $yesButton = $("#"+this.htmlIdPre+"-button-"+this.countModal);
        $modal.modal('show');
        $yesButton.data('confirmed', false);
        if(typeof callback !== 'undefined'){
            $yesButton.click(function(){
                callback(true);
                $yesButton.data('confirmed', true);
                _this.hide(mid);
            });
        }
        $modal.on('hide.bs.modal', function (e) {
            if(typeof callback !== 'undefined') {
                if($yesButton.data('confirmed') == false){
                    callback(false);
                    $yesButton.data('confirmed', false);
                }
            }
        });
	},

    prompt: function(title, defaultValue, info, yesCallback, noCallback){
        this.countModal++;
        var _this = this;
        var mid = this.countModal;
        var content = '<input class="form-control" type="text" value="'+defaultValue+'" id="'+this.htmlIdPre+'-input-'+mid+'"/>' +
            '<p class="help-block">'+info+'</p>';
        var html = this._createHtml(title, content, __('Ok'), 'modal-sm', 'btn-primary');
        var $modal = $(html);
        $('body').append($modal)
        var $yesButton = $("#"+this.htmlIdPre+"-button-"+this.countModal)
        var input = $('#'+this.htmlIdPre+'-input-'+mid);

        $modal.on('shown.bs.modal', function () {
            input.focus().val('').val(defaultValue);
        });

        $modal.modal('show');

        input.focus();
        $yesButton.data('set', false);
        if(typeof yesCallback !== 'undefined'){
            $("#"+this.htmlIdPre+"-button-"+this.countModal).click(function(){
                yesCallback(input.val());
                $yesButton.data('set', true);
                _this.hide(mid);
            });
        }
        $modal.on('hide.bs.modal', function (e) {
            if(typeof noCallback !== 'undefined') {
                if($yesButton.data('set') == false){
                    noCallback();
                    $yesButton.data('set', false);
                }
            }
        });
    },

	onHide : function(callback){
		this.hideCallback = callback;
	},

	//---- Private method ----//
	_createHtml: function(heading, formContent, btnText, modalDialogClass, modalButtonClass){
        var html =  '<div id="'+this.htmlIdPre+'-'+this.countModal+'" class="modal modal_gen fade">';
		html += '<div class="modal-dialog '+modalDialogClass+'">';
		html += '<div class="modal-content">';
		html += '<div class="modal-header">';
		html += '<a class="close" data-dismiss="modal">×</a>';
		html += '<h4>'+heading+'</h4>';
		html += '</div>';
		html += '<div class="modal-body">';
		html += '<p>';
		html += formContent;
		html += '</div>';
		html += '<div class="modal-footer">';
		if (btnText!='') {
            html += '<span class="btn '+modalButtonClass+'" id="'+this.htmlIdPre+'-button-'+this.countModal+'">'+btnText;
            html += '</span>';
		}
		html += '<span class="btn btn-default" data-dismiss="modal">';
		html += __('Close');
		html += '</span>'; // close button
		html += '</div>';  // footer
		html += '</div>';  // content
		html += '</div>';  // dialog
		html += '</div>';  // modalWindow

		return html;
	},

    __getModalById: function(id){
        return $("#"+this.htmlIdPre+"-"+id);
    }
};
$(document).on('show.bs.modal', '.modal', function () {
    var zIndex = 1040 + (10 * $('.modal:visible').length);
    $(this).css('z-index', zIndex);
    setTimeout(function() {
        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        $('.modal-dialog').not('.modal-stack').css('z-index', zIndex + 1).addClass('modal-stack');
    }, 0);
});
$(document).on('hidden.bs.modal', '.modal_gen', function () {
    $(this).remove();
});