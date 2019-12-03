<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppController;

class SubscriptionController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::whereHas('subscripcion')->with('subscripcion')->select('users.*');
         //   return ($data);

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
                    return '<a href="'.route('subscriptions.show', [$data->id]).'" class="btn btn-primary"><i class="icon-list icons"></i></a> '.
                           '<a href="'.route('subscriptions.edit', [$data->id]).'" class="btn btn-info"><i class="icon-note icons"></i></a> '.
                           '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('subscriptions.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
               })

               ->addColumn('subscripcion', function ($data) {
                    return $data->subscripcion->map(function($specialty) {
                        return str_limit($specialty->stripe_plan, 30, '...');
                    })->implode('<br>');
                })
            //    ->filterColumn('users.active', function ($query, $keyword) {
            //        if (strtolower($keyword) == "activo" ) {
            //            $query->where("active", 1);
            //        }elseif (strtolower($keyword) == "inactivo") {
            //            $query->where("active", 0);
            //        }else{
            //            $query->whereRaw("active like ?", ["%$keyword%"]);
            //        }
            //    })
               ->rawColumns(['action', 'active', 'subscripcion'])
               ->make(true);

       }
       return view("admin.subscriptions.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.subscriptions.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $user->load("subscripcion", "profile", "transactions", "role");
        //dd(count($user->transactions));
        //dd($user);
        return view("admin.subscriptions.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view("admin.subscriptions.edit", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        try 
        {
            $this->cancelPlan("main", $subscription->user_id);
            $response = $subscription->delete();
            if($response){
                return $this->crearRespuesta("El registro se ha eliminado exitosamente", 200);
            }else{
                return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
            }
        }catch (Exception $e) {
            return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
        }

        
    }


    public function cancelPlan($name = "main", $userid = 5)
    {
        // $data = User::whereHas('subscripcion')->with('subscripcion')->get();
        // dd($data);
        // $user = User::with("subscripcion")->find($userid);
        // //dd($user);
        // // if ($user->subscribedToPlan('monthly', 'main2')) {
        // //     dd("si sirve");
        // // }

       
        // $user->subscription('main')->cancel();
        try {
            $user = User::find($userid);
            $user->subscription('main')->cancelNow();
            return true;
        }catch(\Stripe\Error\Card $e){
            $body  = $e->getJsonBody();
            $err   = $body['error'];
            $error = $err['message'];

            Log::critical(
                "Ciykd bit yodate credit card if {$user->email}{$e->getMessage()}, $error"
            );
        }

        // catch(\Exception $e){
        //     dd("Something really bad");
        // }
    }  
}
