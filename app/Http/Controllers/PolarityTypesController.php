<?php

namespace App\Http\Controllers;

use App\Models\PolarityTypes;
use Illuminate\Http\Request;

class PolarityTypesController extends Controller
{
    public function CheckPolarityTypeExists($typeName) {
        $result = PolarityTypes::where('TypeName', '=', $typeName)->first();
        return json_decode($result, 1);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    public function GetPolarities() {
        $polarities = PolarityTypes::all();
        return $polarities;
    }

    public function GetPolaritiesAPI() {
        $polarities = $this->GetPolarities();
        return response()->json($polarities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $polarityType = new PolarityTypes();
        $polarityType->typeName = $request->typeName;
        $polarityType->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PolarityTypes  $polarityTypes
     * @return \Illuminate\Http\Response
     */
    public function show(PolarityTypes $polarityTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PolarityTypes  $polarityTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(PolarityTypes $polarityTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PolarityTypes  $polarityTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PolarityTypes $polarityTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PolarityTypes  $polarityTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(PolarityTypes $polarityTypes)
    {
        //
    }
}
