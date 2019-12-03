@extends('admin.layouts.app')

@section('content')

<!-- Begin page content -->
<div class="container-fluid">
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-8 align-self-center">
            <h3 class="text-themecolor m-b-0 m-t-0">Crear post</h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
                <li class="breadcrumb-item active">Crear post</li>
            </ol>
        </div>
       @include("includes/page_stats")
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- Row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0 text-white">Crear post</h4>
                </div>
                <div class="card-body">
                    <form role="form" action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postform">
                      {{ csrf_field() }}
                      <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                          <label for="definpu">Titulo</label>
                          <input type="text" class="form-control" id="definput" placeholder="" name="name" value="{{ old('name') }}" required>
                          @if ($errors->has('name'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('name') }}</strong>
                              </span>
                          @endif
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group {{ $errors->has('redactor') ? ' has-error' : '' }}">
                                <label for="definpu">Redactor</label>
                                <select name="redactor_id[]" id="" class="form-control select2" required multiple>
                                    @foreach ($redactores as $key => $value)
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('redactor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('redactor') }}</strong>
                                    </span>
                                @endif
                          </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group {{ $errors->has('redactor') ? ' has-error' : '' }}">
                                <label for="definpu">Código Stripe</label>
                                <input type="text" name="producto_stripe_id" class="form-control" required>
                                @if ($errors->has('redactor'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('redactor') }}</strong>
                                    </span>
                                @endif
                          </div>
                          </div>
                      </div>
                     

                      <div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
                        <label for="xsinput">Historia</label>
                        <textarea name="comment" class="form-control"  id="mymce" cols="30" rows="10" required>{{ old('comment') }}</textarea>
                        @if ($errors->has('comment'))
                            <span class="help-block">
                                <strong>{{ $errors->first('comment') }}</strong>
                            </span>
                        @endif
                      </div>
                      
                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group {{ $errors->has('posts_type_id') ? ' has-error' : '' }}">
                                <label for="sminput">Tipo de post</label>
                                <select name="posts_type_id" class="form-control select2" required>
                                    @foreach ($posts_types as $key => $value)
                                        <option value="{{ $value }}">{{ $key }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('posts_type_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('posts_type_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                       
                         <div class="col-md-4">
                           <div class="form-group">
                                   <label for="definpu">Fecha Fin </label>
                                   <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                                       <input type="text" name="end_date" class="form-control datetimepicker-input" data-target="#datetimepicker1" required>
                                       <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                           <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                       </div>
                                   </div>
                               </div>
                           <input type="hidden" id="dtp_input1" value="" /><br/>
                           @if ($errors->has('end_date'))
                               <span class="help-block">
                                   <strong>{{ $errors->first('end_date') }}</strong>
                               </span>
                           @endif
                         </div>

                         <div class="col-md-4">
                            <label for="definpu">Meta ($) </label>
                            <input type="text" class="form-control" id="goal" placeholder="" name="goal" value="{{ old('goal') }}" required>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                          </div>
                      </div>
                      <div class="form-group {{ $errors->has('tags') ? ' has-error' : '' }}">
                            <label for="definpu">Tags <span>(Presione enter luego de ingresar un tag)</span></label>
                            <select name="tags[]" class="form-control select2multiple" required multiple>
                                @foreach ($tags as $key => $value)
                                    <option value="{{ $value }}">{{ $key }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('tags'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                      </div>

                      <br/>
                      <hr>
                      <h2>Seleccione la ubicación del proyecto</h2>

                      <div class="row">
                          
                            <div class="col-md-4">
                                <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                                    <label for="definpu">Pais</label>
                                    <div id="getcountry">
                                    <select name="country_id" class="form-control select2" data-placeholder="Seleccione un pais" id="paisid" required>
                                        <option value=""></option>
                                        @foreach ($paises as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @if ($errors->has('country_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country_id') }}</strong>
                                        </span>
                                    @endif
                               </div>
                          </div>

                          <div class="col-md-4">
                              <div class="form-group {{ $errors->has('state_id') ? ' has-error' : '' }}">
                                    <label for="definpu">Departamento</label>
                                    <div id="getdepartamentos">
                                    <select name="state_id" class="form-control select2" data-placeholder="Seleccione un departamento" id="departamentoid" required >
                                        <option value=""></option>
                                    </select>
                                    </div>
                                    @if ($errors->has('state_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('state_id') }}</strong>
                                        </span>
                                    @endif
                               </div>
                          </div>

                          <div class="col-md-4">
                                <div class="form-group {{ $errors->has('ciudad_id') ? ' has-error' : '' }}">
                                    <label for="definpu">Ciudad</label>
                                    <div id="getciudades">
                                    <select name="city_id" class="form-control select2" data-placeholder="Seleccione una ciudad" id="ciudadid" required>
                                        <option value=""></option>
                                    </select>
                                    </div>
                                    @if ($errors->has('ciudad_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('ciudad_id') }}</strong>
                                        </span>
                                    @endif
                               </div>
                          </div>
                      </div>
                      <div class="row">
                            <input id="origin-input" class="controls " type="text" placeholder="¿Donde se realizará el proyecto?">
                            <input type="hidden" name="lat" id="txtlat">
                            <input type="hidden" name="lng" id="txtlng">
                            <div id="map"></div>
                      </div>

                      <hr>
                      <h2>Cree los planes de pagos</h2>
                      <a href="#" class="btn btn-primary pull-right" id="nuevoPlan">Nuevo Plan</a>
                      <br><br>
                      <div class="table-responsive">
                      <table class="table">
                          <thead>
                              <tr>
                                  <td style="width:30%">Pasarela</td>
                                  <td style="width:30%">Periocidad</td>
                                  <td style="width:30%">Código</td>
                                  <td style="width:10%">Eliminar</td>
                              </tr>
                          </thead>
                          <tbody id="tbody">
                                <tr>
                                    <td>
                                        <select name="pasarela[]" class="form-control select2" style="width:100%;" required>
                                            @foreach ($pasarelas as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="planes[]" class="form-control select2" style="width:100%;" required>
                                            @foreach ($planes as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="codigo[]" style="width:100%;" required>
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                          </tbody>
                      </table>
                      </div>   

                      <hr>
                      <h2>Seleccione las imagenes del post</h2>
                      <br/>

                    <div class="row">
                     <div class="col-sm-12">
                      <div class="form-group">
                        <label>Cargue un video</label>
                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                            <div class="form-control" data-trigger="fileinput" style="width:50%">
                                <i class="fa fa-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                            </div>
                            <span class="input-group-addon btn btn-secondary btn-file"> 
                                <span class="fileinput-new">Select file</span>
                            <span class="fileinput-exists">Change</span>
                            <input type="file" name="video">
                            </span>
                            <a href="#" class="input-group-addon btn btn-secondary fileinput-exists" data-dismiss="fileinput">Remove</a> </div>
                        </div>
                     </div>
                    </div>  
                       <div class="row">
                            <div class="col-md-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img data-src="holder.js/100%x100%" alt="100%x100%" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTkwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5MHgxNDA8L3RleHQ+PC9zdmc+" style="height: 100%; width: 100%; display: block;">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div style="text-align:center">
                                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="imagen1"></span>
                                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                  </div>
                            </div>
                            <div class="col-md-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img data-src="holder.js/100%x100%" alt="100%x100%" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTkwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5MHgxNDA8L3RleHQ+PC9zdmc+" style="height: 100%; width: 100%; display: block;">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div style="text-align:center">
                                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="imagen2"></span>
                                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                  </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img data-src="holder.js/100%x100%" alt="100%x100%" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTkwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5MHgxNDA8L3RleHQ+PC9zdmc+" style="height: 100%; width: 100%; display: block;">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div style="text-align:center">
                                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="imagen3"></span>
                                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                  </div>
                            </div>

                            <div class="col-md-3">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        <img data-src="holder.js/100%x100%" alt="100%x100%" src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTAiIGhlaWdodD0iMTQwIj48cmVjdCB3aWR0aD0iMTkwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk1IiB5PSI3MCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxMnB4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5MHgxNDA8L3RleHQ+PC9zdmc+" style="height: 100%; width: 100%; display: block;">
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
                                    <div style="text-align:center">
                                      <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="imagen4"></span>
                                      <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                    </div>
                                  </div>
                            </div>
                       </div>
                        
                        <hr>

                        <div class="form-actions" style="text-align: center">
                            <button type="submit" class="btn btn-success col-md-5"> <i class="fa fa-check"></i> CREAR</button>
                            <button type="button" class="btn btn-inverse col-md-5" id="cancelForm"> CANCELAR</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->
</div>
@endsection

@push('css')
<style>
    .thumbnail{
        display: block;
        padding: 4px;
        margin-bottom: 20px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
    .btn-file>input {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        opacity: 0;
        filter: alpha(opacity=0);
        font-size: 23px;
        height: 100%;
        width: 100%;
        direction: ltr;
        cursor: pointer !important;
    }
    .fileinput .btn {
    vertical-align: middle;
}
.btn-file {
    overflow: hidden;
    position: relative;
    vertical-align: middle;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
.fileinput .btn {
    vertical-align: middle;
}
.btn-file {
    overflow: hidden;
    position: relative;
    vertical-align: middle;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active, .open>.dropdown-toggle.btn-default {
    color: #333;
    background-color: #e6e6e6;
    border-color: #adadad;
}
.btn:active, .btn.active {
    background-image: none;
    outline: 0;
    -webkit-box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
    box-shadow: inset 0 3px 5px rgba(0,0,0,.125);
}
.input-group-text {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center;
    padding: .375rem .75rem;
    margin-bottom: 0;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    text-align: center;
    white-space: nowrap;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.input-group [data-toggle="datetimepicker"] {
    cursor: pointer;
}
.input-group-append {
    margin-left: -1px;
}
.input-group-append, .input-group-prepend {
    display: -ms-flexbox;
    display: flex;
}
</style>
<style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
          height: 500px;
          width: 70%;
          margin: 0 auto;
        }
        /* Optional: Makes the sample page fill the window. */
        .controls {
          margin-top: 10px;
          border: 1px solid transparent;
          border-radius: 2px 0 0 2px;
          box-sizing: border-box;
          -moz-box-sizing: border-box;
          height: 32px;
          outline: none;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
          margin-left:10px;
          width: 50%
        }
    
    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }
      #target {
        width: 345px;
      }
      #origin-input{
        padding-left: 20px;
      }
      .error{
        color: red;
      }
      </style>
@endpush

@push('scripts')
{{-- <script src="http://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script> --}}
{{-- <script src="{{ asset('plugins/jasny-bootstrap/js/jasny-bootstrap.min.js') }}"></script> --}}

<script src="{{ asset('assets/js/jasny-bootstrap.js') }}"></script>
<script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('assets/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset("js/tempusdominus-bootstrap-4.min.js")}}"></script>

<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({
            format: 'DD/MM/YYYY h:mm A',
            locale: 'es'
        });
    });
</script>

<script>

  @if ($errors->any())
   notificaciones("error", "El registro no ha sido creado. Corrija los errores en el formulario", "ERROR");
  @endif
  $(document).on('click', '#cancelForm', function(event) {
            event.preventDefault();
            $("#postform")[0].reset()
        });
        $(document).ready(function() {

            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    entity_encoding: "raw",
                    height: 300,
                    plugins: [
                        "advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | print preview  fullpage | forecolor backcolor emoticons",

                });
            }
    });
</script>
 <script>
        jQuery(document).ready(function() {
            // For select 2
            $(".select2").select2();
            $(".select2multiple").select2({
                tags: true
            });
            
        });


        </script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5qzKZiYqMbXePRPvpZuczJ77j_IEm-Ow&libraries=places&callback=initMap" async defer></script>
{{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA5qzKZiYqMbXePRPvpZuczJ77j_IEm-Ow&libraries=places" async defer></script> --}}
<script type="text/javascript">
function initMap() {
         var geocoder = new google.maps.Geocoder();
         var myLatLng = {lat: 13.7106262,  lng: -89.2047677 };
         var marker =  null;
         var map = new google.maps.Map(document.getElementById('map'), {
               mapTypeControl: false,
               center: myLatLng,
               mapTypeId: 'roadmap',
               zoom: 16
         });
 
         var input = document.getElementById('origin-input');
          var optionsPlaces = {
           types: ['(cities)'],
           componentRestrictions: {country: "sv"}
          };
         var searchBox = new google.maps.places.SearchBox(input, optionsPlaces);
         map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
         // Bias the SearchBox results towards current map's viewport.
         map.addListener('bounds_changed', function() {
           searchBox.setBounds(map.getBounds());
         });
           
         // Listen for the event fired when the user selects a prediction and retrieve
         // more details for that place.
         searchBox.addListener('places_changed', function() {
           var places = searchBox.getPlaces();
 
           if (places.length == 0) {
             return;
           }
           // For each place, get the icon, name and location.
           var bounds = new google.maps.LatLngBounds();
           places.forEach(function(place) {
             if (!place.geometry) {
               console.log("Returned place contains no geometry");
               return;
             }
             var icon = {
               url: place.icon,
               size: new google.maps.Size(71, 71),
               origin: new google.maps.Point(0, 0),
               anchor: new google.maps.Point(17, 34),
               scaledSize: new google.maps.Size(25, 25)
             };
 

             if (marker && marker.getMap) marker.setMap(map);
             marker = new google.maps.Marker({
               map: map,
               icon: icon,
               title: place.name,
               position: place.geometry.location,
               draggable:true
           });
 
             $("#txtlat").val(place.geometry.location.lat());
             $("#txtlng").val(place.geometry.location.lng());
 
             google.maps.event.addListener(marker, 'dragend', function(marker) {
                var latLng = marker.latLng;
                 $("#txtlat").val(latLng.lat());
                 $("#txtlng").val(latLng.lng());
             });
 
 
             if (place.geometry.viewport) {
               // Only geocodes have viewport.
               bounds.union(place.geometry.viewport);
             } else {
               bounds.extend(place.geometry.location);
             }
           });
           map.fitBounds(bounds);
         });
}
$a = 0;
$(document).on("click", "#nuevoPlan", function(e){
    e.preventDefault()
    var template = "<tr id='tr"+$a+"'>";
            template+="<td><select name='pasarela[]' class='form-control select2ajax' data-placeholder='Seleccione el tipo de pasarela' required>";
                @foreach($pasarelas as $key => $value)
                    template+="<option></option><option value='{{ $key }}'>{{ $value }}</option>";
                @endforeach
            template+="</select></td>";
            template+="<td><select name='planes[]' class='form-control select2ajax' data-placeholder='Seleccione el tipo de plan' required>";
                @foreach($planes as $key => $value)
                    template+="<option></option><option value='{{ $key }}'>{{ $value }}</option>";
                @endforeach
            template+="</select></td>";
            template+="<td><input type='text' name='codigo[]' class='form-control' required></td>";
            template+="<td><a href='#' class='btn btn-danger eliminarRow' num='"+$a+"'><i class='fa fa-trash'></i></td>";
        template+="</tr>";
    $("#tbody").append(template);
    $(".select2ajax").select2();
    $a++;
});

$(document).on("click", ".eliminarRow", function(e){
    e.preventDefault();
    var num = $(this).attr("num");
    $("tr#tr"+num).remove();
});

$("#postform").validate();

$(document).on("change", "#paisid", function(e){
    e.preventDefault();
    var id = $(this).val();
    $.ajax({
            url: '/admin/posts/getdepartamentos/' + id,
            type: 'GET',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          })
          .done(function(response) {
            $("#getdepartamentos").html(response);
            $(".select2ajax2").select2();
          })
          .fail(function(response) {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
});

$(document).on("change", "#departamentoid", function(e){
    e.preventDefault();
    var id = $(this).val();
    $.ajax({
            url: '/admin/posts/getciudades/' + id,
            type: 'GET',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          })
          .done(function(response) {
            $("#getciudades").html(response);
            $(".select2ajax2").select2();
          })
          .fail(function(response) {
            console.log("error");
          })
          .always(function() {
            console.log("complete");
          });
})



 </script>
@endpush