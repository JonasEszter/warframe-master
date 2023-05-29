<?php namespace App\Http\Controllers;
use App\Models\Characters;
use App\Models\AuraTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Mods;

class CharactersController extends Controller
{
    private $auraTypes;

    function __construct() {
        $this->auraTypes = new AuraTypes();
        //parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Index()
    {
        $characters = new Characters();
        $characters->UploadWarframes();
        $mods = new Mods();
        $mods->UploadMods();
        $mc = new ModsController();
        $mc->GetModsByWarframeID(1);
        return view("osszeallitasok");
    }

    public function Warframe() {
        return view("warframe", ["loggedIn"=>Auth::check()]);
    }

    public function GetWarframes()
    {
        $characters = Characters::getAll();
        return $characters;
    }

    public function CheckWarframeExists($charName)
    {
        $result = Characters::checkIfExists($charName);
        return json_decode($result, 1);
    }

    public function getWarframeByID($characterID)
    {
        $warframe = Characters::getByID($characterID);
        return $warframe;
    }

    public function GetCharacter($characterID) {
        $charData = json_encode($this->GetWarframeByID($characterID));
        return response()->json($charData);
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
     * @param  \App\Models\Characters  $characters
     * @return \Illuminate\Http\Response
     */
    public function show(Characters $characters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Characters  $characters
     * @return \Illuminate\Http\Response
     */
    public function edit(Characters $characters)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Characters  $characters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Characters $characters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Characters  $characters
     * @return \Illuminate\Http\Response
     */
    public function destroy(Characters $characters)
    {
        //
    }
}
