<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EffectTypes extends Model
{
    use HasFactory;
    protected $fillable = ['TypeName'];

    public function StoreEffect($effectName) {
        $effectType = self::create([
            'TypeName'=>$effectName
        ]);
         
        $effectType->save();
        return $effectType->id;
    }

    public function GetEffectID($effectType) {
        $result = self::where('TypeName', '=', $effectType)->first();
        $resultArray = json_decode($result, 1);
        return isset($resultArray["TypeID"]) ? (int)$resultArray["TypeID"] : 0;
    }

}
