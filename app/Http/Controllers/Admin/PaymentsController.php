<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.payments.index');
    }

    public function subscribe(Request $request)
    {

        dd($request->all());
        $user = User::find(Auth::user()->id);
        $plan = 'Monthly-Silver';
        $stripe_token = $request->input('stripeToken');
        $response = $user->newSubscription('main', $plan)->create($stripe_token);
        dd($response);
        
    }


    public function changePlan()
    {
        try{
            $user = User::find(2);
            $newPlan = 'plan_Cdej0kmFIDUaAH';
            $user->subscription('main')
                ->skipTrial()
                ->swap($newPlan);
            dd("Success!!");

        }catch(\Stripe\Error\Card $e){
            $body  = $e->getJsonBody();
            $err   = $body['error'];
            $error = $err['message'];

            Log::critical(
                "Ciykd bit yodate credit card if {$user->email}{$e->getMessage()}, $error"
            );
        }
            catch(\Exception $e){
                dd("Something really bad");
            }
    }


    public function cancelPlan()
    {
        try {
            $user = User::find(2);
            $user->subscription('main')->cancelNow();
            dd("Success!!");
        }catch(\Stripe\Error\Card $e){
            $body  = $e->getJsonBody();
            $err   = $body['error'];
            $error = $err['message'];

            Log::critical(
                "Ciykd bit yodate credit card if {$user->email}{$e->getMessage()}, $error"
            );
        }

        catch(\Exception $e){
            dd("Something really bad");
        }
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
