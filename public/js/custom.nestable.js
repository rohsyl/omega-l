$(function(){
	
	//Activate the nestable on the div
	$('#nestable').nestable();
	
	//Event when we click on one of the Add Element buttons
	$('.btn-add-element').click(function() {
	
		    action = $(this).data('action');
		    //if we add link
	        if (action === 'add_link') {
	
				var url = $('#link').val();
				var title = $('#title').val();
				
				if(url != '' && title != '') {
					$('#link').val('');
					$('#title').val('');
					add_element(url, title);
				}
	        }
	        //if we add page
	        if (action === 'add_page') {
	        
	        	$('#chkAll').prop('checked', false);
				$('#list-pages div input').each(function(i) { 
				
					if($(this).is(':checked')) {
					
				  		add_element($(this).data('alias'), $(this).val());
				  		$(this).attr('checked', false);
				  	}
				});
				
	        }

            if(action === 'add_module')
            {$('#list-webpart div input').each(function(i) {

                if($(this).is(':checked')) {

                    add_element($(this).data('url'), $(this).data('title'));
                    $(this).attr('checked', false);
                }
            });
            }
	});
	
	
	/*************************************************
	 * @goal:		When we check this checkbox, check all page's checkbox, in page list
	 *************************************************/
	$('#chkAll').click(function() {
	
	 	if($(this).is(':checked')) {
	 	
	 		$('#list-pages div input').each(function(i) { 
	 		
	 			$(this).prop('checked',true);
	 		});
	 	}
	 	else
	 	{
	 		$('#list-pages div input').each(function(i) { 
	 		
	 			$(this).prop('checked', false);
	 		});
	 	}
	});
	
	
	/*************************************************
	 *	@goal:		Add a element to the nestable
	 *	@input:		url -> The url
	 *				title -> The text which is displayed
	 *	@output: 	nothing
	 *************************************************/
	function add_element(url, title) {
	
		var li_element = $('<li class=\"dd-item\"></li>');
		li_element.append('<a href=\"#\" class=\"remove\" ><span style=\"float:right; position:absolute; right:5px; top:7px; cursor:pointer;\" class=\"glyphicon glyphicon-trash\"></span></a>');
		li_element.append('<a href=\"#\" class=\"edit\" data-title=\"'+title+'\" data-url=\"'+url+'\"><span style=\"float:right; position:absolute; right:25px; top:7px; cursor:pointer;\" class=\"glyphicon glyphicon-cog\"></span></a>');
		li_element.append('<div class=\"dd-handle\">'+title+'</div>');
		if($('#nestable ol:first li').length == 0)
		{
			$('#nestable ol:first').empty();
		}
		$('#nestable ol:first').append(li_element);
	}
	
	function serialize(ol) {
		var data,
	    list  = this;
	    step  = function(level)
	    {
	        var array = [ ],
	            items = level.children('li');
	        items.each(function()
	        {
	            var li   = $(this),
	                item = $.extend({}, li.find('a.edit').first().data()),
	                sub  = li.children('ol');
	            if (sub.length) {
	                item.children = step(sub);
	            }
	            array.push(item);
	        });
	        return array;
	    };
		data = step(ol);
		return data;
	}
});