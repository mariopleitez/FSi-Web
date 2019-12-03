<?php

namespace App\Http\Controllers\Admin;

use DB;
use Datatables;
use Carbon\Carbon;
use App\Models\PostsType;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;

class PostsTypesController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = PostsType::select('posts_types.*');

            return Datatables::of($data)
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
               ->editColumn('color', function ($data) {
                    return '<span style="padding:10px; width:100%; color:white; background-color:'.$data->color.'">'.$data->color.'</span>';
                })
               ->addColumn('action', function ($data) {
                return    // '<a href="'.route('post-types.show', [$data->id]).'" class="btn btn-primary"><i class="icon-list icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalDefault" link="'.route('post-types.edit', [$data->id]).'" class="btn btn-info showModalButton" title="Editar el tipo de post"><i class="icon-note icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('post-types.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
               })
               ->filterColumn('posts_types.active', function ($query, $keyword) {
                   if (strtolower($keyword) == "activo" ) {
                       $query->where("active", 1);
                   }elseif (strtolower($keyword) == "inactivo") {
                       $query->where("active", 0);
                   }else{
                       $query->whereRaw("active like ?", ["%$keyword%"]);
                   }
               })
               ->rawColumns(['action', 'active', 'color'])
               ->make(true);

       }

        return view('admin.posts-types.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);
        if (PostsType::create($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypesProject  $typesProject
     * @return \Illuminate\Http\Response
     */
    public function show(PostsType $post_type)
    {
        return view('admin.posts-types.show', compact("post_type"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypesProject  $typesProject
     * @return \Illuminate\Http\Response
     */
    public function edit(PostsType $post_type)
    {
        //dd($post_type);
        return view('admin.posts-types.edit', compact("post_type"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypesProject  $typesProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostsType $post_type)
    {
        $this->validation($request, $post_type->id);
        if ($post_type->update($request->all())) {
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
        }else{
            return $this->crearRespuestaError("El registro no ha sido editado exitosamente",422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypesProject  $typesProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostsType $post_type)
    {
        $response = $post_type->delete();
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
                'name' => 'required|min:5|unique:posts_types,name,'.$id,
                'color' => 'required|min:5|unique:posts_types,color,'.$id,
            ];
        }else{
            $reglas = [
                'name' => 'required|min:5|unique:posts_types',
                'color' => 'required|min:5|unique:posts_types',
            ];
        }
        

        $messages = [
            'name.unique'    => 'El tipo de proyecto ya ha sido utilizado',
            'name.required'  => 'El campo tipo de proyecto es obligatorio.',
            'color.unique'   => 'El color ya ha sido utilizado',
            'color.required' => 'El campo color es obligatorio.',
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
