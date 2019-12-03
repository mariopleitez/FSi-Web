<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function crearRespuesta($datos, $codigo)
    {
    	return response()->json(['data' => $datos, 'codigo' => $codigo],$codigo);
    }

    public function crearRespuestaError($mensaje, $codigo)
    {
    	return response()->json(['message' => $mensaje, 'code' => $codigo],$codigo);	
    }
}
