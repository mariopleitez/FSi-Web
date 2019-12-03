<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Models\Post;
use App\Models\User;
use App\Models\Mention;
use App\Models\PlansPost;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class UsersController extends ApiController
{
    
    public function __construnct()
    {
        //$this->middleware('client.credentials')->only(['store', 'resend']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $reglas = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request, $reglas);
        $campos = $request->all();
        $campos['password'] = bcrypt($request->password);
        $campos['active'] = User::USUARIO_VERIFICADO;
        $campos['verification_token'] = User::generarVerificationToken();
      //$campos['admin'] = User::USUARIO_REGULAR;
        $usuario = User::create($campos);
        $usuario->role()->attach(1);
        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }


    public function resend()
    {
        # code...
    }


    public function likes(Request $request){
        $user = User::find($request->user()->id);
        $like = $request->like;
        $post = $request->post;
        if($like == 1){
            $user->like()->attach(1, ['post_id' => $post ,'active' => 1]);
        }else{
            $user->like()->wherePivot('post_id', $post)->detach(1);
        }
        return $this->showOne($user);
    }

    
    public function getproyectos(Request $request){
        $user = User::find($request->user()->id);

        // Patrocinado por el usuario:

        $financiado = DB::table("transactions")
                            ->whereNull("transactions.deleted_at")
                            ->where("transactions.user_id", $user->id)
                            ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total_less_commissions, IFNULL(SUM(transactions.amount),0)  as total')
                            ->first();

        $total_financiado = floatval($financiado->total);

        $menciones = Mention::all();
        $titulo = "";
        $estrellas = 0;
        foreach($menciones as $mencion){
            if($total_financiado >= $mencion->start && $total_financiado <= $mencion->end ){
                $titulo = $mencion->name;
                $estrellas = $mencion->stars;
                break;
            }
        }


        //$user = User::find(2);
        $user->load("subscripcion");
        $proyectos = [];
        $in_array  = [];
        foreach ($user->subscripcion as $subscripcion) {
            $plan_post = PlansPost::where("codigo", $subscripcion->stripe_id)->first();
            if(isset($plan_post->post_id)){
                $post = Post::with("post_type", "images", "authors", "ciudad.departamento.pais", "tags")
                                ->find($plan_post->post_id);

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

                if(!in_array($post->id,$in_array)){
                    array_push($proyectos,$post);
                    array_push($in_array,$post->id);
                }
            }
        }

        //$proyectos = User::all();
        // dd($proyectos);
        return response()->json(["data" => $proyectos, "titulo" => $titulo, "estrellas" => $estrellas, "total_financiado" => $total_financiado], 200);
    }

}
