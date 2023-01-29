<?php

namespace App\Http\Controllers;

use App\TaskUser;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'users'=>'required',
            'task_id'=>'required',
        ];

        $this->validate($request,$rules);

        foreach ($request->users as $user_id) {

            $check = TaskUser::where('user_id',$user_id)->where('task_id',$request->task_id)->get();

            if($check->count() == 1) continue;

            $saveTaskUser = new TaskUser();

            $saveTaskUser->user_id = $user_id;

            $saveTaskUser->task_id = $request->task_id;

            $saveTaskUser->save();

        }

        

        return back();


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskUser  $taskUser
     * @return \Illuminate\Http\Response
     */
    public function show(TaskUser $taskUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskUser  $taskUser
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskUser $taskUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskUser  $taskUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskUser $taskUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskUser  $taskUser
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskUser)
    {
        try {
            TaskUser::destroy($taskUser);
        } catch (\Throwable $th) {}

        return back();
    }
}
