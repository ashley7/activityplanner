@extends('layouts.app')

@section('content')
<div class="container">

    <div>
        <span style="font-size: 25px;">{{$title}}</span>
        <span>
        <button style="float: right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
        Open new task
        </button>
            @if(Auth::user()->user_type == "leader")
            <a style="float: right;" class="btn btn-success" href="{{url('users')}}">User Tasks</a>
            <hr>
            @endif
        </span>
    </div>

    <hr>
    

    <div class="card">
        <div class="card-body">            
        @foreach($pending_tasks as $task)            
            <div class="task">

                <a style="text-decoration:none;" class="text-success" href="{{route('tasks.show',$task->id)}}">
                    <h5>{{$task->title}}</h5>
                </a>               

                <p class="text-muted">{!! $task->description !!}</p>

                <p><i class="fas fa-clock"></i> From {{$task->start_date}} to {{$task->end_date}} <br> <i class="fas fa-user"></i> {{$task->user->name}}</p>

                @if($task->taskUsers->count() > 0)
                <span class="text-success">Other user on this task</span><br>
                    @foreach($task->taskUsers as $taskuser) 
                    <i class="fas fa-user"></i> {{$taskuser->user->name}}                     
                    @endforeach
                @endif
                <p class="text text-danger"><i class="fas fa-battery-half"></i> {{$task->status($task->id)}}</p>
                <a href="{{route('tasks.show',$task->id)}}" class="badge badge-success p-1"><i class="fas fa-show"></i> View tasks</a>              
                     
            </div>  
            <hr>
            @endforeach          
        </div>
    </div>

    @include('layouts.add_task')
 
</div>
@endsection

@section('styles')
<style>
    .card .card-body .task{
      border-style: solid;
      border-color: green;
      border-width: 1px 1px 1px 1px;
      border-radius: 7px;
      padding: 5px;
    }
</style>
@endsection
