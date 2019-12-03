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
                        <div class="col-md-12">
                            <div class="card card-body printableArea">
                                <h3><b>INVOICE</b> <span class="pull-right"># {{ $transaction->invoice }}</span></h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="pull-left">
                                            <address>
                                                <h3> &nbsp;<b class="text-danger">FundaSierra</b></h3>
                                                <p class="text-muted m-l-5">E 104, Dharti-2,
                                                    <br/> Nr' Viswakarma Temple,
                                                    <br/> Talaja Road,
                                                    <br/> Bhavnagar - 364002</p>
                                            </address>
                                        </div>
                                        <div class="pull-right text-right">
                                            <address>
                                                <h3>To,</h3>
                                                <h4 class="font-bold">{{ $transaction->user->name }}</h4>
                                                <p class="text-muted m-l-30">{{ isset($transaction->user->profile->address) ? $transaction->user->profile->address: '' }}
                                                    <br/> {{ isset($transaction->user->profile->country) ? $transaction->user->profile->country: '' }}
                                                    <br/>{{ isset($transaction->user->email) ? $transaction->user->email : '' }}
                                                    <br/> Bhavnagar - 364002</p>
                                                <p class="m-t-30"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> {{ $transaction->created_at->format("d/m/Y g:i A") }}</p>
                                                <p><b>Due Date :</b> <i class="fa fa-calendar"></i> 25th Jan 2017</p>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive m-t-40" style="clear: both;">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">#</th>
                                                        <th>Description</th>
                                                        <th class="text-right">Quantity</th>
                                                        <th class="text-right">Unit Cost</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center">1</td>
                                                        <td>Financiamiento</td>
                                                        <td class="text-right">$ {{ number_format($transaction->amount, 2, '.', ',') }} </td>
                                                        <td class="text-right"> $ {{ number_format($transaction->amount_less_commissions, 2, '.', ',') }}</td>
                                                        <td class="text-right"> {{ $transaction->stripe_id }} </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="pull-right m-t-30 text-right">
                                            <p>Sub - Total amount: $13,848</p>
                                            <p>vat (10%) : $138 </p>
                                            <hr>
                                            <h3><b>Total :</b> $13,986</h3>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="text-right">
                                            <button id="print" class="btn btn-default btn-outline" type="button"> <span><i class="fa fa-print"></i> Print</span> </button>
                                        </div>
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
    .tab-content{
        margin-bottom:50px;
    }
    table{
        width:100%;
    }
    .card>hr {
        margin-right: 0;
        margin-left: 0;
    }
    </style>
@endpush


@push('scripts')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/jquery.PrintArea.js') }}" type="text/JavaScript"></script>
    <script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
    </script>
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

