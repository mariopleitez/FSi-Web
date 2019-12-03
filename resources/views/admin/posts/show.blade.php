@extends('admin.layouts.app')

@section('content')
<!-- Begin page content -->
<div class="container-fluid">
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Editar post</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                <li class="breadcrumb-item active">Ver Post</li>
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
                                <h4 class="card-title" id="1">Post</h4>
                                <br><br>
                                <div class="row">
                                    <div class="col-6">
                                        <dl>
                                            <dt>Post:</dt>
                                            <dd>{{ $post->name }}</dd>

                                            <dt>Tipo:</dt>
                                            <dd>{{ isset($post->post_type->name) ? $post->post_type->name : '' }}</dd>

                                            <dt>Description:</dt>
                                            <dd>{{ isset($post->comment) ? $post->comment : '' }}</dd>

                                            <dt>Creado:</dt>
                                            <dd>{{ $post->created_at->format("d/m/Y g:i A") }}</dd>

                                            <dt>Creado Por:</dt>
                                            <dd>{{ $post->creator->name }}</dd>
                                        </dl>
                                    </div>
                                    <div class="col-6" style="text-align:center">
                                        {{ isset($post->transactions_total[0]->total ) ? "$ ".number_format($post->transactions_total[0]->total, '2', '.', ',')  : '' }}
                                    </div>
                                </div>

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
                                                        <td>Usuario</td>
                                                        <td>Email</td>
                                                        <td>Stripe ID</td>
                                                        <td>Pais</td>
                                                        <td>Acciones</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach ($post->users as $users)
                                                       <tr>
                                                           <td>{{ $users->name }}</td>
                                                           <td>{{ $users->email }}</td>
                                                           <td>{{ $users->stripe_id }}</td>
                                                           <td>{{ isset($users->profile->country) ?  $users->profile->country : '' }}</td>
                                                           <td class="center">
                                                                <a href="{{ route('users.show', $users->id) }}" class="btn btn-primary"><i class="icon-list icons"></i></a>
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
                                                        @for ($i = count($post->transactions) - 1; $i >= 0; $i--)
                                                        <tr>
                                                            <td>{{ $post->transactions[$i]->id }}</td>
                                                            <td>{{ $post->transactions[$i]->invoice }}</td>
                                                            <td>{{ $post->transactions[$i]->stripe_id }}</td>
                                                            <td>{{ $post->transactions[$i]->amount }}</td>
                                                            <td>{{ $post->transactions[$i]->amount_less_commissions }}</td>
                                                            <td>{{ Carbon\Carbon::parse($post->transactions[$i]->created_at)->format('d-m-Y g:i A') }}</td>
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

