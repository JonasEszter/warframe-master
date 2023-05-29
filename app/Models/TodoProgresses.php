<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoProgresses extends Model
{
    use HasFactory;
    protected $fillable = ["UserID", "ListItem"];
}
