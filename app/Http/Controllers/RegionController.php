<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;

class RegionController extends Controller
{
    /**
     * The region model instance.
    */
    protected $regions;

    /**
     * Create a new controller instance.
     *
     * @param  Region  $regions
     * @return void
    */

    public function __construct(Region $regions)
    {
        $this->regions = $regions;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = $this->regions->all();
        return $regions;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionRequest $request)
    {
        $region = $this->regions->fill($request->all());
        $region->save();
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
        return Region::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request, $id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionRequest $request, $id)
    {
        $region = $this->regions->find($id);
        $region->update($request->all());
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
        $region = $this->regions->find($id);
        $region->delete();
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
        return Region::where('name', 'like', '%'.$name.'%')->get();
    }
}
