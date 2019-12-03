@extends('admin.layouts.ajax')

@section('content')
<form action="{{ route('authors.update', $author->id) }}" method="POST"  id="authorCreate" enctype="multipart/form-data" class="formulario">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <div class="form-body">
        <div class="row p-t-20">
            <div class="col-md-12">
                <div class="form-group name">
                    <label class="control-label">Nombre</label>
                    <input type="text" id="name" class="form-control" name="name" value="{{ $author->name }}">
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                </div>    
            </div>
        </div>
        <div class="row p-t-20">
            <div class="col-md-12" style="text-align:center">
                <div class="form-group imagen">
                    <div class="fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                          @if (isset($author->imagen))
                            <img src="{{ Storage::url($author->imagen) }}" alt="">  
                          @else
                            <img data-src="holder.js/100%x100%" alt="100%x100%" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTkwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5MHgxNDA8L3RleHQ+PC9zdmc+" style="height: 100%; width: 100%; display: block;">
                          @endif
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                        <div style="text-align:center">
                          <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span>
                          <span class="fileinput-exists">Change</span><input type="file" name="imagen"></span>
                          <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                      </div>
                </div>    
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
               <div class="form-group">
                   <label class="control-label">Estado</label>
                   <div class="form-check">
                        <label class="custom-control custom-radio">
                            <input id="radio1" name="active" type="radio" class="custom-control-input" value="1" {{ ($author->active == 1) ? "checked" : "" }}>
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Activo</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input id="radio2" name="active" type="radio" class="custom-control-input" value="0" {{ ($author->active == 0) ? "checked" : "" }}>
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
