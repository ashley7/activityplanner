<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activities()
    {
        return $this->hasMany(TaskActivity::class);
    }

    public function taskUsers()
    {
        return $this->hasMany(TaskUser::class);
    }

    public static function status($task_id)
    {

        $task = Task::find($task_id);

        if($task->activities->count() == 0)

            return "No activities";

        $statuses = $task->activities->pluck('status')->toArray();

        if (in_array("pending",$statuses) || in_array("processing",$statuses) ) 

            return "Incomplete activities";

        else 

            return "Completed";        

    }
    
    public static function userTask($user)
    {
        
        if($user->user_type == "leader")

            $tasks = Task::paginate(50);

        else {

            $user_tasks = TaskUser::where('user_id',$user->id)->pluck('task_id')->toArray();

            $invited_tasks = Task::whereIn('id',$user_tasks)->pluck('id')->toArray();

            $my_tasks = Task::where('user_id',$user->id)->pluck('id')->toArray();

            $tasks = array_unique(array_merge($invited_tasks,$my_tasks));

            return Task::whereIn('id',$tasks)->orderBy('id','DESC')->paginate(50);

        }

        return $tasks;           

        
    }
}
