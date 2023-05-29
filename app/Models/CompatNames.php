<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompatNames extends Model
{
    use HasFactory;
    protected $fillable = [
        "TypeID", "TypeName",
        "created_at", "update_at"
    ];

    public function StoreCompatName($compatName) {
        $compatName = self::create([
            'TypeName'=>$compatName
        ]);
         
        $compatName->save();
        return $compatName->id;
    }

    public function GetTypeID($compatName) {
        $result = self::where('TypeName', '=', $compatName)->first();
        $resultArray = json_decode($result, 1);
        return isset($resultArray["TypeID"]) ? (int)$resultArray["TypeID"] : 0;
    }
}
