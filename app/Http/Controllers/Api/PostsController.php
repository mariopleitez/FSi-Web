<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\PostsRelationsUser;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Auth;

class PostsController extends ApiController
{


    public function __construct() {

        parent::__construct();
        //$this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where("active", 1)
                     ->orderBy("id", "desc")
                     ->with("post_type", "images", "authors", "ciudad.departamento.pais", "tags")
                     ->withCount("likes")
                     ->paginate(5);

        $datos = [];
        foreach($posts as $post){
            $post->image           = str_replace("public",'storage', $post->image);
            $post->extract_name    = str_limit($post->name, 30, '...');
            $post->extract_comment = str_limit(strip_tags($post->comment), 300, '...');
            $post->date_format     = $post->created_at->format('l d, F Y');

            $date     = new \DateTime($post->end_date);
            $now      = new \DateTime();
            $restante = $date->diff($now);


            $tiempo = "";
            if($restante->d > 0){
                $tiempo = ($restante->d > 1) ? $restante->d.' dias' : $restante->d. " dia";
            }else{
                if($restante->h > 0){
                    $tiempo = ($restante->h > 1) ? $restante->h.' horas' : $restante->h. " hora";
                }elseif($restante->i > 0){
                    $tiempo = ($restante->i > 1) ? $restante->h.' minutos' : $restante->i. " minuto";
                }else{
                    $tiempo = -1;
                }
            }

            
            $post->time_remaining = $tiempo;

            $financiado = DB::table("posts")
                            ->leftJoin('transactions', 'transactions.post_id', '=', 'posts.id')
                            ->leftJoin('posts_types', 'posts_types.id', '=', 'posts.posts_type_id')
                            ->whereNull("transactions.deleted_at")
                            ->whereNull("posts.deleted_at")
                            ->where("posts.id", $post->id)
                            ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total_less_commissions, IFNULL(SUM(transactions.amount),0)  as total, posts.name, posts_types.name as tipo, posts_types.color, posts.created_at, posts.id')
                            ->groupBy('posts.name', 'color', 'tipo', 'posts.created_at', 'posts.id')
                            ->orderBy('TOTAL', 'desc')
                            ->first();

            $total = floatval($financiado->total);
            
            $post->financiado = $total;

            if($post->goal == 0){
                $post->porcentaje = "0.00";
            }else{
                $post->porcentaje = number_format((100 * $total / $post->goal),2);
            }
            
            if (auth('api')->user()) {
                //dd(Auth::user()->id);
                //El usuario sí tiene una sesión
                $post->user_like = PostsRelationsUser::where("user_id", auth('api')->user()->id)->where("post_id", $post->id)->count();
                $post->icon = ($post->user_like == 0) ? "heart-outline" : "heart"; 
                $post->user_id = auth('api')->user()->id;
            }else{
               // dd("No se puede");
                $post->user_like = 0;
                $post->icon      = "heart-outline";  
                $post->user_id   = 0;

            }
            

            $total_financiadores = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->where("transactions.post_id", $post->id)
                                ->select("user_id")
                                ->distinct()
                                ->get();

                

            $post->total_financiadores = count($total_financiadores);
            $mis_tags = "";
            $a = 1;
            foreach($post->tags as $tag){
                $mis_tags.= (count($post->tags) == $a) ? $tag->name: $tag->name.', ';
            $a++;
            }
            $post->tag = $mis_tags;
            
            if($post->time_remaining !== -1){
                array_push($datos, $post);
            }
        }
        
        return response()->json(["data" => $posts], 200);
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }


    public function verify_active()
    {
            $posts = Post::where("active", 1)
                    ->orderBy("id", "asc")
                    ->get();

            foreach($posts as $post){
                 
                $date     = new \DateTime($post->end_date);
                $now      = new \DateTime();
                $restante = $date->diff($now);
    
    
                $tiempo = "";
                if($restante->d > 0){
                    $tiempo = ($restante->d > 1) ? $restante->d.' dias' : $restante->d. " dia";
                }else{
                    if($restante->h > 0){
                        $tiempo = ($restante->h > 1) ? $restante->h.' horas' : $restante->h. " hora";
                    }elseif($restante->i > 0){
                        $tiempo = ($restante->i > 1) ? $restante->h.' minutos' : $restante->i. " minuto";
                    }else{
                        $inactive = Post::find($post->id);
                        $inactive->active = 0;
                        $inactive->save();
                    }
                }

            }
    }
    


}
