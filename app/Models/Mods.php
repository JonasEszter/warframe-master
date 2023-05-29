<?php

namespace App\Models;

use App\Http\Controllers\CompatNamesController;
use App\Http\Controllers\ModsController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mods extends Model
{
    use HasFactory;

    protected $fillable = [
        "ModName", "Polarity", "ModImg",
        "IsPrime", "BaseDrain", "CompatName"
    ];
    private $pt;
    private $et;
    private $mc;
    private $cn;

    public function UploadMods() {
        $mods = ApiHandler::GetDataFromApi("https://api.warframestat.us/mods?only=name,levelStats,wikiaThumbnail,compatName,baseDrain,isPrime,polarity");
        $this->mc = new ModsController();
        $this->pt = new PolarityTypes();
        $this->et = new EffectTypes();
        $this->cn = new CompatNames();

        foreach($mods as $mod) {
            if(!isset($mod["levelStats"])
            || !isset($mod["compatName"])
            || $this->mc->CheckModExists($mod["name"]))
                continue;

            $polarityID = $this->pt->GetPolarityID($mod["polarity"]);
            $compatID = $this->cn->GetTypeID($mod["compatName"]);

            if($polarityID == 0)
                $polarityID = $this->pt->StorePolarity($mod["polarity"]);

            if($compatID == 0)
                $compatID = $this->cn->StoreCompatName($mod["compatName"]);

            if($polarityID != 0 && $compatID != 0) {
                $mods = Mods::create([
                    "ModName"=>$mod["name"],
                    "Polarity"=>$polarityID,
                    "ModImg"=>isset($mod["wikiaThumbnail"]) ? mb_substr($mod["wikiaThumbnail"], 
                    0, mb_strpos($mod["wikiaThumbnail"], "png") + 3) : null,
                    "IsPrime"=>$mod["isPrime"],
                    "BaseDrain"=>$mod["baseDrain"],
                    "CompatName"=>$compatID
                ]);

                $mods->save();

                $modID = (int)DB::getPdo()->lastInsertId();
                $level = 0;

                foreach($mod["levelStats"] as $stat) {
                    if(!isset($stat["stats"]))
                        continue;
    
                    $level++;
    
                    foreach($stat["stats"] as $s) {
                        $s = preg_replace("/\<[\d\w]+\>/", "", $s);
                        preg_match("/((?:\+|\-)(?:\d\.?\d?){1,4})(?:\%?)\s([\w\s]*)/", str_replace("\n", "", trim($s)), $matches);
                        
                        if(!empty($matches[2])) {
                            $typeID = $this->et->GetEffectID($matches[2]);

                            if($typeID == 0)
                                $typeID = $this->et->StoreEffect($matches[2]);

                            DB::insert("INSERT INTO mod_effect_type_relations 
                            (EffectType, ModID, EffectValue, ModLevel)
                            VALUES(?,?,?,?)",  [
                                $typeID,
                                $modID,
                                $matches[1],
                                $level
                            ]);
                        }
                    }
                }
            }
        }
    }
}
