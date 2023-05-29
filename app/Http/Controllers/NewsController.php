<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index() {
        $n = new News();
        $n->UploadNews();

        $news = News::all();
        return view("/welcome", ["news"=>$news]);
    }

    public function getNews() {
        return News::all();
    }
}
