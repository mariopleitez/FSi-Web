@if (session()->has("success"))
	@push('scripts')
	<script type="text/javascript">
		notificaciones("success", '{!! session()->get('success') !!}', 'Exito');
	</script>
	@endpush
@endif