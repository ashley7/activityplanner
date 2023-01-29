<?php

namespace App\Http\Controllers;

use App\Task;
use App\TaskUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        $user_type = ['employee','leader','admin'];

        $data = [
            'users'=>$users,
            'title'=>'Users',
            'user_type'=>$user_type,
        ];

        return view('users.list')->with($data);
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
            'name'=>'required',
            'email'=>'required|unique:users',
            'user_type'=>'required'
        ];

        $this->validate($request,$rules);

        $saveUser = new User();

        $saveUser->name = $request->name;

        $saveUser->email = $request->email;

        $saveUser->user_type = $request->user_type;

        $saveUser->password = Hash::make("user123@");

        $saveUser->remember_token = \Str::random(32);

        $saveUser->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {

        $user = User::find($user_id);

        $users = User::where('id','!=',Auth::id())->get();

        $user_tasks = TaskUser::where('user_id',$user->id)->pluck('task_id')->toArray();

        $invited_tasks = Task::whereIn('id',$user_tasks)->pluck('id')->toArray();

        $my_tasks = Task::where('user_id',$user->id)->pluck('id')->toArray();

        $tasks = array_unique(array_merge($invited_tasks,$my_tasks));

        $tasks = Task::whereIn('id',$tasks)->orderBy('id','DESC')->paginate(50);

       $data = [
        'tasks'=>$tasks,
        'title'=>'Tasks of '.$user->name,
        'users'=>$users
       ];

       return view('tasks.list')->with($data);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
