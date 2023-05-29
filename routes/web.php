<?php

use App\Http\Controllers\CharactersController;
use App\Http\Controllers\EffectTypesController;
use App\Http\Controllers\ModsController;
use App\Http\Controllers\PolarityTypesController;
use App\Http\Controllers\SetsController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoProgressesController;
use App\Http\Controllers\UserSetsController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\NewsController;
use App\Models\UserSetDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', ["loggedIn"=>Auth::check()]); 
});

Route::get("/news", [NewsController::class, "getNews"]);
Route::get("/welcome", [NewsController::class, "index"]);

Route::get("/tortenet", function() {
    return view("tortenet");
});
Route::get("/tortenet", [HistoryController::class, "index"]);
Route::get("/history", [HistoryController::class, "getHistory"]);

Route::get("/palyaismerteto", function() {
    return view("palyaismerteto");
});

Route::get("/osszeallitasok", [CharactersController::class, 'Index']);
Route::get("/warframes", [CharactersController::class, 'GetWarframes']);
Route::get("/warframe/{id}", [CharactersController::class, 'Warframe']);
Route::get("/warframe/{characterID}/{setID}", [UserSetsController::class, "warframeSet"]);
Route::get("/character/{characterID}", [CharactersController::class, "GetCharacter"]);
Route::get("/effect_types", [EffectTypesController::class, "getAllEffectTypes"]);
Route::get("/polarities", [PolarityTypesController::class, "GetPolaritiesAPI"]);
Route::get("/mods/{warframeID}", [ModsController::class, "GetMods"]);
Route::get("/effect_types_by_mod/{modID}", [EffectTypesController::class, "GetEffectTypesByModApi"]);

Route::get("/sets", [UserSetsController::class, "GetSetsApi"]);
Route::get("/setlist", [UserSetsController::class, "index"]);

Route::get("/set", [UserSetsController::class, "GetCardsBySetID"]);

Route::get("/todo_list", [TodoProgressesController::class, "index"]);
Route::get("/todo_list", [TodoProgressesController::class, "index"])->middleware('auth');
Route::get("/progress", [TodoProgressesController::class, "GetTodoListByLevelID"]);
Route::put("/progress", [TodoProgressesController::class, "SetProgress"]);


Route::post("/set", [UserSetsController::class, "store"]);
Route::put("/set/{id}", [UserSetsController::class, "update"]);
Route::delete("/delete_set", [UserSetsController::class, "DeleteSet"]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
