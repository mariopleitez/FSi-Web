<?php

namespace App\Http\Controllers\Admin;

use Image;
use Datatables;
use Carbon\Carbon;
use App\Models\Author;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Storage;

class AuthorsController extends AppController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Author::select('authors.*');

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
               ->addColumn('action', function ($data) {
                return    '<a data-toggle="modal" href="#modalDefaultAuthor" link="'.route('authors.edit', [$data->id]).'" class="btn btn-info showModalButtonAuthor" title="Editar el redactor"><i class="icon-note icons"></i></a> '.
                          '<a data-toggle="modal" href="#modalNarrower" name="'.$data->name.'" link="'.route('authors.destroy', [$data->id]).'" class="btn btn-danger showModalDeleteButton"><i class="icon-trash icons"></i></a>';
               })
               ->filterColumn('authors.active', function ($query, $keyword) {
                   if (strtolower($keyword) == "activo" ) {
                       $query->where("active", 1);
                   }elseif (strtolower($keyword) == "inactivo") {
                       $query->where("active", 0);
                   }else{
                       $query->whereRaw("active like ?", ["%$keyword%"]);
                   }
               })
               ->rawColumns(['action', 'active'])
               ->make(true);

       }

        return view('admin.authors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.authors.create');
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
            if($request->hasFile("imagen")){
                // INTERVENTION
                // Get the file from the request
                $requestImage = request()->file('imagen');
                $path      = $requestImage->getRealPath();
                $extension = $requestImage->getClientOriginalExtension();
                // $extension = "jpg";
                // Get the filepath of the request file (.tmp) and append .jpg
                $requestImagePath = $path . '.' . $extension;
                // Modify the image using intervention
                $interventionImage = Image::make($requestImage);
                $interventionImage->resize(190, 140, function ($constraint) {
                    $constraint->upsize();
                    $constraint->upsize();
                });
                //->fit(125, 125)->encode('png');
                // Save the intervention image over the request image
                $interventionImage->save($requestImagePath);
                // Send the image to file storage
                $autor = Author::create([
                    "name" => $request->name,
                ]);                
                $url = Storage::putFileAs('public/redactores/'.$autor->id, new File($requestImagePath), "th_".$autor->id.'.'.$extension);
                $autor->update([
                    'imagen'     => $request->file('imagen')->storeAs('public/redactores/'.$autor->id, $autor->id.'.'.$extension),
                    'thumbnail' => "public/redactores/".$autor->id."/th_".$autor->id.'.'.$extension
                ]);
            }else{
                $crear = Author::create([
                    "name"      => $request->name,
                    'imagen'    => 'public/redactores/default.png',
                    'thumbnail' => "public/redactores/th_default.png",
                ]);
            }
            return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact("author"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $this->validation($request, $author->id);
        if($request->hasFile("imagen")){
            // INTERVENTION
            // Get the file from the request
            $requestImage = request()->file('imagen');
            $path      = $requestImage->getRealPath();
            $extension = $requestImage->getClientOriginalExtension();
            // $extension = "jpg";
            // Get the filepath of the request file (.tmp) and append .jpg
            $requestImagePath = $path . '.' . $extension;
            // Modify the image using intervention
            $interventionImage = Image::make($requestImage);
            $interventionImage->resize(190, 140, function ($constraint) {
                $constraint->upsize();
                $constraint->upsize();
            });
            //->fit(125, 125)->encode('png');
            // Save the intervention image over the request image
            $interventionImage->save($requestImagePath);
            // Send the image to file storage
            $url = Storage::putFileAs('public/redactores/'.$author->id, new File($requestImagePath), "th_".$author->id.'.'.$extension);
            $author->update([
                "name"      => $request->name,
                'imagen'    => $request->file('imagen')->storeAs('public/redactores/'.$author->id, $author->id.'.'.$extension),
                'thumbnail' => "public/redactores/".$author->id."/th_".$author->id.'.'.$extension
            ]);
        }else{
            $author->update([
                "name" => $request->name
            ]);
        }
        
        return $this->crearRespuesta("El registro se ha editado exitosamente", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $response = $author->delete();
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
                'name'    => 'required|min:5|unique:authors,name,'.$id,
            ];
        }else{
            $reglas = [
                'name'    => 'required|min:5|unique:authors',
            ];
        }

        $messages = [
            'name.unique'      => 'El campo plan ya ha sido utilizado.',
            'name.required'    => 'El campo plan es obligatorio.',
        ];

        $rules = [$reglas, $messages];
        $this->validate($request, $reglas, $messages);
    }
}
