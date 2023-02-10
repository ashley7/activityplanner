<div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content"> 

                <div class="modal-header">
                    <h4 class="modal-title">Open new task</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                <form action="{{route('tasks.store')}}" method="POST">
                    @csrf 
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control">

                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"></textarea>

                    <label for="start_date">Start date</label>
                    <input type="date" name="start_date" class="form-control">

                    <label for="end_date">End date</label>
                    <input type="date" name="end_date" class="form-control">

                    <hr>
                    <button class="btn btn-success" type="submit">Save</button>
                </form>
                    
                </div>         
            </div>
        </div>
    </div>