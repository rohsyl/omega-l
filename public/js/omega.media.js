/*$(function(){
//-------------------------------------------------------------------------------------
//				OM_MEDIA > LIBRARY
//-------------------------------------------------------------------------------------	
	$(window).keypress(function(e) {
		var keyCode = e.keyCode || e.which; 
		if (keyCode == 46 && $('.remove_object_box').hasClass('hide'))
		{
			$('#remove-object').trigger('click');
			e.preventDefault();
			return true;
		}
	});
	
	
	
	$('#upload').click(function(){
		var box = $('.upload_file');
		var overlay = $('<div id=\"overlay\" class=\"om-overlay\"></div>');
		$('html').css('overflow', 'hidden');
		$('body').append(overlay);
		box.removeClass('hide');
		return false;
	});
	
	$('#download').click(function(){
		
		if($('.icon.selected').data('ext') != 'folder') {
			$(this).attr('download', $('.icon.selected').data('name') + '.' + $('.icon.selected').data('ext'));
			$(this).attr('href', $('.icon.selected').data('fullpath'));
			return true;
		}
		else
		{
			return false;
		}
	});
	
	$('#upload-all').click(function(){
		$('#files div p button').each(function(){
			$(this).trigger('click');
		});
	});
	
	
	var dropTarget = $('.dropzone'),
    html = $('html'),
    showDrag = false,
    timeout = -1;
	html.bind('dragenter', function () {
		dropTarget.addClass('dragging');
		showDrag = true; 
	});
	html.bind('dragover', function(){
		showDrag = true; 
	});
	html.bind('dragleave', function (e) {
		showDrag = false; 
		clearTimeout( timeout );
		timeout = setTimeout( function(){
			if( !showDrag ){ dropTarget.removeClass('dragging'); }
		}, 100 );
	});
	html.bind('drop',function( e ){
		showDrag = false; 
		clearTimeout( timeout );
		timeout = setTimeout( function(){
			if( !showDrag ){ dropTarget.removeClass('dragging'); }
		}, 100 );
	});
	
});*/