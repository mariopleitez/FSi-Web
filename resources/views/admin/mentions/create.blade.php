@extends('admin.layouts.ajax')

@section('content')
	 <form action="{{ route('mentions.store') }}" method="POST" enctype="multipart/form-data" class="formulario">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group name">
                        <label class="control-label">Mención</label>
                        <input type="text" id="name" class="form-control" name="name">
                    </div>    
                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-md-6">
                    <div class="form-group start">
                        <label class="control-label">Inicio</label>
                        <input type="text" id="start" class="form-control" name="start">
                    </div>  
                </div>
                <div class="col-md-6">
                    <div class="form-group end">
                        <label class="control-label">Fin</label>
                        <input type="text" id="end" class="form-control" name="end">
                    </div>  
                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group stars">
                        <label class="control-label">Estrellas</label>
                        <select class="form-control select2" name="stars" data-placeholder="Seleccione una opción">
                            <option></option>
                            <option value="0">0</option>
                            <option value="0.5">0.5</option>
                            <option value="1">1</option>
                            <option value="1.5">1.5</option>
                            <option value="2">2</option>
                            <option value="2.5">2.5</option>
                            <option value="3">3</option>
                            <option value="3.5">3.5</option>
                            <option value="4">4</option>
                            <option value="4.5">4.5</option>
                            <option value="5">5</option>
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
        </div>
    </form>
@endsection

