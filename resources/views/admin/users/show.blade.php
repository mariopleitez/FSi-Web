@extends('admin.layouts.app')

@section('content')
	<div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
               <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> Usuarios </h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Ver usuario</li>
                        </ol>
                    </div>
                    @include("includes/page_stats")
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">{{ $user->name }}</h4>
                                <br><br>
                                <dl>
                                    <dt>Email:</dt>
                                    <dd>{{ $user->email }}</dd>

                                    <dt>Dirección:</dt>
                                    <dd>{{ isset($user->profile->address) ? $user->profile->address : '' }}</dd>

                                    <dt>Pais:</dt>
                                    <dd>{{ isset($user->profile->country) ? $user->profile->country: '' }}</dd>

                                    <dt>Rol:</dt>
                                    <dd>
                                        @foreach ($user->role as $role)
                                            {{ $role->name }}<br/>
                                        @endforeach
                                    </dd>

                                    <dt>Miembro desde:</dt>
                                    <dd>{{ $user->created_at->format("d/m/Y g:i A") }}</dd>
                                </dl>

                                <br>
                                <br>
                                <br>

                                <ul class="nav nav-tabs profile-tab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#doctores" role="tab" aria-expanded="true">Subscripciones</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#farmacias" role="tab" aria-expanded="false">Transacciones</a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="doctores" role="tabpanel" aria-expanded="true">
                                        <div class="card-body">
                                            <table id="subscription-datatable" class="display nowrap table table-hover table-striped table-bordered " cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                        <td>Nombre</td>
                                                        <td>Stripe ID</td>
                                                        <td>Stripe Plan</td>
                                                        <td>Cantidad</td>
                                                        <td>Acciones</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach ($user->subscripcion as $subscripcion)
                                                       <tr>
                                                           <td>{{ $subscripcion->name }}</td>
                                                           <td>{{ $subscripcion->stripe_id }}</td>
                                                           <td>{{ $subscripcion->stripe_plan }}</td>
                                                           <td>{{ $subscripcion->quantity }}</td>
                                                           <td class="center">
                                                                <a data-toggle="modal" href="#modalNarrower" name="{{ $subscripcion->name }}" link="{{ route('subscriptions.destroy', [$subscripcion->id]) }}" class="btn btn-danger showModalDeleteButton" title="{{ $subscripcion->name }}" ><i class="icon-trash icons"></i></a>
                                                           </td>
                                                       </tr>    
                                                   @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--second tab-->
                                    <div class="tab-pane" id="farmacias" role="tabpanel" aria-expanded="false">
                                        <div class="card-body">
                                            <table id="farmacias-datatable" class="display nowrap table table-hover table-striped table-bordered " cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Invoice</td>
                                                            <td>Stripe ID</td>
                                                            <td>Cantidad</td>
                                                            <td>Cantidad menos comisión</td>
                                                            <td>Fecha</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @for ($i = count($user->transactions) - 1; $i >= 0; $i--)
                                                        <tr>
                                                            <td>{{ $user->transactions[$i]->id }}</td>
                                                            <td>{{ $user->transactions[$i]->invoice }}</td>
                                                            <td>{{ $user->transactions[$i]->stripe_id }}</td>
                                                            <td>{{ $user->transactions[$i]->amount }}</td>
                                                            <td>{{ $user->transactions[$i]->amount_less_commissions }}</td>
                                                            <td>{{ Carbon\Carbon::parse($user->transactions[$i]->created_at)->format('d-m-Y g:i A') }}</td>
                                                        </tr>    
                                                        @endfor
                                                    </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
@endsection

@push("css")
    <style>
    .dt-buttons{
        float:right;
    }
    .tab-content{
        margin-bottom:50px;
    }
    table{
        width:100%;
    }
    </style>
@endpush


@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    
    <script>
        $(function() {
            var oTable = $('#subscription-datatable').DataTable({
                dom: '<<"top col-sm-12 pull-right"B> <"bottom"lf><t>ip>',
                order: [[ 0, "desc" ]],
            });
            @include('includes.modalsubmit')
        });
    </script>
@endpush

