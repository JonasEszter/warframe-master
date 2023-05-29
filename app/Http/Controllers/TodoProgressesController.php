<?php

namespace App\Http\Controllers;

use App\Models\TodoProgresses;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TodoLevels;
use App\Models\TodoListItems;
use Exception;

class TodoProgressesController extends Controller
{
    public function index() {
        $todo = $this->GetTodoListByLevelID();
        $levels = $this->GetLevels();
        $this->GetTodoListByLevelID();

        return view("todo_list", [
            "todo"=>$todo, 
            "levels"=>$levels
        ]);
    }

    public function GetLevels() {
        return TodoLevels::all();
    }

        
    public function GetLevel1ID() {
        $row = TodoLevels::select('LevelID')
                ->where('TodoLevel', 1)
                ->get();
    
        return !empty($row) ? $row[0]->LevelID : 0;
    }
    
    public function CheckProgress() {
        $levelID = DB::table('todo_levels')
        ->join('todo_list_items', 'todo_list_items.ItemLevel', '=', 'todo_levels.LevelID')
        ->join('todo_progresses', 'todo_progresses.ListItem', '=', 'todo_list_items.ItemID')
        ->where('UserID', Auth::id())
        ->orderBy('todo_levels.TodoLevel', 'desc')
        ->value('todo_levels.LevelID');
        
        return $levelID !== null ? $levelID : $this->GetLevel1ID();
    }

    private function GetTaskNumberByLevel($levelID) {
        $result = DB::table('todo_list_items')
        ->select(DB::raw('COUNT(ItemID) as ItemNumber'))
        ->where('ItemLevel', $levelID)
        ->first();

        return $result->ItemNumber;
    }


    private function GetTaskNumberByUser($levelID) {
        $result = DB::table('todo_list_items')
        ->select(DB::raw('COUNT(todo_list_items.ItemID) as ItemNumber'))
        ->join('todo_progresses', 'todo_progresses.ListItem', '=', 'todo_list_items.ItemID')
        ->where('todo_list_items.ItemLevel', $levelID)
        ->where('todo_progresses.UserID', Auth::id())
        ->first();

        return $result->ItemNumber;
    }

    public function GetTodoListByLevelID() {
        $currentLevelID = $this->CheckProgress();
        $currentLevel = DB::table('todo_levels')
            ->where('LevelID', $currentLevelID)
            ->value('TodoLevel');

        $nextLevel = $currentLevel + 1;
    
        $nextLevelID = DB::table('todo_levels')
            ->where('TodoLevel', $nextLevel)
            ->value('LevelID');
    
        $itemNumber = $this->GetTaskNumberByLevel($currentLevelID);
        $userItems = $this->GetTaskNumberByUser($currentLevelID);

        if ($itemNumber == $userItems) {
            if ($nextLevelID) {
                $row = TodoListItems::select('todo_list_items.*', 'todo_progresses.ProgressID')
                ->leftJoin('todo_progresses', function ($join) {
                    $join->on('todo_list_items.ItemID', '=', 'todo_progresses.ListItem')
                        ->where('todo_progresses.UserID', Auth::id());
                })
                ->where('todo_list_items.ItemLevel', $nextLevelID)
                ->get();
            } else {
                $row = TodoListItems::select('todo_list_items.*', 'todo_progresses.ProgressID')
                ->leftJoin('todo_progresses', function ($join) {
                    $join->on('todo_list_items.ItemID', '=', 'todo_progresses.ListItem')
                        ->where('todo_progresses.UserID', Auth::id());
                })
                ->where('todo_list_items.ItemLevel', $currentLevelID)
                ->get();
            }
        } else {
            $row = TodoListItems::select('todo_list_items.*', 'todo_progresses.ProgressID')
                ->leftJoin('todo_progresses', function ($join) {
                    $join->on('todo_list_items.ItemID', '=', 'todo_progresses.ListItem')
                        ->where('todo_progresses.UserID', Auth::id());
                })
                ->where('todo_list_items.ItemLevel', $currentLevelID)
                ->get();
        }
    
        return $row ?? [];
    }
    
    public function SetProgress(Request $req) {
        if ($req->checked == "true") {
            TodoProgresses::create([
                'UserID' => Auth::id(),
                'ListItem' => $req->itemID
            ]);
        } else {
            TodoProgresses::where('UserID', Auth::id())
                ->where('ListItem', $req->itemID)
                ->delete();
        }
        return response()->json(true);
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TodoProgresses  $todoProgresses
     * @return \Illuminate\Http\Response
     */
    public function show(TodoProgresses $todoProgresses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TodoProgresses  $todoProgresses
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoProgresses $todoProgresses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TodoProgresses  $todoProgresses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoProgresses $todoProgresses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TodoProgresses  $todoProgresses
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoProgresses $todoProgresses)
    {
        //
    }
}
