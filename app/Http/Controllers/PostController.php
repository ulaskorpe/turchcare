<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      //  dd($request);
        $fields = $request->validate([
            'body'=>['required','min:10'],
            'title'=>['required']
        ]);
        Post::create($fields);
    //   dd($request);
    return redirect('/')->with('success', " post created");
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
       return Inertia::render('Posts/Show',['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return Inertia::render('Posts/Update',['post'=>$post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $fields = $request->validate([
            'body'=>['required','min:10'],
            'title'=>['required']
        ]);
            $post->update($fields);

            return redirect('/')->with('success',$post->title." post updated");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/')->with('message',$post->title." post deleted");
   //     dd($post);
    }
}
