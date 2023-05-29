<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuraTypes extends Model
{
    use HasFactory;
    protected $fillable = ['TypeName'];

    public function StoreAura($auraName) {
        $auraType = self::create([
            'TypeName'=>$auraName
        ]);
         
        $auraType->save();
        return (int)DB::getPdo()->lastInsertId();
    }
}