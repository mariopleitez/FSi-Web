@extends('admin.layouts.app')

@section('content')
	    <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Ciudades</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ciudades</li>
                        </ol>
                    </div>
                    @include("includes/page_stats")
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Ciudades</h4>
                                <h6 class="card-subtitle">Lista de ciudades</h6>
                                <div class="table-responsive m-t-40">
                                    <a data-toggle="modal" href="#modalDefault" link="{{ route('cities.create') }}" class="btn btn-primary showModalButton" title="Nueva ciudad">
                                        Nuevo (+)
                                    </a>
                                    <br/>
                                    <table id="ciudades-datatable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Ciudad</th>
                                                <th>Departamento</th>
                                                <th>Estado</th>
                                                <th>Creado</th>
                                                <th>Modificado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Ciudad</th>
                                                <th>Departamento</th>
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
    <script>
        $(function() {
            var oTable = $('#ciudades-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('cities.index') !!}',
                //dom: 'lBfrtip',
                //dom: '<<"top col-sm-12 pull-right"B> <"bottom"lf><t>ip>',
                dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[ 0, "asc" ]],
                columns: [
                    { data: 'name', name: 'name' },
					{ data: 'departamento.name', name: 'departamento.name' },
                    { data: 'active', name: 'active' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "center"}
                ]
            });
            @include("includes/modalsubmit")
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


 	