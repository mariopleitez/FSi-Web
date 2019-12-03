<?php

namespace App\Http\Controllers\Admin;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Plan::select('plans.*');

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
                return //   '<a href="'.route('plans.show', [$data->id]).'" class="btn btn-primary"><i class="icon-list icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalDefault" link="'.route('plans.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar el tipo de plan"><i class="icon-note icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('plans.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
               })
               ->filterColumn('plans.active', function ($query, $keyword) {
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

        return view('admin.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans.create');
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
        if (Plan::create($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        return view('admin.plans.show', compact("plan"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {

        return view('admin.plans.edit', compact("plan"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $this->validation($request, $plan->id);
        if ($plan->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        $response = $plan->delete();
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
                'name'    => 'required|min:5|unique:plans,name,'.$id,
                'amount'  => 'required|numeric',
                'plan_id' => 'required|unique:plans,plan_id,'.$id,
            ];
        }else{
            $reglas = [
                'name'    => 'required|min:5|unique:plans',
                'amount'  => 'required|numeric',
                'plan_id' => 'required',
                'plan_id' => 'required|unique:plans',
            ];
        }

        $messages = [
            'name.unique'      => 'El campo plan ya ha sido utilizado.',
            'name.required'    => 'El campo plan es obligatorio.',
            'plan_id.unique'   => 'El campo plan-id ya ha sido utilizado',
            'plan_id.required' => 'El campo plan-id es obligatorio.',
            'amount.required'  => 'El campo cantidad es obligatorio.',
            'amount.numeric'   => 'El campo cantidad debe de ser tipo númerico.',
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
