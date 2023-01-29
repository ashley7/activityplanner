<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $tasks = Task::userTask(Auth::user());

       $users = User::where('id','!=',Auth::id())->get();

       $data = [
        'tasks'=>$tasks,
        'title'=>'Tasks',
        'users'=>$users,
       ];

       return view('tasks.list')->with($data);
        
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
        $rules = [
            'title'=>'required',
            'start_date'=>'required',
            'end_date'=>'required'
        ];

        $this->validate($request,$rules);

        $saveTask = new Task();

        $saveTask->title = $request->title;

        $saveTask->start_date = $request->start_date;

        $saveTask->end_date = $request->end_date;

        $saveTask->description = $request->description;

        $saveTask->user_id = Auth::id();

        $saveTask->save();

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($task_id)
    {
        $task = Task::find($task_id);

        $user = Auth::user();       

        if($user->user_type == "leader")

            $status = ['pending','processing','completed'];

        else

            $status = ['pending','processing'];

        $data = [
            'task'=>$task,
            'title'=>$task->title,
            'status'=>$status,
        ];

        return view('tasks.details')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $task_id)
    {
        $saveTask = Task::find($task_id);

        $saveTask->title = $request->title;

        $saveTask->start_date = $request->start_date;

        $saveTask->end_date = $request->end_date;

        $saveTask->description = $request->description;

        $saveTask->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
