<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{

    // to not let guest see edit, create pages
    public function __construct()
    {
        // non loged in users will not be able to see posts pages except index and show
        $this->middleware('auth', [ 'except' => ['index', 'show']]);
        // $this->middleware('auth')->except(['index', 'show']); newer version
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        // return Post::where('title', 'something')->get()  this way we can get a single post well detirmened 
        // to get a limited numbe we can do this; Post::ordreBy('title', 'desc')->take(1)->get();
        // $posts = Post::orderBy('title', 'asc')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //validate and store the blog post
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999'
        ]);

        // Handle file upload 
        if($request->hasfile('cover_image')) {
            //get file name with extention
            // $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            // $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileName = $request->file('cover_image')->getClientOriginalName();
            //get just extention
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName. '_' .time().'.'.$extention;
            // Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        } else {
            $fileNameToStore = 'noimage.jpg';
        };

        // Create Post

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $fileNameToStore;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/posts')->with('success', 'Post Created');

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
        return view('posts.show')->with('post', $post);
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
        // check for the correct user
        if ( Auth::id() != $post->user_id ) {
            return redirect('/posts')->with('error', 'Unauhorized page');
        }
        return view('posts.edit')->with('post', $post);
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
        //validate 
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        if($request->hasfile('cover_image')) {
            //get file name with extention
            // $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
            //get just filename
            // $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileName = $request->file('cover_image')->getClientOriginalName();
            //get just extention
            $extention = $request->file('cover_image')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $fileName. '_' .time().'.'.$extention;
            // Upload the image
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
        }

        // Update Post
        $post = Post::find($id); // this is eloquent code
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasfile('cover_image')) {
            Storage::delete('public/cover_images/'.$post->cover_image);
            $post->cover_image = $fileNameToStore;
        }
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
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
        // check for the correct user
        if ( Auth::id() != $post->user_id ) {
            return redirect('/posts')->with('error', 'Unauhorized page');
        }

        //deleting the post image
        if ($post->cover_image != 'noimage.jpg') {
            // Delete Image
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();

        return redirect('/posts')->with('success', 'Post Delete');
    }
}
