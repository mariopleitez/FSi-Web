   $(document).on('click', '.deleteRecord', function(event) {
      event.preventDefault();
      var link = $(this).attr('link');
      mensaje_exito = "El registro ha sido eliminado exitosamente";
      mensaje_error = "El registro no ha sido eliminado. Intente nuevamente más tarde o notifique al correo mariano.paz.flores@gmail.com";
      $.ajax({
          url: link,
          type: 'DELETE',
          dataType: 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        })
        .done(function(response) {
            notificaciones("success", mensaje_exito, 'Exito');
            setTimeout("$('#modalNarrower').modal('hide')", 250);
            oTable.ajax.reload();
        })
        .fail(function(response) {
          if (response.status == 422) {
              notificaciones("error", mensaje_error, 'Error');                
          }
        })
        .always(function() {
          
        });

   });

   $(document).on('click', '.modalsubmit', function(event) {
        event.preventDefault();
        var mensaje;
        $form = $("form.formulario");
        console.log($form.attr('method'));
        if ($form.attr('method') == 'POST') {
          mensaje_exito = "El registro ha sido creado exitosamente";
          mensaje_error = "El registro no ha sido creado. Corrija los errores en el formulario";
        }else{
          mensaje_exito = "El registro ha sido editado exitosamente";
          mensaje_error = "El registro no ha sido actualizado. Corrija los errores en el formulario";
        }
        $.ajax({
          url: $form.attr('action'),
          type: $form.attr('method'),
          dataType: 'json',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          data:  $form.serialize()
        })
        .done(function(response) {
            notificaciones("success", mensaje_exito, 'Exito');
            setTimeout("$('#modalDefault').modal('hide')", 250);
            oTable.ajax.reload();
        })
        .fail(function(response) {
          if (response.status == 422) {
            console.log(response.responseJSON);
            $('.alert1').remove();
            $.each(response.responseJSON, function(fieldName, message){
                    $('.'+fieldName).addClass('has-error'); 
                    $('.'+fieldName).find('.alert1').remove();
                    $('.'+fieldName).append('<div class="alert1 alert alert-danger">* '+message[0]+'</div>');
                    console.log(fieldName + ' '+message[0])
            });
            notificaciones("error", mensaje_error, 'Error');
          }
        })
        .always(function() {
          
        });
  });