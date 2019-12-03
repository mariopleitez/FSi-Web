<?php

namespace App\Http\Controllers\Admin;

use DB;
use Image;
use Datatables;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\City;
use App\Models\Plan;
use App\Models\Post;
use App\Models\State;
use App\Models\Author;
use App\Models\Country;
use App\Models\PostsType;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\Image as Imagen;
use App\Models\PaymentsProvider;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Storage;

class PostsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Post::with('post_type')->select('posts.*');

            return Datatables::of($data)

                ->editColumn('name', function ($data) {
                    return str_limit($data->name, 30, '...');
                })

                ->editColumn('post_type.name', function ($data) {
                    return '<span class="label" style="background-color:'.$data->post_type->color.'">'.$data->post_type->name.'</span>';
                })
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
                return    '<a href="'.route('posts.show', [$data->id]).'" class="btn btn-primary"><i class="icon-list icons"></i></a> '.
                          '<a href="'.route('posts.edit', [$data->id]).'" class="btn btn-info" title="Editar post"><i class="icon-note icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('posts.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
               })
               ->filterColumn('posts.active', function ($query, $keyword) {
                   if (strtolower($keyword) == "activo" ) {
                       $query->where("active", 1);
                   }elseif (strtolower($keyword) == "inactivo") {
                       $query->where("active", 0);
                   }else{
                       $query->whereRaw("active like ?", ["%$keyword%"]);
                   }
               })
               ->rawColumns(['action', 'active', 'post_type.name'])
               ->make(true);

       }
       return view("admin.posts.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts_types = PostsType::where("active", 1)->pluck("id", "name");
        $redactores  = Author::where("active", 1)->pluck("id", "name");
        $paises      = Country::where("active", 1)->pluck("id", "name");
        $tags        = Tag::pluck("id", "name");
        $planes      = Plan::where("active", 1)->pluck("name", "id");
        $pasarelas   = PaymentsProvider::where("active", 1)->pluck("name", "id");
        return view("admin.posts.create", compact("posts_types", "redactores", "tags", "paises", "planes", "pasarelas"));
    }

    public function getdepartamentos($id = null)
    {
        $estados = State::where("active", 1)->where("country_id", $id)->pluck("name", "id");
        return view("admin.posts.getdepartamentos", compact("estados"));
    }

    public function getciudades($id = null)
    {
        $ciudades = City::where("active", 1)->where("state_id", $id)->pluck("name", "id");
        return view("admin.posts.getciudades", compact("ciudades"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       // dd($request->all());

        $this->validation($request);
        $post = Post::create($request->all());
        if ($post) {
            // Crear los redactores
            $post->authors()->attach($request->redactor_id);
            // Adjuntar los tags
            $tags = [];
            foreach($request->tags as $key => $value){
                $tag    = Tag::firstOrCreate(array('name' => $value));
                $tags[] = $tag->id;
            }
            $post->tags()->attach($tag->id);
            // Adjuntar los planes de pagos
            for ($i=0; $i < count($request->pasarela) ; $i++) { 
                if(!empty($request->pasarela[$i]) && !empty($request->planes[$i]) && !empty($request->codigo[$i])){
                    $post->plans()->attach($request->planes[$i], ['codigo' => $request->codigo[$i], 'payments_provider_id' => $request->pasarela[$i] ]);
                }
            }

            // $post = $data->save();
            if($request->hasFile("imagen1")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen1');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_1.'.$extension);
                $crear = Imagen::create([
                    "name"      => $request->name,
                    'image'     => $request->file('imagen1')->storeAs('public/posts/'.$post->id, $post->id.'_1.'.$extension),
                    'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_1.'.$extension,
                    'post_id'   => $post->id
                ]);
            }
            if($request->hasFile("imagen2")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen2');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_2.'.$extension);
                $crear = Imagen::create([
                    "name"      => $request->name,
                    'image'     => $request->file('imagen2')->storeAs('public/posts/'.$post->id, $post->id.'_2.'.$extension),
                    'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_2.'.$extension,
                    'post_id'   => $post->id
                ]);
            }
            if($request->hasFile("imagen3")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen3');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_3.'.$extension);
                $crear = Imagen::create([
                    "name"      => $request->name,
                    'image'     => $request->file('imagen3')->storeAs('public/posts/'.$post->id, $post->id.'_3.'.$extension),
                    'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_3.'.$extension,
                    'post_id'   => $post->id
                ]);
            }
            if($request->hasFile("imagen4")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen4');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_4.'.$extension);
                $crear = Imagen::create([
                    "name"      => $request->name,
                    'image'     => $request->file('imagen4')->storeAs('public/posts/'.$post->id, $post->id.'_4.'.$extension),
                    'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_4.'.$extension,
                    'post_id'   => $post->id
                ]);
            }

            if($request->hasFile("video")){
                $requestVideo = request()->file('video');
                $path         = $requestVideo->getRealPath();
                $extension    = $requestVideo->getClientOriginalExtension();
                //$post->video = $request->video->storeAs('public/videos/', $request->video->getClientOriginalName());
                $post->video = $request->video->store('public/videos');
                //$post->video = $request->video->store('videos/');
                $post->update();
            }

            $response = $this->sendMessage('Nuevo Proyecto', str_limit($post->name, 15, '...'));
            // $return["allresponses"] = $response;
            // $return = json_encode($return);

            // $data = json_decode($response, true);
            // print_r($data);
            // $id = $data['id'];
            // print_r($id);

            // print("\n\nJSON received:\n");
            // print($return);
            // print("\n");


            return redirect()->route('posts.index')->withSuccess("El post fue creado exitosamente");
            //return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return redirect()->route('posts.index')->withErro("Hubo un problema para crear el post. Consulte al departamento de IT.");
            //return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $post->load("post_type", "transactions_total", "transactions", "users.profile");
       // dd($post);
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post->load("post_type", "images", "authors", "plans", "tags", "ciudad.departamento.pais");
        $redactores  = Author::where("active", 1)->pluck("id", "name");
        $tags        = Tag::pluck("id", "name");
        $planes      = Plan::where("active", 1)->pluck("name", "id");
        $pasarelas   = PaymentsProvider::where("active", 1)->pluck("name", "id");
        $paises      = Country::where("active", 1)->pluck("id", "name");
        $mis_autores = [];
        foreach($post->authors as $autores){
            $mis_autores[] = $autores->id;
        }

        $mis_tags = [];
        foreach($post->tags as $tag){
            $mis_tags[] = $tag->id;
        }

        $departamentos = [];
        if(isset($post->ciudad->departamento->pais->id)){
            $departamentos = State::where("active", 1)->where("country_id", $post->ciudad->departamento->pais->id)->pluck("id", "name");
        }

        $ciudades = [];
        if(isset($post->ciudad->id)){
            $ciudades = City::where("active", 1)->where("state_id", $post->ciudad->departamento->id)->pluck("id", "name");
        }

        //dd($post);
        $tipos = PostsType::where("active", 1)->pluck("name", "id");
        return view("admin.posts.edit", compact("post", "tipos", "mis_autores", "redactores", "pasarelas", "planes", "tags", "mis_tags", "paises", "departamentos", "ciudades"));
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
       // dd($request->all());
        $this->validation($request, $post->id);
        if ($post->update($request->all())) {
            $imagenes = Imagen::where("post_id", $post->id)->where("active", 1)->get();
            $post->save();
            if($request->hasFile("imagen1")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen1');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_1.'.$extension);
                if(count($imagenes) > 0){
                   $img = Imagen::find($imagenes[0]->id);                       
                   $update = $img->update([
                       "name"      => $request->name,
                       'image'     => $request->file('imagen1')->storeAs('public/posts/'.$post->id, $post->id.'_1.'.$extension),
                       'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_1.'.$extension,
                   ]);
                }else{
                    $update = Imagen::create([
                        "name"      => $request->name,
                        'image'     => $request->file('imagen1')->storeAs('public/posts/'.$post->id, $post->id.'_1.'.$extension),
                        'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_1.'.$extension,
                        'post_id'   => $post->id
                    ]);
                }
            }
            if($request->hasFile("imagen2")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen2');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_2.'.$extension);
                if(count($imagenes) > 1){
                   $img = Imagen::find($imagenes[1]->id);                       
                   $update = $img->update([
                       "name"      => $request->name,
                       'image'     => $request->file('imagen2')->storeAs('public/posts/'.$post->id, $post->id.'_2.'.$extension),
                       'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_2.'.$extension,
                   ]);
                }else{
                    $update = Imagen::create([
                        "name"      => $request->name,
                        'image'     => $request->file('imagen2')->storeAs('public/posts/'.$post->id, $post->id.'_2.'.$extension),
                        'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_2.'.$extension,
                        'post_id'   => $post->id
                    ]);
                }
            }
            if($request->hasFile("imagen3")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen3');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_3.'.$extension);
                if(count($imagenes) > 2){
                   $img = Imagen::find($imagenes[2]->id);                       
                   $update = $img->update([
                       "name"      => $request->name,
                       'image'     => $request->file('imagen3')->storeAs('public/posts/'.$post->id, $post->id.'_3.'.$extension),
                       'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_3.'.$extension,
                   ]);
                }else{
                    $update = Imagen::create([
                        "name"      => $request->name,
                        'image'     => $request->file('imagen3')->storeAs('public/posts/'.$post->id, $post->id.'_3.'.$extension),
                        'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_3.'.$extension,
                        'post_id'   => $post->id
                    ]);
                }
            }
            if($request->hasFile("imagen4")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen4');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(365, 206, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $url = Storage::putFileAs('public/posts/'.$post->id, new File($requestImagePath), "th_".$post->id.'_4.'.$extension);
                if(count($imagenes) > 3){
                   $img = Imagen::find($imagenes[3]->id);                       
                   $update = $img->update([
                       "name"      => $request->name,
                       'image'     => $request->file('imagen4')->storeAs('public/posts/'.$post->id, $post->id.'_4.'.$extension),
                       'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_4.'.$extension,
                   ]);
                }else{
                    $update = Imagen::create([
                        "name"      => $request->name,
                        'image'     => $request->file('imagen4')->storeAs('public/posts/'.$post->id, $post->id.'_4.'.$extension),
                        'thumbnail' => "public/posts/".$post->id."/th_".$post->id.'_4.'.$extension,
                        'post_id'   => $post->id
                    ]);
                }
            }
            // if ($request->hasFile("image")) {
            //     $post->image = $request->image->store('public/posts');
            // }
            
            
            return redirect()->route('posts.index')->withSuccess("El post fue editado exitosamente");
        }else{
            return redirect()->route('posts.index')->withErro("Hubo un problema para crear el post. Consulte al departamento de IT.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $response = $post->delete();
        if($response){
            return $this->crearRespuesta("El registro se ha eliminado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido eliminado exitosamente",422);
        }
    }


    public function validation($request, $id = null)
    {
        if ($id) {
            $reglas = [
                'name'          => 'required|unique:posts,name,'.$id,
                'posts_type_id' => 'required|numeric',
                'comment'       => 'required'
            ];
        }else{
            $reglas = [
                'name'          => 'required|unique:posts',
                'posts_type_id' => 'required|numeric',
                'comment'       => 'required'
            ];
        }
        

        $messages = [
            'name.unique'            => 'El titulo ya ha sido utilizada',
            'name.required'          => 'El campo titulo es obligatorio.',
            'comment.required'       => 'El campo comentario es obligatorio.',
            'posts_type_id.required' => 'El campo tipo de post es obligatorio.'
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }


    public function sendMessage($titulo, $cuerpo){
            $content  = array(
                "en" => $cuerpo
            );
            $headings = array(
                "en" => $titulo
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
}
