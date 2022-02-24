<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isEmpty;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::All();
        return view('dashboard.categories.index', [
            'categories' => $categories
        ]);
    }

         /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create');
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
            'name' => 'required|max:255|unique:categories',
        ]);

        $slug = Str::slug($request->name, '-');

        $file = $request->image;
    
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $slug;

        if(!isEmpty($error)){
            return back()->withInput()->with('error', $error);
        } else {
            $category->save();
            $redirect_url = 'dashboard/category/'.$category->id.'/edit';
            return redirect($redirect_url)->with('message', $message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('dashboard.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $error = "";
        $message = "";
        // validate
        if ($request->name == Category::findOrFail($id)->name) {
            $this->validate($request, [
                'name' => 'required|max:255',
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required|max:255|unique:categories',
               
            ]);
        }

        $category = Category::findOrFail($id);
        if(isset($request->slug)){
            $slug = Str::slug($request->slug, '-');
        } else{
            $slug = $category->slug;
        }

        $category->name = $request->name;
        $category->slug = $slug;

        if(!isEmpty($error)){
            return back()->withInput()->with('error', $error);
        } else {
            $category->update();
            $message = 'The category has been updated!';
            return back()->with('message', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back();
    }
    
}
