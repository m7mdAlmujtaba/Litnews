<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        $posts = Post::with('user')->orderBy('id', 'DESC')->get();
        // return $posts;
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
        return view('dashboard.posts.create');
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
            'body' => 'required',
        ]);

        $slug = Str::slug($request->title, '-');

        $file = $request->image;
    
        $post = new Post();
        $post->title = $request->title;
        $post->author = Auth::id();
        $post->slug = $slug;
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
     * @param  \App\Dashboard\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('dashboard.post.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard\Post  $post
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

        if (isset($request->image)) {
            $file_name = $request->image->getClientOriginalExtension();
            $imageName = $slug . '-' . uniqid() . Carbon::now()->timestamp . '.' . $file_name;
            // #1 check if category image directory is exists
            if (!Storage::disk('public')->exists('media')) {
                Storage::disk('public')->makeDirectory('media');
            }
            // DELETE old image
            if (Storage::disk('public')->exists('media/' . $post->image)) {
                Storage::disk('public')->delete('media/' . $post->image);
            }

            //Storage::disk('public')->put($img_path, $image);
            $request->image->storeAs('media', $imageName, 'public');
        } else {
            $imageName = $post->image;
        }

        $post->title = $request->title;
        $post->slug = $slug;
        $post->image = $imageName;
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
            $message = 'The post has been updated!';
            return back()->with('message', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->back();
    }
}
