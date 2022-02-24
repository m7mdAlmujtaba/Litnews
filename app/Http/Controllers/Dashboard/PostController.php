<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('user', 'category')->orderBy('id', 'DESC')->get();
        return view('dashboard.posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::All();
        return view('dashboard.posts.create', ['categories' => $categories]);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error = "";
        $message = "";
        // return Auth::guard('admin')->id();
        $this->validate($request, [
            'title' => 'required|max:255|unique:posts',
            'image' => 'required|mimes:jpg,png,bmp,jpeg',
            'category' => 'required|integer',
            'body' => 'required'
        ]);

        $slug = Str::slug($request->title, '-');

        $file = $request->image;
    
        $post = new Post();
        $post->title = $request->title;
        $post->author = Auth::id();
        $post->slug = $slug;
        $post->category_id = $request->category;
        $post->body = $request->body;

        if (request('status')) {
            $post->status = 1;
            $message = 'The post has been published!';
        } else {
            $post->status = 0;
            $message = 'The post has been saved to draft!';
        }
        //dd($post);
        if(!isEmpty($error)){
            return back()->withInput()->with('error', $error);
        } else {
            $post->save();
            $post->addMedia($file)->toMediaCollection();
            $redirect_url = 'dashboard/post/'.$post->id.'/edit';
            return redirect($redirect_url)->with('message', $message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::All();
        return view('dashboard.posts.edit', ['post' => $post, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error = "";
        $message = "";
        // validate
        if ($request->title == Post::findOrFail($id)->title) {
            $this->validate($request, [
                'title' => 'required|max:255', //added unique Post later by me
                'image' => 'sometimes|mimes:jpeg,bmp,png,jpg|max:5000',
                'body' => 'required',
            ]);
        } else {
            $this->validate($request, [
                'title' => 'required|max:255|unique:posts', //added unique Post later by me
                'image' => 'sometimes|mimes:jpeg,bmp,png,jpg|max:5000',
                'body' => 'required',
            ]);
        }

        $post = Post::findOrFail($id);
        if(isset($request->slug)){
            $slug = Str::slug($request->slug, '-');
        } else{
            $slug = $post->slug;
        }

        $post->title = $request->title;
        $post->slug = $slug;
        $post->category_id = $request->category;
        $post->body = $request->body;

        if (request('status')) {
            $post->status = 1;
        } else {
            $post->status = 0;
        }


        if(!isEmpty($error)){
            return back()->withInput()->with('error', $error);
        } else {
            $post->update();
            if (isset($request->image)) {
                $file = $request->image;
                $post->addMedia($file)->toMediaCollection();
            }
            $message = 'The post has been updated!';
            return back()->with('message', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->back();
    }
}
