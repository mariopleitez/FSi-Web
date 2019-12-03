<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Mention;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppController;

class MentionsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Mention::select(['id','name', 'start', 'end', 'stars', 'active', 'created_at', 'updated_at'])->orderBy("created_at", "desc");

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
                        return '<a data-toggle="modal" href="#modalDefault" link="'.route('mentions.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar mención"><i class="icon-note icons"></i></a> '.
                               '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('mentions.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
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
        return view("admin.mentions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.mentions.create");
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
        if (Mention::create($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mention  $mention
     * @return \Illuminate\Http\Response
     */
    public function show(Mention $mention)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mention  $mention
     * @return \Illuminate\Http\Response
     */
    public function edit(Mention $mention)
    {
        return view("admin.mentions.edit", compact("mention"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mention  $mention
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mention $mention)
    {
        $this->validation($request, $mention->id);
        if ($mention->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mention  $mention
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mention $mention)
    {
        $response = $mention->delete();
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
                'name'  => 'required|min:5|unique:mentions,name,'.$id,
                'start' => 'required|numeric',
                'end'   => 'required|numeric',
                'stars' => 'required|numeric',
            ];
        }else{
            $reglas = [
                'name'  => 'required|min:5|unique:mentions',
                'start' => 'required|numeric',
                'end'   => 'required|numeric',
                'stars' => 'required|numeric',

            ];
        }

        $messages = [
            'name.unique'    => 'El campo mención ya ha sido utilizado.',
            'name.required'  => 'El campo mención es obligatorio.',
            'start.required' => 'El campo inicio es obligatorio.',
            'end.required'   => 'El campo fin es obligatorio.',
            'stars.required' => 'El campo estrellas es obligatorio.',
            'start.numeric'  => 'El campo inicio debe de ser tipo númerico.',
            'end.numeric'    => 'El campo fin debe de ser tipo númerico.',
            'stars.numeric'  => 'El campo estrellas debe de ser tipo númerico.',
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
