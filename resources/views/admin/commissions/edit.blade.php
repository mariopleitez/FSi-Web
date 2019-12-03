@extends('admin.layouts.ajax')

@section('content')
	 <form action="{{ route('commissions.update', $commission->id) }}" method="PUT" class="formulario">
        {{ csrf_field() }}
        <div class="form-body">
            <div class="row p-t-20">
                <div class="col-md-12">
                    <div class="form-group payments_provider_id">
                       <div class="field-label">Pasarela de pago</div>
                         <div class="field-input">
                             <select class="form-control select2" name="payments_provider_id" data-placeholder="Seleccione una pasarela" id="selectpais">
                                <option value=""></option>
                                @foreach ($providers as $key => $value)
                                <option value="{{ $key }}" {{ ($commission->providers->id == $key) ? "selected" : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group percentage">
                        <label class="control-label">Porcentaje</label>
                        <input type="text" id="percentage" class="form-control" name="percentage" value="{{ $commission->percentage }}">
                    </div>  
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group additional">
                        <label class="control-label">Cargo adicional</label>
                        <input type="text" id="additional" class="form-control" name="additional" value="{{ $commission->additional }}">
                    </div>  
                </div>
            </div>
        </div>
    </form>
@endsection
