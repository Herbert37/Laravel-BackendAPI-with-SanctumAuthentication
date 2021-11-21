<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;

class LocationController extends Controller
{
    /**
     * The location model instance.
    */
    protected $locations;

    /**
     * Create a new controller instance.
     *
     * @param  Location  $locations
     * @return void
    */

    public function __construct(Location $locations)
    {
        $this->locations = $locations;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = $this->locations;
        if($request->id){
            $locations = $locations->where('id', $request->id);
        }
        if($request->reference){
            $locations = $locations->where('reference', 'like', '%'.$request->reference.'%');
        }
        if($request->user_id){
            $locations = $locations->where('user_id', $request->user_id);
        }
        return response()->json(
            [
                'locations' => $locations->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
        $location = $this->locations->fill($request->all());
        $location->save();
        return response()->json(["message"=> "Ubicación registrada exitosamente"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Location::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, $id)
    {
        $location = $this->locations->find($id);
        $location->update($request->all());
        return response()->json(["message"=> "Ubicación actualizada exitosamente"], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = $this->locations->find($id);
        $location->delete();
        return response()->json(["message"=> "Ubicación eliminada exitosamente"], 201);
    }
}
