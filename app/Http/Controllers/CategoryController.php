<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','max:20'],
        ]);


        Category::create([
           'name' => $request->name,
           'description' => $request->description,
        ]);

        session()->flash('flash_message', 'Category Has Been Added Successfully');

        return redirect(route('categories.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request,[
            'name' => 'required',
        ]);

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        session()->flash('flash_message', 'Category Has Been Edited Successfully');

        return redirect(route('categories.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        session()->flash('flash_message', 'Category Has Been Deleted Successfully');

        return redirect(route('categories.index'));
    }



    public function result(Category $category){
        $books = $category->books()->paginate(12);
        $title = 'Books Have Same Category : ' . $category->name;
        return view('gallery',compact('books', 'title','category'));
    }

    public function list(){
        $categories = Category::all()->sortBy('name');
        $title = 'Categories';
        return view('categories.index',compact('categories' , 'title'));
    }

    public function search(Request $request){
        $categories = Category::where('name', 'like', "%{$request->term}%")->get()->sortBy('name');
        $title = 'Search Results : ' . $request->term;
        return view('categories.index',compact('categories' , 'title'));
    }
}
