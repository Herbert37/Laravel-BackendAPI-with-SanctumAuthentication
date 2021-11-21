<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use App\Http\Requests\StoreSpecialtyRequest;
use App\Http\Requests\UpdateSpecialtyRequest;

class SpecialtyController extends Controller
{
    /**
     * The specialty model instance.
    */
    protected $specialties;

    /**
     * Create a new controller instance.
     *
     * @param  Specialty  $specialties
     * @return void
    */

    public function __construct(Specialty $specialties)
    {
        $this->specialties = $specialties;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $specialties = $this->specialties;
        $popular = $this->specialties;
        $recommended = $this->specialties;
        if($request->id){
            $specialties = $specialties->where('id', $request->id);
            return response()->json(
                [
                    'specialties' => $specialties->get(),
                ]
            );
        }
        if($request->name){
            $specialties = $specialties->where('name', 'like', '%'.$request->name.'%');
            return response()->json(
                [
                    'specialties' => $specialties->get(),
                ]
            );
        }
        if($request->subcategory_id){
            $specialties = $specialties->where('subcategory_id', $request->subcategory_id);
            return response()->json(
                [
                    'specialties' => $specialties->get(),
                ]
            );
        }
        $specialties = $specialties->whereNull('type');
        $popular = $popular->where('type', 'popular');
        $recommended = $recommended->where('type', 'recommended');
        return response()->json(
            [
                'specialties' => [
                    'popular' => $popular->get(),
                    'recommended' => $recommended->get(),
                    'normal' => $specialties->get(),
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSpecialtyRequest $request)
    {
        $specialty = $this->specialties->fill($request->all());
        $specialty->save();
        return response()->json(["message"=> "Registro creado exitosamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Specialty::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSpecialtyRequest $request, $id)
    {
        $specialty = $this->specialties->find($id);
        $specialty->update($request->all());
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
        $specialty = $this->specialties->find($id);
        $specialty->delete();
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
        return Specialty::where('name', 'like', '%'.$name.'%')->get();
    }
}
