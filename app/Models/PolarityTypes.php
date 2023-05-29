<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PolarityTypes extends Model
{
    use HasFactory;

    protected $fillable = ['TypeName'];

    public function StorePolarity($polarityName) {
        $polarityType = self::create([
            'TypeName'=>$polarityName
        ]);
         
        $polarityType->save();
        return (int)DB::getPdo()->lastInsertId();
    }

    public function GetPolarityID($polarityName) {
        $result = self::where('TypeName', '=', $polarityName)->first();
        $resultArray = json_decode($result, 1);
        return isset($resultArray["TypeID"]) ? (int)$resultArray["TypeID"] : 0;
    }
}
