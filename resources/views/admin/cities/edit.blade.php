@extends('admin.layouts.ajax')

@section('content')
	 <form action="{{ route('cities.update', $city->id) }}" method="POST" enctype="multipart/form-data" class="formulario">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-body">
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group name">
                        <label class="control-label">Ciudad</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $city->name }}">
                    </div>    
                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group state_id">
                        <label class="control-label">Departamento</label>
                        <select class="form-control select2" name="state_id" data-placeholder="Seleccione un departamento">
                            <option></option>
                            @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id }}" {{ ($departamento->id == $city->state_id) ? "selected" : "" }}>{{ $departamento->name }}</option>
                            @endforeach
                        </select>
                    </div>    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                   <div class="form-group">
                       <label class="control-label">Estado</label>
                       <div class="form-check">
                            <label class="custom-control custom-radio">
                                <input id="radio1" name="active" type="radio" class="custom-control-input" value="1" {{ ($city->active == 1) ? "checked" : "" }}>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Activo</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="radio2" name="active" type="radio" class="custom-control-input" value="0" {{ ($city->active == 0) ? "checked" : "" }}>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Inactivo</span>
                            </label>
                       </div>
                   </div>
               </div>
           </div>
        </div>
    </form>
@endsection

