<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\APIError;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Comment::simplePaginate($request->has('limit') ? $request->limit : 15);
        return response()->json($data);    
        }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validate($request->all(), 
        [
            'name'=>'required',
            'blog_id'=>'required',
            'email'=>'required|email'
        ]);

        $data = [];
        $data = array_merge($data, $request->only(
        [
            'name',
            'email',
            'website',
            'content',
            'blog_id'
        ]));
        
        $comment = Comment::create($data);

        return response()->json($comment);
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
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */

    public function find($id)
    {
        $comment= Comment::find($id);
        if (!$comment) {

            $error = new APIError;
            $error-> setStatuts("404");
            $code-> setCode("blogcatogory not found");
            $error-> setMessage("l'id n'existe pas");
            return  response()->json($error);
        }
        return response()->json($comment);
        
    }
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$b) {

            $error = new APIError;
            $error-> setStatuts("404");
            $code-> setCode("blogcatogory not found");
            $error-> setMessage("l'id n'existe pas");
            return  response()->json($error);
        }
   
   $data = [];
    $data = array_merge($data, $request->only([
        'name',
        'email',
        'website',
        'content',
        'blog_id'
    ]));
    
    $comment->name = $data['name'];
    $comment->email = $data['email'];
    $comment->website = $data['website'];
    $comment->content = $data['content'];
    $comment->blog_id = $data['blog_id'];
    $comment->update();

    return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::find($id);
        if (!$comment) {

            $error = new APIError;
            $error-> setStatuts("404");
            $code-> setCode("blogcatogory not found");
            $error-> setMessage("l'id n'existe pas");
            return  response()->json($error);
        }
        $comment->delete();
        return response()->json();
    }
}
