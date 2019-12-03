<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class PlansController extends ApiController
{

    public function __construct() {

        parent::__construct();
//        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($postid = null)
    {
        //$planes = Plan::where("active", 1)->get();
        $planes = Post::with('plans')->find($postid);
        //return $this->showAll($planes);
        return response()->json(['data' => $planes, 'codigo' => 200],200);

    }


    public function index3()
    {
        $planes = Plan::where("active", 1)->get();
        return $this->showAll($planes);

    }

}
