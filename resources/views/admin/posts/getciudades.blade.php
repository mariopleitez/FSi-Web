@extends('admin.layouts.ajax')

@section('content')
<select name="city_id" class="form-control select2ajax2" data-placeholder="Seleccione una ciudad" id="ciudadid">
        <option value=""></option>
        @foreach ($ciudades as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
</select>
@endsection