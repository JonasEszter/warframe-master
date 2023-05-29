<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSetDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        "DetailID", "SetID", "Place", "ModID",
        "PolarityID", "ModLevel", "created_at", "updated_at"
    ];
}
