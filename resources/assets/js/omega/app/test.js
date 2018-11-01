var omega = new Omega('http://localhost/omega-v2/');


var url = omega.mvc.url('page', 'list');
var data = { id : 2 };
omega.ajax.query(url, data, 'GET', function(data){
	omega.modal.open('Item', data, 'Save', function(){
		alert('Saved');
	});
});