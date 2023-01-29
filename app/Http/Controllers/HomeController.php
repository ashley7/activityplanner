<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $tasks = Task::userTask(Auth::user());

        $myTasks = [];

        foreach ($tasks as $task) {

            if($task->status($task->id)=="Completed") continue;

            $myTasks[]=$task->id;
            
        }

        $pending_tasks = Task::whereIn('id',$myTasks)->get();    

        $data = [
            'pending_tasks'=>$pending_tasks,
            'title'=>'Pending tasks'
        ];

        return view('home')->with($data);
    }
}
