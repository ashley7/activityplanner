<?php

namespace App\Http\Controllers;

use App\TaskActivityFiles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskActivityFilesController extends Controller
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
            'file_url'=>'required',
            'name'=>'required'
        ];

        $this->validate($request,$rules);

        $saveFile = new TaskActivityFiles();

        $saveFile->task_activity_id = $request->task_activity_id;

        $saveFile->user_id = Auth::id();

        $saveFile->file_url = User::uploadFile($request->file('file_url'));

        $saveFile->name = $request->name;

        $saveFile->save();

        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TaskActivityFiles  $taskActivityFiles
     * @return \Illuminate\Http\Response
     */
    public function show(TaskActivityFiles $taskActivityFiles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaskActivityFiles  $taskActivityFiles
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskActivityFiles $taskActivityFiles)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaskActivityFiles  $taskActivityFiles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaskActivityFiles $taskActivityFiles)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaskActivityFiles  $taskActivityFiles
     * @return \Illuminate\Http\Response
     */
    public function destroy($taskActivityFiles)
    {
        $files = TaskActivityFiles::find($taskActivityFiles);

        User::deleteFile($files);

        TaskActivityFiles::destroy($files->id);

        return back();
    }
}
