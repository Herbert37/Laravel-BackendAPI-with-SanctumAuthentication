<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSubcategoryRequest;
use App\Http\Requests\UpdateSubcategoryRequest;

class SubcategoryController extends Controller
{

    /**
     * The subcategory model instance.
    */
    protected $subcategories;

    /**
     * Create a new controller instance.
     *
     * @param  Subcategory  $subcategories
     * @return void
    */

    public function __construct(Subcategory $subcategories)
    {
        $this->subcategories = $subcategories;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subcategories = $this->subcategories;
        if($request->category){
            $subcategories = $subcategories->where('category_id', $request->category);
        }
        return $subcategories->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubcategoryRequest $request)
    {
        $subcategory = $this->subcategories->fill($request->all());
        $subcategory->save();
        return response()->json(["message"=> "Registro creado exitosamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category_id)
    {
        return Subcategory::load('categories.$category_id');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubcategoryRequest $request, $id)
    {
        $subcategory = $this->subcategories->find($id);
        $subcategory->update($request->all());
        return response()->json(["message"=> "Registro actualizado exitosamente"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = $this->subcategories->find($id);
        $subcategory->delete();
        return response()->json(["message"=> "Registro eliminado exitosamente"], 201);
    }

    /**
     * Search for a name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Subcategory::where('name', 'like', '%'.$name.'%')->get();
    }
}
