//-------------------------------------------------------------------------------------
//				OM_PAGE > ADD, EDIT
//-------------------------------------------------------------------------------------
$(function(){
	

	$('.btn-tooltip').tooltip({
        placement: 'bottom'
	});

	// When the user is writing into a textarea, if he press the tab key,
	// this code prevent to switch to the next input and add a tab in the text 
	$(document).delegate('textarea', 'keydown', function(e) {
	
		var keyCode = e.keyCode || e.which;
	
		if (keyCode == 9) {
			e.preventDefault();
			var start = $(this).get(0).selectionStart;
			var end = $(this).get(0).selectionEnd;
	
			// set textarea value to: text before caret + tab + text after caret
			$(this).val($(this).val().substring(0, start)
						+ "\t"
						+ $(this).val().substring(end));
	
			// put caret at right position again
			$(this).get(0).selectionStart =
			$(this).get(0).selectionEnd = start + 1;
		}
	});
	//-------------------------------------------------------------------------------------
	
	$(window).keypress(function(event) {
		if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19))
		return true;
		//alert("Ctrl-S pressed");
		event.preventDefault();
		return false;
	});

	//-------------------------------------------------------------------------------------

    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) { // this refers to window
            $('.toolbar').addClass('fixed')
        }
        else{
            $('.toolbar').removeClass('fixed')
		}
    });
});