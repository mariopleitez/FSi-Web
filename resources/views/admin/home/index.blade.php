@extends('admin.layouts.dashboard')

@section('content')
  <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active">Fundasierra</li>
                        </ol>
                    </div>
                    <div class="col-md-7 col-4 align-self-center">
                        <div class="d-flex m-t-10 justify-content-end">
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>MES ACTUAL</small></h6>
                                    <h4 class="m-t-0 text-info">{{ "$ ".number_format($total_mes_actual->total, 2, ".", ",") }}</h4></div>
                                <div class="spark-chart">
                                    <div id="monthchart"></div>
                                </div>
                            </div>
                            <div class="d-flex m-r-20 m-l-10 hidden-md-down">
                                <div class="chart-text m-r-10">
                                    <h6 class="m-b-0"><small>MES ANTERIOR</small></h6>
                                    <h4 class="m-t-0 text-primary">{{ "$ ".number_format($total_mes_anterior->total, 2, ".", ",") }}</h4></div>
                                <div class="spark-chart">
                                    <div id="lastmonthchart"></div>
                                </div>
                            </div>
                            {{-- <div class="">
                                <button class="right-side-toggle waves-effect waves-light btn-success btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-info"><i class="ti-wallet"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-light">$ {{ number_format($total, 2, '.', ',') }}</h3>
                                        <h5 class="text-muted m-b-0">Financiamiento</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-success"><i class="mdi mdi-currency-usd"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">$ {{ number_format($total_menos_comision, 2, '.', ',') }}</h3>
                                        <h5 class="text-muted m-b-0">Financiamiento neto</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-primary"><i class="ti-user"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">{{ $total_users }}</h3>
                                        <h5 class="text-muted m-b-0">Total usuarios</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div class="round round-lg align-self-center round-danger"><i class="ti-pencil-alt"></i></div>
                                    <div class="m-l-10 align-self-center">
                                        <h3 class="m-b-0 font-lgiht">{{ $total_posts }}</h3>
                                        <h5 class="text-muted m-b-0">Total de Posts</h5></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-inverse card-primary" style="margin-top:45px">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-wallet-travel"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total año</h3>
                                        <h6 class="card-subtitle">{{ date("Y") }}</h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 align-self-center">
                                        <h2 class="font-light text-white">
                                            {{ "$ ".number_format($total_anio_actual->total, 2, ".", ",").' ( $ '.number_format($total_anio_actual->total_without_comission, 2, ".", ",") .' )' }}
                                        </h2>
                                    </div>
                                    {{-- <div class="col-8 p-t-10 p-b-20 align-self-center">
                                        <div class="usage chartist-chart" style="height:65px"></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card card-inverse card-success">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-wallet-travel"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total año</h3>
                                        <h6 class="card-subtitle">{{ date("Y") -1 }}</h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 align-self-center">
                                        <h2 class="font-light text-white">
                                            {{ "$ ".number_format($total_anio_anterior->total, 2, ".", ",").' ( $ '.number_format($total_anio_anterior->total_without_comission, 2, ".", ",") .' )' }}
                                        </h2>
                                    </div>
                                    {{-- <div class="col-8 p-t-10 p-b-20 text-right">
                                        <div class="spark-count" style="height:65px"></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card card-inverse card-info">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="m-r-20 align-self-center">
                                        <h1 class="text-white"><i class="mdi mdi-wallet-travel"></i></h1></div>
                                    <div>
                                        <h3 class="card-title">Total año</h3>
                                        <h6 class="card-subtitle">{{ date("Y") -2 }}</h6> </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 align-self-center">
                                        <h2 class="font-light text-white">
                                            {{ "$ ".number_format($total_anio_dosanterior->total, 2, ".", ",").' ( $ '.number_format($total_anio_dosanterior->total_without_comission, 2, ".", ",") .' )' }}
                                        </h2>
                                    </div>
                                    {{-- <div class="col-8 p-t-10 p-b-20 text-right">
                                        <div class="spark-count" style="height:65px"></div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">Tipos de posts</h3>
                                <h6 class="card-subtitle">Posts clasificados por categorias</h6>
                                <div id="chartdiv2"></div>
                            </div>
                            <div>
                                <hr class="m-t-0 m-b-0">
                            </div>
                            <div class="card-body text-center ">
                                <ul class="list-inline m-b-0">
                                    @foreach($grafico_post_type as $stat)
                                    <li>
                                        <h6 class="text-muted" style="color: <?php echo $stat['color']; ?> !important"><i class="fa fa-circle font-10 m-r-10"></i>{{ $stat["tipo"].' ('.$stat['total'].')' }}</h6> 
                                    </li>                                    
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Current Visitors</h4>
                                <h6 class="card-subtitle">Different Devices Used to Visit</h6>
                                <div id="usa" style="height: 290px"></div>
                                <div class="text-center">
                                    <ul class="list-inline">
                                        <li>
                                            <h6 class="text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Valley</h6> </li>
                                        <li>
                                            <h6 class="text-info"><i class="fa fa-circle font-10 m-r-10"></i>Newyork</h6> </li>
                                        <li>
                                            <h6 class="text-danger"><i class="fa fa-circle font-10 m-r-10"></i>Kansas</h6> </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <!-- Row -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    {{-- <div class="col-lg-4 col-xlg-3 col-md-5">
                        <div class="card blog-widget">
                            <div class="card-body">
                                <div class="blog-image"><img src="../assets/images/big/img1.jpg" alt="img" class="img-responsive" /></div>
                                <h3>Business development new rules for 2017</h3>
                                <label class="label label-rounded label-success">Technology</label>
                                <p class="m-t-20 m-b-20">
                                    Lorem ipsum dolor sit amet, this is a consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                                </p>
                                <div class="d-flex">
                                    <div class="read"><a href="javascript:void(0)" class="link font-medium">Read More</a></div>
                                    <div class="ml-auto">
                                        <a href="javascript:void(0)" class="link m-r-10 " data-toggle="tooltip" title="Like"><i class="mdi mdi-heart-outline"></i></a> <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="Share"><i class="mdi mdi-share-variant"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="col-lg-8 col-xlg-9 col-md-7"> --}}
                    <div class="col-lg-12 col-xlg-12 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-wrap">
                                    <div>
                                        <h3 class="card-title">Ulitmos 12 meses</h3>
                                        <h6 class="card-subtitle">Resumen de los últimos 12 meses</h6>
                                    </div>
                                    {{-- <div class="ml-auto align-self-center">
                                        <ul class="list-inline m-b-0">
                                            <li>
                                                <h6 class="text-muted text-success"><i class="fa fa-circle font-10 m-r-10 "></i>Open Rate</h6> </li>
                                            <li>
                                                <h6 class="text-muted text-info"><i class="fa fa-circle font-10 m-r-10"></i>Recurring Payments</h6> </li>
                                        </ul>
                                    </div> --}}
                                </div>
                                <div id="chartdiv"></div>
                                {{-- <div class="campaign ct-charts"></div> --}}
                                <div class="row text-center">
                                    <div class="col-lg-6 col-md-6 m-t-20">
                                        <h1 class="m-b-0 font-light">
                                        {{ "$ ".number_format($total_anio_total, 2, ".", ",") }}
                                        </h1>
                                        <small>Financiamiento Total</small>
                                    </div>
                                    <div class="col-lg-6 col-md-6 m-t-20">
                                        <h1 class="m-b-0 font-light">
                                        {{ "$ ".number_format($total_anio_amount_less_commissions, 2, ".", ",") }}    
                                        </h1>
                                        <small>Financiamiento Neto</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <h4 class="card-title title_posts">Ultimos 5 Posts</h4>
                                    <div class="ml-auto">
                                        <select class="custom-select">
                                            <option value="1" selected="">Ultimos posts</option>
                                            <option value="2">Más financiados</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="table-responsive m-t-20">
                                    <table class="table stylish-table">
                                        <thead>
                                            <tr>
                                                <th colspan="2">Tipo</th>
                                                <th>Post</th>
                                                <th>Recaudado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $a = 0; @endphp
                                            @foreach ($posts as $item)
                                            <tr class='{{ ($a == 0 ) ? "active" : "" }} ultimos_posts'>
                                                <td style="width:50px;">
                                                    <a href="{{ route('posts.show', $item->id) }}">
                                                    <span class="round" style="background: <?php echo $item->post_type->color; ?>">
                                                        <?php echo substr($item->post_type->name,0,1); ?></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('posts.show', $item->id) }}">
                                                    <h6><?php echo $item->post_type->name; ?></h6>
                                                    <small class="text-muted">{{ $item->created_at->format('l d, F Y')}}</small>
                                                    </a>
                                                </td>
                                                <td><a href="{{ route('posts.show', $item->id) }}">{{ str_limit($item->name, 30, '...') }}</a></td>
                                                <td><a href="{{ route('posts.show', $item->id) }}">{{ isset($item->transactions_total[0]->total) ? "$ ".number_format($item->transactions_total[0]->total,2,'.',',') : "$ 0.00" }}</a></td>
                                            </tr>
                                            @php $a++; @endphp
                                            @endforeach
                                            @php $a = 0; @endphp
                                            @foreach ($mas_financiados as $item)
                                            <tr class='{{ ($a == 0 ) ? "active" : "" }} mas_financiados'>
                                                <td style="width:50px;">
                                                    <a href="{{ route('posts.show', $item->id) }}">
                                                    <span class="round" style="background: <?php echo $item->color; ?>">
                                                        <?php echo substr($item->tipo,0,1); ?></span>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('posts.show', $item->id) }}">
                                                    <h6><?php echo $item->tipo; ?></h6>
                                                    <small class="text-muted">{{ Carbon\Carbon::parse($item->created_at)->format('l d, F Y') }} </small>
                                                    </a>
                                                </td>
                                                <td><a href="{{ route('posts.show', $item->id) }}">{{ str_limit($item->name, 30, '...') }}</a></td>
                                                <td><a href="{{ route('posts.show', $item->id) }}">{{ isset($item->total) ? "$ ".number_format($item->total,2,'.',',') : "$ 0.00" }}</a></td>
                                            </tr>
                                            @php $a++; @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <!-- Column -->
                        <div class="card"> <img class="" src="../assets/images/background/profile-bg.jpg" alt="Card image cap">
                            <div class="card-body little-profile text-center">
                                <div class="pro-img"><img src="{{ asset('/img/user.png') }}" alt="user"></div>
                                <h3 class="m-b-0">{{ $usuario_mas_activo->name }}</h3>
                                <p>{{ $usuario_mas_activo->email }}</p>
                                {{-- <p><small>Lorem ipsum dolor sit amet, this is a consectetur adipisicing elit</small></p>  --}}
                                <a href="javascript:void(0)" class="m-t-10 waves-effect waves-dark btn btn-primary btn-md btn-rounded" style="cursor:auto;">
                                    {{ "$ ".number_format($usuario_mas_activo->total, 2, '.', ',') }}
                                </a>
                                {{-- <div class="row text-center m-t-20">
                                    <div class="col-lg-4 col-md-4 ml-auto m-t-20">
                                        <h3 class="m-b-0 font-light">23,469</h3><small>Followers</small></div>
                                </div> --}}
                            </div>
                        </div>
                        <!-- Column -->
                    </div>
                </div>
                <!-- Row -->
                <!-- Row -->
                <div class="row" style="display: none">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Recent Comments</h4>
                                <h6 class="card-subtitle">Latest Comments on users from Material</h6> </div>
                            <!-- ============================================================== -->
                            <!-- Comment widgets -->
                            <!-- ============================================================== -->
                            <div class="comment-widgets">
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/1.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5>James Anderson</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                        <div class="comment-footer"> <span class="text-muted pull-right">April 14, 2016</span> <span class="label label-info">Pending</span> <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                </span> </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row active">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/2.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text active w-100">
                                        <h5>Michael Jorden</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                        <div class="comment-footer "> <span class="text-muted pull-right">April 14, 2016</span> <span class="label label-light-success">Approved</span> <span class="action-icons active">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="icon-close"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
                                                </span> </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/3.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5>Johnathan Doeting</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry.</p>
                                        <div class="comment-footer"> <span class="text-muted pull-right">April 14, 2016</span> <span class="label label-danger">Rejected</span> <span class="action-icons">
                                                    <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                    <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                </span> </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2"><span class="round"><img src="../assets/images/users/4.jpg" alt="user" width="50"></span></div>
                                    <div class="comment-text w-100">
                                        <h5>James Anderson</h5>
                                        <p class="m-b-5">Lorem Ipsum is simply dummy text of the printing and type setting industry. Lorem Ipsum has beenorem Ipsum is simply dummy text of the printing and type setting industry..</p>
                                        <div class="comment-footer"> <span class="text-muted pull-right">April 14, 2016</span> <span class="label label-info">Pending</span> <span class="action-icons">
                                                        <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                                        <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                                        <a href="javascript:void(0)"><i class="ti-heart"></i></a>    
                                                    </span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <button class="pull-right btn btn-sm btn-rounded btn-success" data-toggle="modal" data-target="#myModal">Add Task</button>
                                <h4 class="card-title">To Do list</h4>
                                <h6 class="card-subtitle">List of your next task to complete</h6>
                                <!-- ============================================================== -->
                                <!-- To do list widgets -->
                                <!-- ============================================================== -->
                                <div class="to-do-widget m-t-20">
                                    <!-- .modal for add task -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Add Task</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">
                                                            <label>Task name</label>
                                                            <input type="text" class="form-control" placeholder="Enter Task Name"> </div>
                                                        <div class="form-group">
                                                            <label>Assign to</label>
                                                            <select class="custom-select form-control pull-right">
                                                                <option selected="">Sachin</option>
                                                                <option value="1">Sehwag</option>
                                                                <option value="2">Pritam</option>
                                                                <option value="3">Alia</option>
                                                                <option value="4">Varun</option>
                                                            </select>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                                                </div>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
                                    </div>
                                    <!-- /.modal -->
                                    <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputSchedule" name="inputCheckboxesSchedule">
                                                <label for="inputSchedule" class=""> <span>Schedule meeting with</span> </label>
                                            </div>
                                            <ul class="assignedto">
                                                <li><img src="../assets/images/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave"></li>
                                                <li><img src="../assets/images/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jessica"></li>
                                                <li><img src="../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                                <li><img src="../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                            </ul>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputCall" name="inputCheckboxesCall">
                                                <label for="inputCall" class=""> <span>Give Purchase report to</span> <span class="label label-danger">Today</span> </label>
                                            </div>
                                            <ul class="assignedto">
                                                <li><img src="../assets/images/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                                                <li><img src="../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                                            </ul>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputBook" name="inputCheckboxesBook">
                                                <label for="inputBook" class=""> <span>Book flight for holiday</span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputForward" name="inputCheckboxesForward">
                                                <label for="inputForward" class=""> <span>Forward all tasks</span> <span class="label label-warning">2 weeks</span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputRecieve" name="inputCheckboxesRecieve">
                                                <label for="inputRecieve" class=""> <span>Recieve shipment</span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputpayment" name="inputCheckboxespayment">
                                                <label for="inputpayment" class=""> <span>Send payment today</span> </label>
                                            </div>
                                            <div class="item-date"> 26 jun 2017</div>
                                        </li>
                                        <li class="list-group-item" data-role="task">
                                            <div class="checkbox checkbox-info">
                                                <input type="checkbox" id="inputForward2" name="inputCheckboxesd">
                                                <label for="inputForward2" class=""> <span>Important tasks</span> <span class="label label-success">2 weeks</span> </label>
                                            </div>
                                            <ul class="assignedto">
                                                <li><img src="../assets/images/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign to Steave"></li>
                                                <li><img src="../assets/images/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign to Jessica"></li>
                                                <li><img src="../assets/images/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Assign to Selina"></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
               
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
@endsection

@push("css")
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <style>
    #chartdiv, #chartdiv2 {
        width: 100%;
        height: 500px;
    }
    
    .amcharts-export-menu-top-right {
        top: 10px;
        right: 0;
    }
    tr.mas_financiados{
        display:none;
    }
    </style>
@endpush


@push('scripts')

<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<script src="https://www.amcharts.com/lib/3/pie.js"></script>
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

{{-- <script src="{{ asset('assets/plugins/amcharts/amcharts/') }}"></script>
<script src="{{ asset('assets/plugins/amcharts/amcharts/') }}"></script>
<script src="{{ asset('assets/plugins/amcharts/amcharts/') }}"></script>
<script src="{{ asset('assets/plugins/amcharts/amcharts/') }}"></script>
<script src="{{ asset('assets/plugins/amcharts/amcharts/') }}"></script> --}}
    <script>

    $(document).on("change", ".custom-select", function(e){
        var tipo = $(this).val();
        if(tipo == 1){
            $("tr.mas_financiados").hide();
            $("tr.ultimos_posts").show();
            $(".title_posts").text("Ultimos 5 Posts");
        }else{
            $("tr.mas_financiados").show();
            $("tr.ultimos_posts").hide();
            $(".title_posts").text("Top 5 Posts");
            
        }

    });

    var chart = AmCharts.makeChart("chartdiv", {
        "type": "serial",
        "theme": "light",
        "marginRight": 70,
        "dataProvider": [
        @foreach($grafico_mensual as $stat)
            {
                "mes":   "{{ $stat['mes'] }}",
                "color": "{{ $stat['color'] }}",
                "total": {{ number_format($stat['total'],2,'.',',') }}
            },

        @endforeach
        ],
        "valueAxes": [{
            "axisAlpha": 0,
            "position": "left",
            "title": "Total por mes"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<b>[[category]]: [[value]]</b>",
            "fillColorsField": "color",
            "fillAlphas": 0.9,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "total"
        }],
        "chartCursor": {
            "categoryBalloonEnabled": false,
            "cursorAlpha": 0,
            "zoomable": false
        },
        "categoryField": "mes",
        "categoryAxis": {
            "gridPosition": "start",
            "labelRotation": 45
        },
        "export": {
            "enabled": true
        }

        });
        
        var chart = AmCharts.makeChart( "chartdiv2", {
        "type": "pie",
        "theme": "light",
        "dataProvider": [
        @foreach($grafico_post_type as $stat)
            {
                "type":   "{{ $stat['tipo'] }}",
                "color": "{{ $stat['color'] }}",
                "value": "{{ $stat['total'] }}"
            },
        @endforeach
        ],
        "valueField": "value",
        "titleField": "type",
        "outlineAlpha": 0.4,
        "colorField": "color",
        "depth3D": 15,
        "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
        "angle": 30,
        "export": {
            "enabled": true
        }
        } );
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