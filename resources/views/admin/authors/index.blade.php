@extends('admin.layouts.app')

@section('content')
	    <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Redactores</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Redactores</li>
                        </ol>
                    </div>
                    @include("includes/page_stats")
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Redactores</h4>
                                <h6 class="card-subtitle">Lista de redactores</h6>
                                <div class="table-responsive m-t-40">
                                    <a data-toggle="modal" href="#modalDefaultAuthor" link="{{ route('authors.create') }}" class="btn btn-primary showModalButtonAuthor" title="Nuevo author">
                                        Nuevo (+)
                                    </a>
                                    <br/>
                                    <table id="posts-datatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Redactor</th>
                                                <th>Estado</th>
                                                <th>Creado</th>
                                                <th>Modificado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Redactor</th>
                                                <th>Estado</th>
                                                <th>Creado</th>
                                                <th>Modificado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>                
@endsection

@push("css")
    <style>
    .dt-buttons{
        float:right;
    }
    </style>
@endpush

@push('scripts')
	<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="http://malsup.github.com/jquery.form.js"></script> 
    <script>
        // prepare the form when the DOM is ready 
        $(document).ready(function() { 

             var oTable = $('#posts-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('authors.index') !!}',
                //dom: 'lBfrtip',
                dom: '<<"top col-sm-12 pull-right"B> <"bottom"lf><t>ip>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'active', name: 'active' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "center"}
                ]
            });
            @include('includes.modalsubmit')


            var options = { 
               // target:        '#output2',   // target element(s) to be updated with server response 
                beforeSubmit:  showRequest,  // pre-submit callback 
                success:       showResponse,  // post-submit callback 
                error:         showError,
                dataType:      'json'
            }; 
        
                // bind to the form's submit event 
                $(document).on("click",".modalsubmitauthor", function(e){
                    // inside event callbacks 'this' is the DOM element so we first 
                    // wrap it in a jQuery object and then invoke ajaxSubmit 
                    $("form#authorCreate").ajaxSubmit(options); 
                    // !!! Important !!! 
                    // always return false to prevent standard browser submit and page navigation 
                    return false; 
                });

              
                // pre-submit callback 
                function showRequest(formData, jqForm, options) { 
                    var queryString = $.param(formData);         
                    return true; 
                } 
                
                // post-submit callback 
                function showResponse(responseText, statusText, xhr, $form)  { 
                    notificaciones("success", "El registro ha sido creado exitosamente", 'Exito');
                    setTimeout("$('#modalDefaultAuthor').modal('hide')", 250);
                    oTable.ajax.reload();
                } 


            function showError(responseText, statusText, xhr, $form)  { 
                if(statusText === "error"){
                        $.each(responseText.responseJSON, function(fieldName, message){
                            $('.'+fieldName).addClass('has-error'); 
                            $('.'+fieldName).find('.alert1').remove();
                            $('.'+fieldName).append('<div class="alert1 alert alert-danger">* '+message[0]+'</div>');
                        });
                        notificaciones("error", "El registro no ha sido actualizado. Corrija los errores en el formulario", 'Error');
                }
            } 
        }); 
      

    </script>
    @if (session()->has("success"))
        <script type="text/javascript">
            notificaciones("success", "{!! session()->get('success') !!}", "EXITO");
        </script>
        @endif

        @if (session()->has("error"))
        <script type="text/javascript">
            notificaciones("error", "{!! session()->get('error') !!}", "ERROR");
        </script>
    @endif
@endpush


 	