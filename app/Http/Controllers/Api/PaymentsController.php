<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;

class PaymentsController extends ApiController
{

    public function __construct() {

        parent::__construct();
        $this->middleware('client.credentials')->only(['index', 'subscribe']);
    }

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
        try{
            $stripe_token = $request->input('stripeToken');
            $plan = $request->plan;
            $user = User::find($request->user()->id);
            
            if($request->singlePayment == 0){
                $response = $user->newSubscription('main', $plan)->create($stripe_token);
                return $this->showOne($response, 200);
            }else{
                $response = $user->charge($request->amount, [
                    'description' => 'A single payment charge',
                    'source'      => $stripe_token
                ]);
                $decimal  = substr($request->amount, -2);
                $longitud = strlen($request->amount) - 2;
                $entero   = substr($request->amount,0, $longitud);
                $cantidad = floatval($entero.'.'.$decimal);
                return response()->json(['stripe_plan' => '$ '.number_format($cantidad, 2,'.', ',')], 200);
            }
            
            
        }catch(\Stripe\Error\Card $e){
            $body  = $e->getJsonBody();
            $err   = $body['error'];
            $error = $err['message'];
            return $this->errorResponse($error, 422);
            //return response()->json(["data" => $e->getMessage() ], 422);
        }

    }


    public function changePlan()
    {
        try{
            $user = User::find(Auth::user()->id);
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
            $user = User::find(Auth::user()->id);
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
}
