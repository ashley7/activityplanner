@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{$title}}</h2>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
    Open new task
    </button>
    <hr>
         
    <div class="card">
        <div class="card-body"> 
            @foreach($tasks as $task)            
            <div class="task">

                <a style="text-decoration:none;" class="text-success" href="{{route('tasks.show',$task->id)}}">
                    <h5>{{$task->title}}</h5>
                </a>

                <p class="text-muted">{!! $task->description !!}</p>

                <p><i class="fas fa-clock"></i> From {{$task->start_date}} to {{$task->end_date}}</p>
                <p><i class="fas fa-user"></i> {{$task->user->name}}</p>

                @if($task->taskUsers->count() > 0)
                <span class="text-success">Other user on this task</span><br>
                    @foreach($task->taskUsers as $taskuser) 

                    <form action="{{route('user_tasks.destroy',$taskuser->id)}}" method="POST" onsubmit="return confirm('You are deleting a user from a task.'); return false;">
                        @csrf 
                        {{method_field('DELETE')}}

                        <i class="fas fa-user"></i> {{$taskuser->user->name}} 
                        @if($task->status($task->id)!="Completed")
                            <button type="submit" class="badge badge-danger"><i class="fas fa-trash"></i></button>
                        @endif
                    </form>
                    @endforeach
                @endif
                            
                <form action="{{route('tasks.destroy',$task->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Task?'); return false;">
                    @csrf 
                    {{method_field('DELETE')}}

                    @if($task->status($task->id)=="Completed")
                        <p class="text text-success"><i class="fas fa-battery-full"></i> {{$task->status($task->id)}}</p>
                    @else
                        <p class="text text-danger"><i class="fas fa-battery-half"></i> {{$task->status($task->id)}}</p>
                        <a href="#" class="badge badge-success p-1" data-toggle="modal" data-target="#adduser{{$task->id}}"><i class="fas fa-user"></i> Add users</a>
                        <a href="{{route('tasks.show',$task->id)}}" class="badge badge-success p-1"><i class="fas fa-show"></i> View activities</a>
                        @if($task->user_id == Auth::id())
                        <a href="#" class="badge badge-success p-1" data-toggle="modal" data-target="#edit_task{{$task->id}}"><i class="fas fa-edit"></i> Edit task</a>
                        <button type="submit" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</button>
                        @endif
                    @endif                    
                </form>             
            </div>


            <div class="modal" id="adduser{{$task->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add users to {{$task->title}}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">                              

                            <form action="{{route('user_tasks.store')}}" method="POST">
                                @csrf

                                <label for="users">Select users</label><br>

                                @foreach($users as $user)
                                    <input type="checkbox" name="users[]" multiple value="{{$user->id}}"> {{$user->name}}
                                    <hr>
                                @endforeach       
                                
                                <input type="hidden" name="task_id" value="{{$task->id}}">
                                    
                                <hr>
                                <button class="btn btn-success" type="submit">Save changes</button>
                            </form>

                                                  
                        </div>         
                    </div>
                </div>
            </div>


            <div class="modal" id="edit_task{{$task->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit {{$task->title}}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">                              

                                <form action="{{route('tasks.update',$task->id)}}" method="POST">
                                @csrf
                                {{method_field('PATCH')}}
                                    <label for="title">Title</label>
                                    <input type="text" name="title" value="{{$task->title}}" class="form-control">

                                    <label for="description">Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="5">{!! $task->description !!}</textarea>

                                    <label for="start_date">Start date</label>
                                    <input type="date" name="start_date" value="{{$task->start_date}}" class="form-control">

                                    <label for="end_date">End date</label>
                                    <input type="date" name="end_date" value="{{$task->end_date}}" class="form-control">

                                    <hr>
                                    <button class="btn btn-success" type="submit">Save changes</button>
                                </form>

                                                  
                        </div>         
                    </div>
                </div>
            </div>

            <hr>


            @endforeach            
            {{$tasks->links()}}
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
