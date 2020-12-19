<?php

namespace Task\Http\Controllers;

use Illuminate\Http\Request;

use Task\Http\Requests\StorePostRequest;
use Task\Transformers\PostTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Task\Http\Requests\UpdatePostRequest;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

use Task\Post;

class APIPostsController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        $postsCollection = $posts->getCollection();


        return fractal()
            ->collection($postsCollection)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($posts))
            ->toArray();
    }

    public function show(Post $post) {
        return fractal()
        ->item($post)
        ->parseIncludes(['user'])
        ->transformWith(new PostTransformer)
        ->toArray();
    }

    public function store(StorePostRequest $request) {
        $this->authorize('create', Post::class);
        
        $post = new Post;
        $post->title = $request->title;
        $post->user()->associate($request->user());
        $post->body = $request->body;
        if ($request->input('image')) {
            $img = Image::make($request->input('image'));
            $data = $request->input('image');
            $type = explode(';', $data)[0];
            $extension = explode('/', $type)[1];
            $filenameToStore = 'image_'.time().'.'.$extension;
            $img->save(public_path('storage/thumbnails/'.$filenameToStore));
        } else {
            $filenameToStore = 'no_image.jpg';
        }
        $post->thumbnail = $filenameToStore;
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function update(UpdatePostRequest $request, Post $post) {

        $this->authorize('update', $post);

        $post->title = $request->get('title', $post->title);
        $post->body = $request->get('body', $post->body);
        if ($request->input('image')) {
            $img = Image::make($request->input('image'));
            $data = $request->input('image');
            $type = explode(';', $data)[0];
            $extension = explode('/', $type)[1];
            $filenameToStore = 'image_'.time().'.'.$extension;
            $img->save(public_path('storage/thumbnails/'.$filenameToStore));
            if ($post->thumbnail != 'no_image.jpg')
                Storage::delete('public/thumbnails/'.$post->thumbnail);
            $post->thumbnail = $filenameToStore;
        }
        $post->save();

        return fractal()
            ->item($post)
            ->parseIncludes(['user'])
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    public function destroy(Post $post) {
        $this->authorize('delete', $post);

        if ($post->thumbnail != 'no_image.jpg')
            Storage::delete('public/thumbnails/'.$post->thumbnail);
        $post->delete();

        return response(null, 204); // Successful && No Content
    }
}
