<?php

namespace Task\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Task\Post;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->admin) {
            return redirect('/dashboard')->with('error', 'Unauthorized Page');
        }
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:1999|nullable'
        ]);

        $post = new Post();
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        if ($request->hasFile('thumbnail')) {
            $filenameWithExtension = $request->file('thumbnail')->getClientOriginalName();
            $filenameWithoutExtension = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filenameToStore = $filenameWithoutExtension.'_'.time().'.'.$extension;
            $path = $request->file('thumbnail')->storeAs('public/thumbnails', $filenameToStore);
        }
        else {
            $filenameToStore = 'no_image.jpg';
        }
        $post->thumbnail = $filenameToStore;
        $post->save();
        return redirect('/dashboard')->with('success', 'The news has been inserted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if (count($post))
            return view('posts.show')->with('post', $post);
        else
            return redirect('/')->with('error', 'Invalid Page');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        if (count($post)) {
            if ($post->user_id != auth()->user()->id)
                return redirect('/dashboard')->with('error', 'Unauthorized Page');
            return view('posts.edit')->with('post', $post);
        }
        else
            return redirect('/dashboard')->with('error', 'Invalid Page');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'thumbnail' => 'image|mimes:png,jpg,jpeg|max:1999|nullable'
        ]);

        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if ($request->hasFile('thumbnail')) {
            $filenameWithExtension = $request->file('thumbnail')->getClientOriginalName();
            $filenameWithoutExtension = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            $filenameToStore = $filenameWithoutExtension.'_'.time().'.'.$extension;
            $path = $request->file('thumbnail')->storeAs('public/thumbnails', $filenameToStore);
            if ($post->thumbnail == 'no_image.jpg') {
                $post->thumbnail = $filenameToStore;
            }
            else {
                Storage::delete('public/thumbnails/'.$post->thumbnail);
                $post->thumbnail = $filenameToStore;
            }
        }
        $post->save();
        return redirect('/dashboard')->with('success', 'News updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if ($post->thumbnail != 'no_image.jpg')
            Storage::delete('public/thumbnails/'.$post->thumbnail);
        $post->delete();
        return redirect('/dashboard')->with('success', 'New has been deleted successfully');
    }
}
