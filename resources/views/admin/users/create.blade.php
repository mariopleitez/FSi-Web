@extends('admin.layouts.ajax')

@section('content')
<form action="{{ route('users.store') }}" method="POST" id="userCrear" enctype="multipart/form-data" class="formulario">
    {{ csrf_field() }}
    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group name">
                    <label class="control-label">Nombre</label>
                    <input type="text" id="name" class="form-control" name="name" value="">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>    
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group email">
                    <label class="control-label">Email</label>
                    <input type="text" id="email" class="form-control" name="email" value="">
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>    
            </div>
        </div>


        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group role_id">
                    <label class="control-label">Roles</label>
                    <select name="role[]"  class="select2 form-control" multiple>
                        @foreach ($roles as $key => $value)
                        <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>    
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group password">
                    <label class="control-label">Password</label>
                    <input type="password" id="password" class="form-control" name="password" value="">
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                </div>    
            </div>
        </div>

        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group password_confirmation">
                    <label class="control-label">Confirmar password</label>
                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" value="">
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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

