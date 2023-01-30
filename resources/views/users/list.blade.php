@extends('layouts.app')

@section('content')
<div class="container">
<div>
    <span style="font-size: 25px;">{{$title}}</span>
    <span>
        @if(Auth::user()->user_type == "admin")
        <button style="float: right;" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
            New user
        </button>
        <hr>
        @endif
    </span>
</div>
     
    <hr>         
    <div class="card">
        <div class="card-body"> 
            @foreach($users as $user)            
            <div class="task">
                <a style="text-decoration:none;" href="{{route('users.show',$user->id)}}">
                <p>{{$user->name}}</p>
                <span class="text-muted">{!! $user->email !!}</span>
                <span class="text-muted"><i class="fas fa-user"></i> {!! $user->user_type !!}</span>
                <i class="fas fa-book-reader"></i> Activities</a><br>
                @if($user->created_at != $user->updated_at)
                   <span class="text-success"><i class="fas fa-clock"></i> Activated on {{$user->updated_at}}</span>
                @endif
            </div>
            <hr>
            @endforeach            
         </div>
    </div> 


    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content"> 

                <div class="modal-header">
                    <h4 class="modal-title">New user</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <form action="{{route('users.store')}}" method="POST">
                        @csrf 
                        
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control">

                        <label for="title">Email</label>
                        <input type="email" name="email" class="form-control"> 


                        <label for="user_type">User type</label>
                        <select name="user_type" id="user_type" class="form-control">
                            @foreach($user_type as $type)
                                <option value="{{$type}}">{{$type}}</option>
                            @endforeach
                        </select>

                        <hr>
                        <button class="btn btn-success" type="submit">Save</button>
                    </form>                    
                </div>         
            </div>
        </div>
    </div>
</div>
@endsection

 
