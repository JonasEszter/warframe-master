<?php

namespace App\Http\Controllers;

use App\Models\Mods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Mod;

class ModsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("osszeallitasok");
    }

    public function CheckModExists($modName) {
        $result = Mods::where('ModName', '=', $modName)->first();
        return json_decode($result, 1);
    }

    public function GetModByID($modID) {
        $mod = Mods::where('ModID', $modID)
        ->join("polarity_types", "Polarity", "=", "TypeID")->first();
        return $mod;
    }

    public function GetMod($modID) {
        $modData = json_encode($this->GetModByID($modID));
        return response()->json($modData);
    }

    public function GetModsByWarframeID($warframeID) {
        $mods = DB::table('mods')
        ->whereNotNull('ModImg')
        ->where(function($query) use ($warframeID) {
            $query->whereIn('CompatName', function($subquery) use ($warframeID) {
                $subquery->select('CompatName')
                         ->from('characters')
                         ->where('CharacterID', '=', $warframeID);
            })->orWhere('CompatName', '=', 60)
              ->orWhere('CompatName', '=', 66);
        })->get();


        return $mods;
    }

    public function GetMods($warframeID) {
        $mods = $this->GetModsByWarframeID($warframeID);
        return response()->json($mods);
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mods  $mods
     * @return \Illuminate\Http\Response
     */
    public function show(Mods $mods)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mods  $mods
     * @return \Illuminate\Http\Response
     */
    public function edit(Mods $mods)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mods  $mods
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mods $mods)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mods  $mods
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mods $mods)
    {
        //
    }
}
