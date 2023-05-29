<?php

namespace App\Http\Controllers;

use App\Models\CompatNames;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mods;

class CompatNamesController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompatNames  $compatNames
     * @return \Illuminate\Http\Response
     */
    public function show(CompatNames $compatNames)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompatNames  $compatNames
     * @return \Illuminate\Http\Response
     */
    public function edit(CompatNames $compatNames)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompatNames  $compatNames
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompatNames $compatNames)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CompatNames  $compatNames
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompatNames $compatNames)
    {
        //
    }
}
