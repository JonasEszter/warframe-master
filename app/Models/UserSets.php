<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSets extends Model
{
    use HasFactory;
    protected $fillable = [
        "SetID", "SetName", "UserID",
        "CharacterID", "created_at", "updated_at"
    ];
    protected $primaryKey = 'SetID';

}
