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
        /*
        * by the following we get only the posts for the logged in user
        * $posts = auth()->user()-posts; 
        */
        // $posts = Post::all();
        // return Post::where('title', 'something')->get()  this way we can get a single post well detirmened 
        // to get a limited numbe we can do this; Post::ordreBy('title', 'desc')->take(1)->get();
        // $posts = Post::orderBy('title', 'asc')->get();
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        // // Doing the following will return a JSON
        // return $posts;
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
     * 
     */
    public function store(Request $request)
    {
        // another way to validate the data
        request()->validate([
            'title' => 'required',
            'body' => 'required',
            'cover_image' => 'image|nullable|max:1999',
            'c_name' => 'required',
            'c_web' => 'required'
        ]);
        //validate and store the blog post
        // $this->validate($request, [
        //     'title' => 'required',
        //     'body' => 'required',
        //     'cover_image' => 'image|nullable|max:1999',
        //     'c_name' => 'required',
        //     'c_web' => 'required'
        // ]);

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
        Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'c_name' => $request->input('c_name'),
            'c_web' => $request->input('c_web'),
            'cover_image' => $fileNameToStore,
            'user_id' => auth()->user()->id
        ]);

        // or we can simply do the following, but make sure to specify the fillabale property in the model to prevent miss use, but in our case its not 
        // since we are using the auth() 

        // Post::create($request->all());

        // $post = new Post;
        // $post->title = $request->input('title');
        // $post->body = $request->input('body');
        // $post->c_name = $request->input('c_name');
        // $post->c_web = $request->input('c_web');
        // $post->cover_image = $fileNameToStore;
        // $post->user_id = auth()->user()->id;
        // $post->save();

        return redirect('/posts')->with('success', 'Post Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * Instead of using $id we can use Post $post
     * that way we dont have to manualy fetch the DB
     */ 
    // public function show(Post $post)
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     * we can also use Post $post instead of $id
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
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
        /**
         * we can also use request() to get the data from the request
         */
        // Update Post
        if($request->hasfile('cover_image')) {
            Storage::delete('public/cover_images/'.$post->cover_image);
            $post->cover_image = $fileNameToStore;
        }
        $post = Post::findOrFail($id); // this is eloquent code
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->c_name = $request->input('c_name');
        $post->c_web = $request->input('c_web');
        
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
        $post = Post::findOrFail($id);
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
