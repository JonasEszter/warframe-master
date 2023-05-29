<?php

namespace App\Http\Controllers;

use App\Models\AuraTypes;
use Illuminate\Http\Request;

class AuraTypesController extends Controller
{
    public function GetAuraByName($auraName) {
        $result = AuraTypes::where('TypeName', '=', $auraName)->first();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $auraType = new AuraTypes();
        $auraType->typeName = $request->typeName;
        $auraType->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AuraTypes  $auraTypes
     * @return \Illuminate\Http\Response
     */
    public function show(AuraTypes $auraTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AuraTypes  $auraTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(AuraTypes $auraTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AuraTypes  $auraTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AuraTypes $auraTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AuraTypes  $auraTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(AuraTypes $auraTypes)
    {
        //
    }
}
