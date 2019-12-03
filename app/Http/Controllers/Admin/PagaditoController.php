<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AppController;

class PagaditoController extends AppController
{
    public function index(Request $request)
    {

        $UID = "44b867bb8c4d25d5c6415e6d5e573c74";
        $WSK = "ac82426401ee5b82bc56368be4980e20";

        // Config
        $client = new \nusoap_client('https://sandbox.pagadito.com/comercios/wspg/charges.php?wdsl');
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;

        // Calls
         $params = array(
            "uid"           => $UID,
            "wsk"           => $WSK,
            "format_return" => "json"
          );
        $response = $client->call('connect', $params);
        $data_response = json_decode($response);
       //dd($data_response->code);
        dd($data_response);
        if ($data_response->code == "PG1001") {
            $token_pagadito = $data_response->value;
        
            $pending_charges = array();
            $details_cobro = array();
        
            $ern = "MEM-" . rand(1, 1000); //este debe ser un identificador de la transaccion en su plataforma
            $fecha_cobro = new DateTime(); //fecha actual para cobro inicial
        
            $details_cobro[] = array (
                    "quantity"      => 1,
                    "description"   => 'Costo por inscripcion',
                    "price"         => 25,//$25.00
                );
        
            $details_cobro[] = array (
                    "quantity"      => 1,
                    "description"   => 'Pago mes 1 mebresia xyz',
                    "price"         => 100,//$100.00
                );
        
            $pending_charges[] = array(
                "ern"           => $ern,
                "description"   => 'Membresia xyz',
                "date"          => $fecha_cobro->format('Y-m-d'),
                "amount"        => 125, //$125.00 monto total de la transaccion
                "details"       => $details_cobro
            );
        
            $params = array(
                "token"                     => $token_pagadito,
                "permissions"               => "initial_payment,automatic_charges",
                "pending_charges"           => json_encode($pending_charges),
                "currency"                  => "USD",
                "format_return"             => "json",
                "allow_pending_payments"    => "true",
                "custom_params"             => '[]',
            );
            $response = $cliente->call('authorization_recurring_payments', $params);
            $data_response = json_decode($response);
            if ($data_response->code == "PG1008") {
                $url_pago = $data_response->value;
                //redireccionar a la pantalla de pago de Pagadito
                /*header("location: $url_pago");
                exit();*/
                echo $url_pago . "\n";
            } else {
                echo "ERROR:" . $data_response->code . ": " . $data_response->message . "\n";
            }
        } else {
            echo "ERROR:" . $data_response->code . ": " . $data_response->message . "\n";
        }

        // $cliente = new nusoap_client(WSDL_PG);

        // $params = array(
        //     "uid"           => UID,
        //     "wsk"           => WSK,
        //     "format_return" => "json"
        //     );

        // $response = $cliente->call('connect', $params);
        // $data_response = json_decode($response);
    }
}
