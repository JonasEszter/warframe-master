<?php

namespace App\Http\Controllers;
use App\Models\EffectTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EffectTypesController extends Controller {

    public function CheckModTypeExists($typeName) {
        $result = EffectTypes::where('TypeName', '=', $typeName)->first();
        return json_decode($result, 1);
    }

    public function GetEffectTypes() {
        $result = EffectTypes::all();
        return $result;
    }

    public function GetEffectTypesApi() {
        $effectData = $this->GetEffectTypes();
        return response()->json($effectData);
    }


    public function GetEffectTypesByMod($modID) {
        $rows = DB::table('mod_effect_type_relations')
            ->select('EffectValue', 'EffectType')
            ->where('mod_effect_type_relations.ModID', $modID)
            ->where("mod_effect_type_relations.ModLevel", 1)
            ->get();
        return $rows;
    }

    public function GetEffectTypesByModApi($modID) {
        $rows = $this->GetEffectTypesByMod($modID);
        return response()->json($rows);
    }

    public function GetEffectTypeIDByName($name) {
        $row = EffectTypes::where('TypeName', $name)->first();
        return !empty($row) ? (int)$row->TypeID : 0;
    }

    public function getAllEffectTypes() {
        $effectTypes = [
            "energy"=>$this->GetEffectTypeIDByName("energy"),
            "health"=>$this->GetEffectTypeIDByName("health"),
            "shield"=>$this->GetEffectTypeIDByName("shield"),
            "speed"=>$this->GetEffectTypeIDByName("sprint speed"),
            "armor"=>$this->GetEffectTypeIDByName("armor")
        ];

        return response()->json($effectTypes);
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
        $effectType = new EffectTypes();
        $effectType->typeName = $request->typeName;
        $effectType->save();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EffectTypes  $effectTypes
     * @return \Illuminate\Http\Response
     */
    public function show(EffectTypes $effectTypes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EffectTypes  $effectTypes
     * @return \Illuminate\Http\Response
     */
    public function edit(EffectTypes $effectTypes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EffectTypes  $effectTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EffectTypes $effectTypes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EffectTypes  $effectTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy(EffectTypes $effectTypes)
    {
        //
    }
}
