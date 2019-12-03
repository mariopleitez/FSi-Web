@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
   <!-- ============================================================== -->
   <!-- Bread crumb and right sidebar toggle -->
   <!-- ============================================================== -->
   <div class="row page-titles">
       <div class="col-md-5 col-8 align-self-center">
           <h3 class="text-themecolor m-b-0 m-t-0">Usuarios</h3>
           <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
               <li class="breadcrumb-item active">Usuarios</li>
           </ol>
       </div>
       @include("includes/page_stats")
   </div>
   <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Usuarios</h4>
                    <h6 class="card-subtitle">Lista de usuarios del sistema.</h6>
                    <a data-toggle="modal" href="#modalDefault" link="{{ route('users.create') }}" class="btn btn-primary showModalButton" title="Nuevo usuario">
                            Nuevo (+)
                    </a>
                    <div class="table-responsive m-t-40">
                        <table id="usuarios-table" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                   <th>Nombre</th>
                                   <th>Role</th>
                                   <th>Email</th>
                                   <th>Estado</th>
                                   <th>Creado</th>
                                   <th>Modificado</th>
                                   <th>Acciones</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                   <th>Nombre</th>
                                   <th>Role</th>
                                   <th>Email</th>
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
    <script src="{{ asset('assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script>
        $(function() {
            var oTable = $('#usuarios-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users.index') !!}',
                //dom: 'lBfrtip',
                dom: '<<"top col-sm-12 pull-right"B> <"bottom"lf><t>ip>',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[ 0, "asc" ]],
                columns: [
                    { data: 'name', name: 'users.name' },
                    { data: 'role.name', name: 'role.name'},
                    { data: 'email', name: 'users.email' },
                    { data: 'active', name: 'users.active' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: "center"}
                ]
            });
            @include("includes/modalsubmit")
        });
    </script>
@endpush
 	