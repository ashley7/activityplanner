@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{$title}}</h2>
    <p class="text-success"><i class="fas fa-clock"></i> From: {{$task->start_date}} to {{$task->end_date}}</p>
    <p class="text-success"><i class="fas fa-user"></i>  {{$task->user->name}}</p>
    @if($task->status($task->id)!="Completed")
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
        Add activity
    </button>
    <hr>
    @endif
    <p>{!! $task->description !!}</p>        
   
        @if($task->activities->count() == 0)
          <p class="text-danger">This task has no activities</p>
        @endif

        @foreach($task->activities as $activity)

        <div class="card">
            <div class="card-body">
            <h5>
                {{$activity->title}} 
            </h5>
                @if($activity->status=="pending")
                    <span class="text-danger">{{$activity->status}}</span>
                @elseif($activity->status=="processing")
                    <span class="text-danger">{{$activity->status}}</span>
                @elseif($activity->status=="completed")
                    <span class="text-success">{{$activity->status}}</span>
                @endif
            
            <p class="text-muted">{{$activity->description}}</p>

            @foreach($activity->attachments as $attachment)
            
            <form action="{{route('activity_files.destroy',$attachment->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this file?'); return false;">
                @csrf 
                {{method_field('DELETE')}}
                <a target="_balnk" href="{{asset('/files/'.$attachment->file_url)}}"><i class="fas fa-paperclip"></i>  {{$attachment->name}}  <i class="fas fa-user"></i> {{$attachment->user->name}}</a> 
                @if($activity->status!="completed" && $attachment->user_id == Auth::id())
                <button type="submit" class="badge badge-danger p-1"><i class="fas fa-trash"></i> </button>
                @endif
            </form>
            <br>
            @endforeach

            @if(!empty($activity->results))
                <p class="text-muted">Final remarks: {{$activity->results}}</p>
            @endif
            @if($activity->status=="completed")
            <p class="text-success">Verified:  <i class="fas fa-clock"></i> {{$activity->updated_at}}</p>
            @endif
            <hr>
            @if($activity->status!="completed")            
            <form action="{{route('task_activities.destroy',$activity->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this activity?'); return false;">
                @csrf 
                {{method_field('DELETE')}}
                <a href="#" class="badge badge-success p-1" data-toggle="modal" data-target="#addfile{{$activity->id}}"><i class="fas fa-paperclip"></i> Add files</a>
                <a href="#" class="badge badge-success p-1" data-toggle="modal" data-target="#report{{$activity->id}}"><i class="fas fa-edit"></i> Update activity</a>
                @if($activity->user_id == Auth::id())
                <button type="submit" class="badge badge-danger"><i class="fas fa-trash"></i> Delete </button>
                @endif
            </form>
            @endif
            <div class="modal" id="report{{$activity->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add final remarks to {{$activity->title}}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('task_activities.update',$activity->id)}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                {{method_field('PATCH')}}

                                <label for="title">Title</label>
                                <input type="text" name="title" value="{{$activity->title}}" class="form-control">

                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="3">{!! $activity->description !!}</textarea>

                                <label for="results">Final remarks</label>
                                <textarea name="results" id="results" class="form-control" cols="30" rows="3">{!! $activity->results !!}</textarea>
    
                                <label for="status">Activity status</label>

                                <select name="status" id="status" class="form-control">
                                    @foreach($status as $state)
                                        @if($state == $activity->status)
                                            <option selected value="{{$state}}">{{$state}}</option>
                                            @else 
                                            <option value="{{$state}}">{{$state}}</option>
                                        @endif
                                    @endforeach
                                    
                                </select>      
                                    <hr>
                                <button class="btn btn-success" type="submit">Save</button>
                            </form>                        
                        </div>         
                    </div>
                </div>
            </div>


            <div class="modal" id="addfile{{$activity->id}}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add files</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('activity_files.store')}}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <label for="name">Document name</label>
                                <input type="text" name="name" class="form-control">

                                <label for="file_url">Select file</label><br>
                                <input type="file" name="file_url">
        
                                <input type="hidden" value="{{$activity->id}}" name="task_activity_id">

                                <hr>
                                <button class="btn btn-success" type="submit">Save</button>
                            </form>                        
                        </div>         
                    </div>
                </div>
            </div>
            </div>
        </div> 

        <hr>
    

    
            @endforeach
                
           


        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content"> 

                    <div class="modal-header">
                        <h4 class="modal-title">New activity</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">

                    <form action="{{route('task_activities.store')}}" method="POST">
                        @csrf 
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control">

                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" cols="30" rows="5"></textarea>

                        <input type="hidden" value="{{$task->id}}" name="task_id">

                        <hr>
                        <button class="btn btn-success" type="submit">Save activity</button>
                    </form>
                        
                    </div>         
                </div>
            </div>
        </div>
    </div>
@endsection
