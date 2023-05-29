<?php

namespace App\Http\Controllers;

use App\Models\UserSets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserSetDetails;
use Exception;
use Illuminate\Support\Facades\Log;

class UserSetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view("setlist");
    }

    public function warframeSet() {
        return view("warframe_set", ["loggedIn"=>Auth::check()]);
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
        $sets = UserSets::create([
            "SetName"=>$request->setName,
            "UserID"=>Auth::id(),
            "CharacterID"=>$request->characterID
        ]);

        $sets->save();

        $setID = (int)DB::getPdo()->lastInsertId();

        foreach($request->modObjects as $modObj) {
            
            try {
                $data = [
                    "SetID"=>$setID,
                    "Place"=>$modObj["place"],
                    "ModLevel"=>$modObj["modLevel"]
                ];

                if($modObj["modID"] != 0)
                    $data["ModID"] = $modObj["modID"];
                
                if($modObj["polarity"] != 0)
                    $data["PolarityID"] = $modObj["polarity"];

                $setDetails = UserSetDetails::create($data);
    
                $setDetails->save();
            } catch(Exception $ex) {
                file_put_contents(__DIR__ . "/errors.log", $ex->getMessage());
            }
        }
        
        return response()->json($setID);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserSets  $userSets
     * @return \Illuminate\Http\Response
     */
    public function show(UserSets $userSets)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserSets  $userSets
     * @return \Illuminate\Http\Response
     */
    public function edit(UserSets $userSets)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserSets  $userSets
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $userSet = UserSets::findOrFail($request->setID);
        $userSet->SetName = $request->setName;
        $userSet->save();
        UserSetDetails::where('SetID', $request->setID)->delete();

        foreach ($request->modObjects as $modObj) {
            $data = [
                "SetID"=>$request->setID,
                "Place"=>$modObj["place"],
                "ModLevel"=>$modObj["modLevel"]
            ];

            if($modObj["modID"] != 0)
                $data["ModID"] = $modObj["modID"];
            
            if($modObj["polarity"] != 0)
                $data["PolarityID"] = $modObj["polarity"];

            $setDetails = UserSetDetails::create($data);
            $setDetails->save();
        }
        
        return response()->json($request->setID);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserSets  $userSets
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserSets $userSets)
    {
        $userSets->delete();
    }

    public function DeleteSet(Request $req) {
        try {
            $userSet = UserSets::findOrFail($req->setID);
            $this->destroy($userSet);
        } catch(Exception $ex) {
            Log::error($ex->getMessage());
        }
        return true;
    }

    public function GetCardsBySetID(Request $req) {
        $setData = DB::table('user_sets')
        ->select('SetName', 'UserID')
        ->where('SetID', '=', $req->setID)
        ->get();

        $rows = DB::table('user_set_details')
        ->select('user_set_details.Place', 'user_set_details.PolarityID', 
        'user_set_details.ModLevel', 'mods.*')
        ->join('mods', 'mods.ModID', '=', 'user_set_details.ModID')
        ->where('user_set_details.SetID', '=', $req->setID)
        ->get();

        return [$setData, $rows, Auth::id()];
    }

    public function GetSets() {
        $rows = DB::table('user_sets')
        ->join('users', 'users.id', '=', 'user_sets.UserID')
        ->join('characters', 'characters.CharacterID', '=', 'user_sets.CharacterID')
        ->select('user_sets.SetName', 'users.name', 
        'characters.CharName', 'characters.Image', 
        'characters.CharacterID', 'user_sets.SetID')
        ->get();

        return $rows;
    }

    public function GetSetsApi() {
        $rows = $this->GetSets();
        return response()->json($rows);
    }
}
