<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\APIError;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Blog::simplePaginate($request->has('limit') ? $request->limit : 15);
         foreach($data as $image){
             $image-> image = url($image-> image);
         }
            return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request->all(), 
        [
            'name'=>'required', // champ obligatoire  
            'blog_categorie_id' => 'required'    
            ]);

        $data = [];
        $data = array_merge($data, $request->only(
        [
            'name',
            'description',
            'image',
            'blog_categorie_id'
        ]));

           $path1 = " ";
           //upload image de l'article
            if(isset($request->image)){
                $image = $request->file('image');
                if($image != null){
                    $extension = $image->getClientOriginalExtension();
                    $relativeDestination = "upload/image";
                    $destinationPath = public_path($relativeDestination);
                    $safeName = "image" .time(). '.' .$extension;
                    $image->move($destinationPath, $safeName);
                    $path1 = "$relativeDestination/$safeName";
                }
            }

            $data['image'] = ($path1);
        
        $blog = Blog::create($data);

        return response()->json($blog);
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
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $b = Blog::find($id);
        if (!$b) {

            $error = new APIError;
            $error-> setStatuts("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id n'existe pas");
            return  response()->json($error , 404);
        }
   
   $data = [];
    $data = array_merge($data, $request->only([
        'name',
        'description',
        'image',
        'blog_categorie_id'
    ]));
    
    $path1 = " ";
           //upload image de l'article
            if(isset($request->image)){
                $image = $request->file('image');
                if($image != null){
                    $extension = $image->getClientOriginalExtension();
                    $relativeDestination = "upload/image";
                    $destinationPath = public_path($relativeDestination);
                    $safeName = "image" .time(). '.' .$extension;
                    $image->move($destinationPath, $safeName);
                    $path1 = "$relativeDestination/$safeName";
                }
            }

            $data['image'] = ($path1);

    $b->name = $data['name'];
    $b->description = $data['description'];
    $b->image = $data['image'];
    $b->blog_categorie_id = $data['blog_categorie_id'];
    $b->update();

    return response()->json($b);
    }
   
    public function find($id)
    {
        $blog= Blog::find($id);
        if (!$blog) {

            $error = new APIError;
            $error -> setStatus("404");
            $error -> setCode("blogcatogory not found");
            $error -> setMessage("l'id n'existe pas");
            return  response()->json($error ,404);
        }
        return response()->json($blog);
        
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $id)
    {
        $blog = Blog::find($id);
        if (!$blog) {

            $error = new APIError;
            $error-> setStatuts("404");
            $error-> setCode("blog not found");
            $error-> setMessage("l'id n'existe pas");
            return  response()->json($error , 404);
        }
        $blog->delete();
        return response()->json();
    }
}
