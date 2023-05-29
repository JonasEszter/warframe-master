<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        "NewsTitle", "NewsLink", "ImageLink",
        "NewsDate"
    ];

    private function CheckNewsExists($newsName) {
        $result = News::where('NewsTitle', '=', $newsName)->first();
        return json_decode($result, 1);
    }

    public function UploadNews()
    {
        $news = ApiHandler::GetDataFromApi("https://api.warframestat.us/pc/news/");

        foreach ($news as $new) {
            if ($this->CheckNewsExists($new["message"]))
                continue;

            $newsItem = News::create([
                "NewsTitle" => $new["message"],
                "NewsLink" => $new["link"],
                "ImageLink" => $new["imageLink"],
                //"NewsDate" => $new["date"]
            ]);

            $newsItem->save();
        }
    }
}
