<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HistoryController extends Controller
{
    public function index() {
        $history = History::all();
        return view("/tortenet", ["history"=>$history]);
    }

    public function getHistory() {
        return History::all();
    }
}
