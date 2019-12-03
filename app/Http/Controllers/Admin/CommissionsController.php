<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Models\PaymentsProvider;
use App\Http\Controllers\AppController;

class CommissionsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $data = Commission::where("active", 1)->with("providers")->withCount('transactions');

            return Datatables::of($data)

               ->editColumn('updated_at', function ($data) {
                   return $data->updated_at ? with(new Carbon($data->updated_at))->format('d/m/Y g:i A') : '';;
               })

               ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('d/m/Y g:i A') : '';;
                })

               ->filterColumn('updated_at', function ($query, $keyword) {
                   $query->whereRaw("DATE_FORMAT(updated_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
               })

               ->filterColumn('created_at', function ($query, $keyword) {
                    $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y') like ?", ["%$keyword%"]);
                })

               ->addColumn('action', function ($data) {
                   // 1. SI YA TIENE TRANSACCIONES, SOLO PUEDE C REAR UNA NUEVA ESCOGIENDO EL TIPO
                   if($data->transactions_count > 0){
                       return "No es posible editar o eliminar la comisión debido a que existen ".$data->transactions_count." registros asociados.<br/> Cree un nuevo registro del tipo deseado y asigne los nuevos valores";
                   }else{
                        $tot = Commission::where("payments_provider_id", $data->payments_provider_id)->count();
                        // 2. SI SOLO EXISTE UNA SOLA ENTIDAD DEL TIPO SOLICITADO SOLO SE PUEDE EDITAR
                        if ($tot == 1){
                            return '<a data-toggle="modal" href="#modalDefault" link="'.route('commissions.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar comisión"><i class="icon-note icons"></i></a> ';
                        }else{
                            //3 . SI EXISTE MAS DE UNA  ENTIDAD DEL TIPO SOLICITADO SOLO SE PUEDE EDITAR Y ELIMINAR
                            return '<a data-toggle="modal" href="#modalDefault" link="'.route('commissions.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar comisión"><i class="icon-note icons"></i></a> '.
                            '<a data-toggle="modal" href="#modalNarrower" name="'.$data->providers->name.'" link="'.route('commissions.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';   
                        }
                   }
               })
               ->rawColumns(['action', 'active'])
               ->make(true);

       }
      //  $providers = PaymentsProvider::where("active", 1)->with("active_commision")->withCount('transactions')->get();
       
        //dd($providers);
        return view("admin.commissions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = PaymentsProvider::where("active", 1)->pluck("name", "id");
        return view("admin.commissions.create", compact("providers"));
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
        // 1. SE DEBE PONER INACTIVA LA COMISION ACTUALMENTE ACTIVA Y CREAR LA NUEVA COMISION
       Commission::where("active", 1)->update(['active' => 0]);
       if (Commission::create($request->all())) {
           return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
       }else{
           return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function show(Commission $commission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function edit(Commission $commission)
    {
        $commission->load("providers");
        $providers = PaymentsProvider::where("active", 1)->pluck("name", "id");
        return view("admin.commissions.edit", compact("commission", "providers"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Commission $commission)
    {
        $this->validation($request);
        if ($commission->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Commission  $commission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Commission $commission)
    {
        $response = $commission->delete();
        if($response){
            $last_comission = Commission::orderBy("id", "desc")->first();
            $last_comission->active = 1;
            $last_comission->save();
            return $this->crearRespuesta("El registro se ha eliminado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
        }
    }


    public function validation($request)
    {
        $reglas = [
            'payments_provider_id' => 'required|numeric',
            'percentage'           => 'required|numeric',
            'additional'           => 'required|numeric'
        ];

        $messages = [
            'payments_provider_id.numeric'  => 'El campo pasarela de pago es de tipo numerico',
            'payments_provider_id.required' => 'El campo pasarela de pago es obligatorio.',
            'percentage.required'           => 'El campo porcentaje es obligatorio.',
            'percentage.numeric'            => 'El campo porcentaje es de tipo numerico.',
            'additional.numeric'            => 'El campo Cargo adicional es de tipo numerico.',
            'additional.required'           => 'El campo Cargo adicional es obligatorio.'
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }


}
