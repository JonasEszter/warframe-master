<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiHandler extends Model
{
    use HasFactory;

    public static function GetDataFromApi($url) {
        $jsonStr = file_get_contents($url);
        $data = json_decode($jsonStr, true);
        return $data;
    }
}
