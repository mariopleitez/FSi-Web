<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\Webhooks\ChargeFailed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Webhooks\ChargeSucceeded;
use App\Mail\Webhooks\InvoicePaymentFailed;
use App\Mail\Webhooks\InvoicePaymentSucceeded;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{
     /**
     * Handle a Stripe webhook.
     *
     * @param  array  $payload
     * @return Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        // Handle The Event
         // Handle The Event
         Log::info('Estamos en handleInvoicePaymentSucceeded: '.print_r($payload, true));
         if(isset($payload["data"]["object"]["customer"])){
            $user = User::where('stripe_id', $payload["data"]["object"]["customer"])->first();
            if($user){
                $strip_record   = App\Models\Stripe::where('stripe_id', $payload["data"]["object"]["id"])->first();
                $producto       = Post::where("producto_stripe_id", $payload["data"]["object"]["lines"]["data"][0]["plan"]["product"])->first();
                $comision       = Commission::where("payments_provider_id", 1)->where("active", 1)->first();
                $verdadero_pago = $payload["data"]["object"]["amount_paid"] / 100;
                $comision_total = (($comision->percentage * $verdadero_pago) / 100) + $comision->additional;

                if($strip_record->id){
                    $new_transaction = Transaction::create([
                        'invoice'                 => $payload["data"]["object"]["id"],
                        'user_id'                 => $user->id,
                        'payments_provider_id'    => 1,
                        'stripe_id'               => $strip_record->stripe_id,
                        'post_id'                 => isset($producto->id) ? $producto->id : null,
                        'amount'                  => $verdadero_pago,
                        'amount_less_commissions' => $verdadero_pago - $comision_total,
                        'invoice_hosted'          => $payload["data"]["object"]["hosted_invoice_url"],
                        'invoice_pdf'             => $payload["data"]["object"]["invoice_pdf"]
                    ]);
                }else{
                    $new_transaction = Transaction::create([
                        'invoice'                 => $payload["data"]["object"]["id"],
                        'user_id'                 => $user->id,
                        'payments_provider_id'    => 1,
                        'post_id'                 => $payload["data"]["object"]["amount_paid"],
                        'amount'                  => $payload["data"]["object"]["amount_paid"],
                        'amount_less_commissions' => $verdadero_pago - $comision_total,
                        'invoice_hosted'          => $payload["data"]["object"]["hosted_invoice_url"],
                        'invoice_pdf'             => $payload["data"]["object"]["invoice_pdf"]
                    ]);
                }

                CommissionsTransaction::create([
                    'commission_id'  => $comision->id,
                    'transaction_id' => $new_transaction->id,
                    'amount'         => $verdadero_pago,
                    'comission'      => $comision_total,
                ]);

                Mail::to($user)->send(new InvoicePaymentSucceeded($user, $payload));
            }
            Log::info('Estamos en handleInvoicePaymentSucceeded: '.print_r($payload, true));
        }else{
            Log::info("no es array");
        }
    }

    public function handleChargeSucceeded($payload)
    {
        Log::info('Estamos en handleChargeSucceeded: '.print_r($payload, true));
        if(isset($payload["data"]["object"]["customer"])){
            $user = User::where('stripe_id', $payload["data"]["object"]["customer"])->first();
            if($user){
                Mail::to($user)->send(new ChargeSucceeded($user, $payload));
                // 1 crear el registro en tabla strip
                $stripe_record = App\Models\Stripe::create([
                                    'object'              => json_encode($payload),
                                    'invoice'             => $payload["data"]["object"]["invoice"],
                                    'active'              => 1,
                                    'balance_transaction' => $payload["data"]["object"]["balance_transaction"],
                                    'stripe_id'           => $payload["data"]["object"]["id"],
                                    'amount'              => $payload["data"]["object"]["amount"],
                                    'lastfour'            => $payload["data"]["object"]["payment_method_details"]['card']['last4'],
                                    'stripe_created'      => $payload["data"]["object"]["created"],
                                    'brand'               => $payload["data"]["object"]["payment_method_details"]['card']['brand'],
                                    'exp_year'            => $payload["data"]["object"]["payment_method_details"]['card']['exp_year'],
                                    'exp_month'           => $payload["data"]["object"]["payment_method_details"]['card']['exp_month'],
                                    'funding'             => $payload["data"]["object"]["payment_method_details"]['card']['funding'],
                                    'description'         => $payload["data"]["object"]["description"]
                                ]);
                // 2 Verificar si hay algun aregistro con el mismo invoice en stripe en
                $transaccion = Transacction::where("stripe_id", $stripe_record->id)->first();
                if($transaccion->id){
                    if(!isset($transaccion->stripe_id)){
                        $transaccion->stripe_id = $stripe_record->id;
                        $transaccion->save();
                    }
                }
            }
            //Log::info('Estamos en handleChargeSucceeded: '.print_r($payload, true));
        }else{
            Log::info("no es array");
        }
        
    }



    public function handleInvoicePaymentFailed($payload)
    {
        // Handle The Event
         // Handle The Event
         $user = User::where('email', $payload->data->object->receipt_email)->first();
         if($user){
             Mail::to($user)->send(new InvoicePaymentFailed($user, $payload));
         }
         Log::info('Estamos en handleInvoicePaymentFailed: '.$payload);
    }

    public function handleChargeFailed($payload)
    {
        // Handle The Event
        $user = User::where('email', $payload->data->object->receipt_email)->first();
        if($user){
            Mail::to($user)->send(new ChargeFailed($user, $payload));
        }
        Log::info('Estamos en handleChargeFailed: '.$payload);
    }

    
}
