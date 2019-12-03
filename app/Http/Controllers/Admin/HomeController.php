<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\User;
use App\Models\PostsType;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AppController;

class HomeController extends AppController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::where("active", 1)
                      ->with("post_type", 'transactions', 'transactions_total')
                      ->orderBy("id", "desc")
                      ->limit(5)
                      ->get();

        $total_mes_actual = DB::table("transactions")
                            ->whereNull("transactions.deleted_at")
                            ->whereRaw('YEAR(transactions.created_at) = '.date("Y"))
                            ->whereRaw('MONTH(transactions.created_at) = '.date("n"))
                            ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total')
                            ->first();

        $total_mes_anterior = DB::table("transactions")
                            ->whereNull("transactions.deleted_at")
                            ->whereRaw('YEAR(transactions.created_at) = '.date("Y"))
                            ->whereRaw('MONTH(transactions.created_at) = '.(date("n")-1))
                            ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total')
                            ->first();

        $mas_financiados = DB::table("posts")
                            ->leftJoin('transactions', 'transactions.post_id', '=', 'posts.id')
                            ->leftJoin('posts_types', 'posts_types.id', '=', 'posts.posts_type_id')
                            ->whereNull("transactions.deleted_at")
                            ->whereNull("posts.deleted_at")
                            ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total_less_commissions, IFNULL(SUM(transactions.amount),0)  as total, posts.name, posts_types.name as tipo, posts_types.color, posts.created_at, posts.id')
                            ->groupBy('posts.name', 'color', 'tipo', 'posts.created_at', 'posts.id')
                            ->orderBy('TOTAL', 'desc')
                            ->limit(5)
                            ->get();

        $total_anio_actual = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->whereRaw('YEAR(transactions.created_at) = '.date("Y"))
                                ->selectRaw('IFNULL(SUM(transactions.amount),0)  as total, IFNULL(SUM(transactions.amount_less_commissions),0) as total_without_comission')
                                ->first();
                                
        $total_anio_anterior = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->whereRaw('YEAR(transactions.created_at) = '.(date("n")-1))
                                ->selectRaw('IFNULL(SUM(transactions.amount),0)  as total, IFNULL(SUM(transactions.amount_less_commissions),0) as total_without_comission')
                                ->first();

        $total_anio_dosanterior = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->whereRaw('YEAR(transactions.created_at) = '.(date("n")-2))
                                ->selectRaw('IFNULL(SUM(transactions.amount),0)  as total, IFNULL(SUM(transactions.amount_less_commissions),0) as total_without_comission')
                                ->first();

        $usuario_mas_activo = DB::table("users")
                                    ->leftJoin('transactions', 'transactions.user_id', '=', 'users.id')
                                    ->whereNull("transactions.deleted_at")
                                    ->whereNull("users.deleted_at")
                                    ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total_less_commissions, IFNULL(SUM(transactions.amount),0)  as total, users.name, users.id, users.email ')
                                    ->groupBy('users.name', 'users.id', 'users.email')
                                    ->orderBy('TOTAL', 'desc')
                                    ->first();

       // dd($usuario_mas_activo);
        $total                = Transaction::sum('amount');
        $total_menos_comision = Transaction::sum('amount_less_commissions');
        $total_users          = User::count();
        $total_posts          = Post::count();
        list($grafico_mensual, $total_anio_total, $total_anio_amount_less_commissions)  = $this->__getmonthchart();
        $grafico_post_type    = $this->__getPostTypeChart();

        return view('admin.home.index', compact("posts", "total", "total_menos_comision", "total_users", "grafico_mensual", "grafico_post_type", "total_posts", "total_mes_actual", "total_mes_anterior", "mas_financiados", "total_anio_actual", "total_anio_anterior", "total_anio_dosanterior", "total_anio_total", "total_anio_amount_less_commissions", "usuario_mas_activo"));
    }



    public function __getmonthchart()
    {
        $anio    = date("Y");
        $mes     = date("n");
        $meses   = [1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre"];
        $colores = [1 => "#FF0F00", 2 => "#FF6600", 3 => "#FF9E01", 4 => "#FCD202", 5 => "#F8FF01", 6 => "#B0DE09", 7 => "#04D215", 8 => "#0D8ECF", 9 => "#0D52D1", 10 => "#2A0CD0", 11 => "#8A0CCF", 12 => "#CD0D74"];
        $data    = [];
        if($mes == 12){
            $a = 0;
            for ($i=12; $i >= 1 ; $i--) { 
                $total_mes_actual = DB::table("transactions")
                                        ->whereNull("transactions.deleted_at")
                                        ->whereRaw('YEAR(transactions.created_at) = '.$anio)
                                        ->whereRaw('MONTH(transactions.created_at) = '.$i)
                                        ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total')
                                        ->first();
                $data[$a]["mes"]   = $meses[$i].' '.$anio;
                $data[$a]["color"] = $colores[$i];
                $data[$a]["total"] = isset($total_mes_actual->total) ? number_format($total_mes_actual->total,2,'.',','): 0.00;
            $a++;
            }

            $total_anio = DB::table("transactions")
                            ->whereNull("transactions.deleted_at")
                            ->whereRaw('YEAR(transactions.created_at) = '.date("Y"))
                            ->selectRaw('IFNULL(SUM(transactions.amount),0)  as total, IFNULL(SUM(transactions.amount_less_commissions),0) as total_without_comission')
                            ->first();
        }else{
            $pasadas = 0;
            for ($i=$mes; $i >= 1 ; $i--) { 
                $total_mes_actual = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->whereRaw('YEAR(transactions.created_at) = '.$anio)
                                ->whereRaw('MONTH(transactions.created_at) = '.$i)
                                ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total')
                                ->first();
                $data[$pasadas]["mes"]   = $meses[$i].' '.$anio;
                $data[$pasadas]["color"] = $colores[$i];
                $data[$pasadas]["total"] = isset($total_mes_actual->total) ? number_format($total_mes_actual->total,2,'.',','): 0.00;
            $pasadas++;
            }

            $post_pasadas = $pasadas;
            for ($i=12; $i >= (13 - (12-$post_pasadas)) ; $i--) { 
                $total_mes_actual = DB::table("transactions")
                                ->whereNull("transactions.deleted_at")
                                ->whereRaw('YEAR(transactions.created_at) = '.($anio-1))
                                ->whereRaw('MONTH(transactions.created_at) = '.$i)
                                ->selectRaw('IFNULL(SUM(transactions.amount_less_commissions),0)  as total')
                                ->first();
                $data[$pasadas]["mes"]   = $meses[$i].' '. ($anio-1);
                $data[$pasadas]["color"] = $colores[$i];
                $data[$pasadas]["total"] = isset($total_mes_actual->total) ? number_format($total_mes_actual->total,2,'.',','): 0.00;
            $pasadas++;
            }

            $start = date(($anio-1).'-'.$i.'-01 00:00:00');
            $end   = date($anio.'-'.date("n").'-31 23:59:59');

            $total_anio = DB::table("transactions")
                            ->whereNull("transactions.deleted_at")
                            ->whereBetween('created_at', [date($start), date($end)])
                            ->selectRaw('IFNULL(SUM(transactions.amount),0)  as total, IFNULL(SUM(transactions.amount_less_commissions),0) as total_without_comission')
                            ->first();

        }

        return array($data,$total_anio->total, $total_anio->total_without_comission);
    }


    public function __getPostTypeChart()
    {
        $tipos = PostsType::where("active", 1)->get();
        $colores = [1 => "#1e88e5", 2 => "#ffb22b", 3 => "#fc4b6c", 4 => "#84B761", 5 => "#F8FF01", 6 => "#CD0D74", 7 => "#04D215", 8 => "#0D8ECF", 9 => "#8A0CCF", 10 => "#2A0CD0", 11 => "#0D52D1", 12 => "#B0DE09"];
        $data  = [];
        $a=0;
        foreach ($tipos as $tipo) {
            $data[$a]["tipo"]  = $tipo->name;
            $data[$a]["total"] = Post::where("posts_type_id", $tipo->id)->count();
            $data[$a]["color"] = $colores[$a+1];
        $a++;
        }

        return $data;
    }


}
