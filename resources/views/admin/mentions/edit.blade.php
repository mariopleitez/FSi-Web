@extends('admin.layouts.ajax')

@section('content')
	 <form action="{{ route('mentions.update', $mention->id) }}" method="POST" enctype="multipart/form-data" class="formulario">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="form-body">
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group name">
                        <label class="control-label">Mención</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $mention->name }}">
                    </div>    
                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-md-6">
                    <div class="form-group start">
                        <label class="control-label">Inicio</label>
                        <input type="text" id="start" class="form-control" name="start" value="{{ $mention->start }}">
                    </div>  
                </div>
                <div class="col-md-6">
                    <div class="form-group end">
                        <label class="control-label">Fin</label>
                        <input type="text" id="end" class="form-control" name="end" value="{{ $mention->end }}">
                    </div>  
                </div>
            </div>
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group stars">
                        <label class="control-label">Estrellas</label>
                        <select class="form-control select2" name="stars" data-placeholder="Seleccione una opción">
                            <option></option>
                            <option value="0" {{ ($mention->stars == 0) ? "selected" : "" }}>0</option>
                            <option value="0.5" {{ ($mention->stars == 0.5) ? "selected" : "" }}>0</option>
                            <option value="1" {{ ($mention->stars == 1) ? "selected" : "" }}>1</option>
                            <option value="1.5" {{ ($mention->stars == 1.5) ? "selected" : "" }}>1.5</option>
                            <option value="2" {{ ($mention->stars == 2) ? "selected" : "" }}>2</option>
                            <option value="2.5" {{ ($mention->stars == 2.5) ? "selected" : "" }}>2.5</option>
                            <option value="3" {{ ($mention->stars == 3) ? "selected" : "" }}>3</option>
                            <option value="3.5" {{ ($mention->stars == 3.5) ? "selected" : "" }}>3.5</option>
                            <option value="4" {{ ($mention->stars == 4) ? "selected" : "" }}>4</option>
                            <option value="4.5" {{ ($mention->stars == 4.5) ? "selected" : "" }}>4.5</option>
                            <option value="5" {{ ($mention->stars == 5) ? "selected" : "" }}>5</option>
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
                                <input id="radio1" name="active" type="radio" class="custom-control-input" value="1" {{ ($mention->active == 1) ? "checked" : "" }}>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Activo</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="radio2" name="active" type="radio" class="custom-control-input" value="0" {{ ($mention->active == 0) ? "checked" : "" }}>
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

