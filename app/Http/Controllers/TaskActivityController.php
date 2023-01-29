<?php

namespace App\Http\Controllers;

use App\TaskActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskActivityController extends Controller
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
            'title'=>'required',
        ];

        $this->validate($request,$rules);

        $saveActivity = new TaskActivity();

        $saveActivity->task_id = $request->task_id;

        $saveActivity->user_id = Auth::id();

        $saveActivity->title = $request->title;

        $saveActivity->description = $request->description;

        $saveActivity->save();

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskActivity  $taskActivity
     * @return \Illuminate\Http\Response
     */
    public function show(TaskActivity $taskActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskActivity  $taskActivity
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskActivity $taskActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskActivity  $taskActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $taskActivity)
    {

        $updateActivty = TaskActivity::find($taskActivity);

        if(!empty($request->title))

            $updateActivty->title = $request->title;

        if(!empty($request->description))

            $updateActivty->description = $request->description;

        if(!empty($request->results))

            $updateActivty->results = $request->results;

        $updateActivty->status = $request->status;

        $updateActivty->save();

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskActivity  $taskActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskActivity)
    {

        try {
            TaskActivity::destroy($taskActivity);
        } catch (\Throwable $th) {}

        return back();
    }
}
