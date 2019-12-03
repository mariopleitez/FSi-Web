<?php

namespace App\Http\Controllers\Admin;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class UsersController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        

       // $response = $this->testcurl();


        // $return["allresponses"] = $response;
        // $return = json_encode($return);
        
        // $data = json_decode($response, true);
        // print_r($data);
        // $id = $data['id'];
        // print_r($id);
        
        // print("\n\nJSON received:\n");
        // print($return);
        // print("\n");

        // try{
        //     $user = User::find(1);
        //     $user->notify(new InvoicePaid($user));
        //     echo "<pre>";
        //     print_r($user->notify(new InvoicePaid($user)));
        //     echo "</pre>";

          


        // }catch(Exception $e){
        //     echo "<pre>";
        //     print_r($e);
        //     echo "</pre>";
        //     die();
        // }

        
        
        if ($request->ajax()) {
            //$data = DB::table('users')->select(['id', 'name', 'email', 'active','created_at', 'updated_at']);
            $data = User::with('role')->select('users.*');

             return Datatables::of($data)
               
            //  ->editColumn('role.name', function ($data) {
            //     return $data->role->name;
            //  })

               ->editColumn('role.name', function (User $user) {
                   return $user->role->map(function($role) {
                       return $role->name;
                   })->implode('<br>');
               })

            //    ->editColumn('role.name', function ($data) {
            //         return 'Algo';
            //     })
               
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
                    return '<a href="'.route('users.show', [$data->id]).'" class="btn btn-primary"><i class="icon-list icons"></i></a> '.
                           '<a data-toggle="modal" href="#modalDefault" link="'.route('users.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar usuario"><i class="icon-note icons"></i></a> '.
                           '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('users.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';

               })

               ->filterColumn('users.active', function ($query, $keyword) {
                   if (strtolower($keyword) == "activo" ) {
                       $query->where("active", 1);
                   }elseif (strtolower($keyword) == "inactivo") {
                       $query->where("active", 0);
                   }else{
                       $query->whereRaw("active like ?", ["%$keyword%"]);
                   }
               })

               ->rawColumns(['action', 'active', 'role.name'])
               ->make(true);

        }else{

            // $response = $this->sendMessage();
            // $return["allresponses"] = $response;
            // $return = json_encode($return);

            // $data = json_decode($response, true);
            // print_r($data);
            // $id = $data['id'];
            // print_r($id);

            // print("\n\nJSON received:\n");
            // print($return);
            // print("\n");
        }

        return view("admin.users.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where("active", 1)->pluck("name", "id");
        return view("admin.users.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required',
            'role'  => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request,$rules);
        $campos = $request->all();
        $campos["password"]           = bcrypt($request->password);
        $campos["verified"]           = User::USUARIO_VERIFICADO;
        $campos["verification_token"] = User::generarVerificationToken(); 
        $usuario = User::create($campos);
        $usuario->role()->attach($request->role);
        return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load("subscripcion", "profile", "transactions", "role");
        return view("admin.users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load("role");
        $roles = Role::where("active", 1)->pluck("name", "id");
        $my_roles = [];
        foreach($user->role as $rol){
            $my_roles[] = $rol->id;
        }
        return view("admin.users.edit", compact("user", "roles", "my_roles"));
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
        $rules = [
            'name'     => 'required',
            'role'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request,$rules);
        $campos = $request->all();
        
        $campos["password"] = bcrypt($request->password);

        $usuario = User::create($campos);
        $usuario->role()->sync($request->role);

        return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $response = $user->delete();
        if($response){
            return $this->crearRespuesta("El registro se ha eliminado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
        }
    }


    public function sendMessage(){
            $content  = array(
                "en" => 'Esta es mi contenido'
            );
            $headings = array(
                "en" => 'Este es mi titulo'
            );
            $hashes_array = array();
            array_push($hashes_array, array(
                "id" => "like-button",
                "text" => "Like",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com"
            ));
            array_push($hashes_array, array(
                "id" => "like-button-2",
                "text" => "Like2",
                "icon" => "http://i.imgur.com/N8SN8ZS.png",
                "url" => "https://yoursite.com"
            ));
            $fields = array(
                'app_id' => "5fe1994b-0ebe-41b5-a96d-5ce7ce875b3e",
                'included_segments' => array(
                    'Subscribed Users'
                ),
                // 'included_segments' => array(
                //     'All'
                // ),
                'data' => array(
                    "foo" => "bar"
                ),
                'contents' => $content,
                'headings' => $headings,
                'web_buttons' => $hashes_array,
                'priority' => 12
            );
            
            $fields = json_encode($fields);

            // print("\nJSON sent:\n");
            // print($fields);
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic N2U4OGVlOTctMThhNi00MTExLWI5ZDktMjJlZmQxNmRiNjdj'
            ));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            
            $response = curl_exec($ch);
            //curl_exec($ch);
            curl_close($ch);
            return $response;
    }

    public function testcurl()
    {
        // Make Post Fields Array
        $data1 = [
            'data1' => 'value_1',
            'data2' => 'value_2',
        ];

        $content  = array(
            "en" => 'TEST CURL'
        );
        $hashes_array = array();
        array_push($hashes_array, array(
            "id" => "like-button",
            "text" => "Like",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://yoursite.com"
        ));
        array_push($hashes_array, array(
            "id" => "like-button-2",
            "text" => "Like2",
            "icon" => "http://i.imgur.com/N8SN8ZS.png",
            "url" => "https://yoursite.com"
        ));
        $fields = array(
            'app_id' => "5fe1994b-0ebe-41b5-a96d-5ce7ce875b3e",
            'included_segments' => array(
                'Subscribed Users', 'All'
            ),
            // 'included_segments' => array(
            //     'All'
            // ),
            'data' => array(
                "foo" => "bar"
            ),
            'contents' => $content,
            'web_buttons' => $hashes_array
        );
        
        $fields = json_encode($fields);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
                // Set here requred headers
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Basic N2U4OGVlOTctMThhNi00MTExLWI5ZDktMjJlZmQxNmRiNjdj'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
           // print_r(json_decode($response));
           return $response;
        }
    }
}
