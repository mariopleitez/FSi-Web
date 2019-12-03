@extends('admin.layouts.ajax')

@section('content')
<form action="{{ route('plans.store') }}" method="POST" id="paisCrear" enctype="multipart/form-data" class="formulario">
    {{ csrf_field() }}
    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group name">
                    <label class="control-label">Plan</label>
                    <input type="text" id="name" class="form-control" name="name" value="">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>    
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group plan_id">
                    <label class="control-label">Plan Id</label>
                    <input type="text" id="plan_id" class="form-control" name="plan_id" value="">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>    
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group amount">
                    <label class="control-label">Cantidad</label>
                    <input type="text" id="amount" class="form-control" name="amount" value="">
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                </div>    
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                   <label class="control-label">Estado</label>
                   <div class="form-check">
                       <label class="custom-control custom-radio">
                           <input id="radio1" name="active" type="radio" checked class="custom-control-input" value="1">
                           <span class="custom-control-indicator"></span>
                           <span class="custom-control-description">Activo</span>
                       </label>
                       <label class="custom-control custom-radio">
                           <input id="radio2" name="active" type="radio" class="custom-control-input" value="0">
                           <span class="custom-control-indicator"></span>
                           <span class="custom-control-description">Inactivo</span>
                       </label>
                   </div>
               </div>
           </div>
       </div>

        {{-- <div class="row">
             <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Estado</label>
                    <div class="form-check">
                        <label class="custom-control custom-radio">
                            <input id="radio1" name="active" type="radio" checked class="with-gap radio-col-green" value="1">
                            <label for="radio_40">Light GREEN</label>
                        </label>
                        <label class="custom-control custom-radio">
                            <input id="radio2" name="active" type="radio" class="ith-gap radio-col-yellow" value="0">
                            <label for="radio_40">Light GREEN</label>
                        </label>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
</form>
@endsection

