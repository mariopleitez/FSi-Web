@extends('admin.layouts.ajax')

@section('content')
<select name="state_id" class="form-control select2ajax2" data-placeholder="Seleccione un departamento" id="departamentoid">
        <option value=""></option>
        @foreach ($estados as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
        @endforeach
</select>
@endsection