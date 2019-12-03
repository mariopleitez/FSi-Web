<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class CountriesController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Country::select(['id','name', 'active', 'created_at', 'updated_at'])->orderBy("created_at", "desc");

             return Datatables::of($data)
                ->editColumn('active', function ($data) {
                    return ($data->active == 1) ? '<span class="label label-success status">Activo</span>' : '<span class="label label-warning status">Inactivo</span>';
                })
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('d/m/Y g:i A') : '';
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at ? with(new Carbon($data->updated_at))->format('d/m/Y g:i A') : '';;
                })
                ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
                })
                ->filterColumn('updated_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
                })
                ->addColumn('action', function ($data) {
                        return '<a data-toggle="modal" href="#modalDefault" link="'.route('countries.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar pais"><i class="icon-note icons"></i></a> '.
                               '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('countries.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
                })
                ->filterColumn('active', function ($query, $keyword) {
                    if (strtolower($keyword) == "activo" ) {
                        $query->where("active", 1);
                    }elseif (strtolower($keyword) == "inactivo") {
                        $query->where("active", 0);
                    }else{
                        $query->whereRaw("active like ?", ["%$keyword%"]);
                    }
                })
                ->rawColumns(['action', 'active'])
                ->make(true);

        }
        return view("admin.countries.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.countries.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        if (Country::create($request->all())) {
            return $this->crearRespuesta("El registro se ha creado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido creado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        return view("admin.countries.edit", compact("country"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        $this->validation($request, $country->id);
        if ($country->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $response = $country->delete();
        if($response){
            return $this->crearRespuesta("El registro se ha eliminado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
        }
    }


    public function validation($request, $id = null)
    {
        if ($id) {
            $reglas = [
                'name' => 'required|unique:countries,name,'.$id,
            ];
        }else{
            $reglas = [
                'name' => 'required|unique:countries',
            ];
        }
        $messages = [
            'name.unique'   => 'El campo pais ya ha sido utilizado',
            'name.required' => 'El campo pais es obligatorio.',
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
