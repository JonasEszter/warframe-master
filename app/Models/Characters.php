<?php

namespace App\Models;

use App\Http\Controllers\AuraTypesController;
use App\Http\Controllers\CharactersController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Characters extends Model
{
    use HasFactory;
    private $cc;
    private $ac;
    private $am;
    protected $fillable = [
        "CharName", "Shield", "CharPower",
        "Health", "Speed", "Armor",
        "Aura", "IsPrime", 
        "Image", "CompatName"
    ];

    public static function getAll()
    {
        return self::all();
    }

    public static function checkIfExists($charName)
    {
        $result = self::where('CharName', '=', $charName)->first();
        return $result;
    }

    public static function getByID($characterID)
    {
        $warframe = self::where('CharacterID', $characterID)
            ->join("aura_types", "Aura", "=", "TypeID")
            ->first();
        return $warframe;
    }

    public function UploadWarframes() {
        $warFrames = ApiHandler::GetDataFromApi("https://api.warframestat.us/warframes?only=name,isPrime,power,health,sprintSpeed,armor,aura,polarities,wikiaThumbnail,category,shield");
        $this->ac = new AuraTypesController();
        $this->am = new AuraTypes();
        $this->cn = new CompatNames();

        foreach($warFrames as $wf) {
            if($this->checkIfExists($wf["name"]))
                continue;

            if($wf["category"] == "Warframes") {
                $auraID = 0;
                $compatID = 0;

                $charNameNonPrime = str_replace(" Prime", "", $wf["name"]);
                $compatID = $this->cn->GetTypeID($charNameNonPrime);

                if($compatID == 0) {
                    $compatID = $this->cn->StoreCompatName($charNameNonPrime);
                }

                if(isset($wf["aura"])) {
                    $auraData = $this->ac->GetAuraByName($wf["aura"]);

                    if(!isset($auraData["TypeID"])) {
                        $auraID = $this->am->StoreAura($wf["aura"]);
                    } else {
                        $auraID = $auraData["TypeID"];
                    }
                }

                if($auraID != 0) {
                    $character = Characters::create([
                        "CharName"=>$wf["name"],
                        "Shield"=>$wf["shield"],
                        "CharPower"=>$wf["power"],
                        "Health"=>$wf["health"],
                        "Speed"=>$wf["sprintSpeed"],
                        "Armor"=>$wf["armor"],
                        "Aura"=>$auraID,
                        "CompatName"=>$compatID,
                        "IsPrime"=>$wf["isPrime"],
                        "Image"=>isset($wf["wikiaThumbnail"]) ? mb_substr($wf["wikiaThumbnail"], 
                        0, mb_strpos($wf["wikiaThumbnail"], "png") + 3) : "asdf"
                    ]);
    
                    $character->save();
                }
            }
        }
    }
}
