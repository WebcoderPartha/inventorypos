<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('id', 'DESC')->paginate(5);
        return Response::json($category);
    }


    public function getAllCategory(){
        $category = Category::orderBy('id', 'ASC')->get();

        return Response::json($category, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
           'category_name' => 'required|unique:categories|string'
        ],[
            'category_name.required' => 'Please fill up category name'
        ]);

        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();

        return Response::json('Category created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        return Response::json($category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $validateData = $request->validate([
            'category_name' => 'required|string|unique:categories,category_name,'.$id
        ],[
            'category_name.required' => 'Please fill up category name'
        ]);

        $category                = Category::find($id);
        $category->category_name = $request->category_name;
        $category->save();

        return Response::json("Category updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return Response::json('Category deleted successfully');
    }

    public function searchCategory(){
        $key = \Request::get('q');
        $category = Category::where('category_name', 'LIKE', "%$key%")->get();
        return Response::json($category);
    }

}
