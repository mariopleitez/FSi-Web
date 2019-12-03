<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class CitiesController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = City::with('departamento')->orderBy("created_at", "desc")->select('cities.*');;

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
                    return '<a data-toggle="modal" href="#modalDefault" link="'.route('cities.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar ciudad"><i class="icon-note icons"></i></a> '.
                           '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('cities.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';                    
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
        return view("admin.cities.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departamentos = State::where("active", 1)->get();
        return view("admin.cities.create", compact("departamentos"));
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
        if (State::create($request->all())) {
            return $this->crearRespuesta("El registro se ha creado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido creado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        $departamentos = State::where("active", 1)->get();
        return view("admin.cities.edit", compact("city", "departamentos"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $this->validation($request, $city->id);
        if ($city->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $response = $city->delete();
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
                'name'     => 'required|unique:cities,name,'.$id,
                'state_id' => 'required|numeric'
            ];
        }else{
            $reglas = [
                'name'     => 'required|unique:cities',
                'state_id' => 'required|numeric'
            ];
        }
        $messages = [
            'name.unique'       => 'El campo ciudad ya ha sido utilizado',
            'name.required'     => 'El campo ciudad es obligatorio.',
            'state_id.required' => 'El campo departamento es obligatorio' 
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
