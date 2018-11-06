@if(Session::has('toasts'))
	<script type="text/javascript">
		$(function(){
			toastr.options = {
				"closeButton": true,
				"newestOnTop": true,
				"positionClass": "toast-bottom-right"
			};

			@foreach(Session::get('toasts') as $toast)
			toastr["{{ $toast['level'] }}"]("{{ $toast['message'] }}","{{ $toast['title'] }}");
			@endforeach
		});
	</script>
@endif
