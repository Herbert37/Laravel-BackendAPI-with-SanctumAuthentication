<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * The category model instance.
    */
    protected $categories;

    /**
     * Create a new controller instance.
     *
     * @param  Category  $categories
     * @return void
    */

    public function __construct(Category $categories)
    {
        $this->categories = $categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = $this->categories;
        if($request->id){
            $categories = $categories->where('id', $request->id);
        }
        if($request->name){
            $categories = $categories->where('name', 'like', '%'.$request->name.'%');
        }
        return response()->json(
            [
                'categories' => $categories->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categories->fill($request->all());
        $category->save();
        return response()->json(["message"=> "Categoria creada exitosamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Category::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categories->find($id);
        $category->update($request->all());
        return response()->json(["message"=> "Categoria actualizada exitosamente"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categories->find($id);
        $category->delete();
        return response()->json(["message"=> "Categoria eliminada exitosamente"], 201);
    }

    /**
     * Search for a name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Category::where('name', 'like', '%'.$name.'%')->get();
    }
}
