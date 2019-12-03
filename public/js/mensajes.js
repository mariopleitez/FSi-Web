
	
/**
 * error, info, warning, success
 */

	function notificaciones (tipo, mensaje,titulo) {
		Command: toastr[tipo](mensaje, titulo)
		toastr.options = {
		  "closeButton": false,
		  "debug": false,
		  "newestOnTop": false,
		  "progressBar": false,
		  "positionClass": "toast-top-right",
		  "preventDuplicates": false,
		  "onclick": null,
		  "showDuration": "300",
		  "hideDuration": "1000",
		  "timeOut": "5000",
		  "extendedTimeOut": "1000",
		  "showEasing": "swing",
		  "hideEasing": "linear",
		  "showMethod": "fadeIn",
		  "hideMethod": "fadeOut"
		};
		if($('.toast-close-button').length === 0 ){
			$(".toast-"+tipo).prepend("<button type='button' class='toast-close-button' role='button'>×</button>");
		}
	}

