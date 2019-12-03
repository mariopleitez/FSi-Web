<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class StatesController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = State::with('pais')->orderBy("created_at", "desc")->select('states.*');;

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
                    return '<a data-toggle="modal" href="#modalDefault" link="'.route('states.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar departamento"><i class="icon-note icons"></i></a> '.
                           '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('states.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
                 
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
        return view("admin.states.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paises = Country::where("active", 1)->get();
        return view("admin.states.create", compact("paises"));
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
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(State $state)
    {
        $state->load("pais");
        $paises = Country::where("active", 1)->get();
        return view("admin.states.edit", compact("state", "paises"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        $this->validation($request, $state->id);
        if ($state->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        $response = $state->delete();
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
                'name'    => 'required|unique:states,name,'.$id,
                'country_id' => 'required|numeric'
            ];
        }else{
            $reglas = [
                'name'    => 'required|unique:states',
                'country_id' => 'required|numeric'
            ];
        }
        $messages = [
            'name.unique'      => 'El campo departamento ya ha sido utilizado',
            'name.required'    => 'El campo departamento es obligatorio.',
            'country_id.required' => 'El campo pais es obligatorio' 
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
