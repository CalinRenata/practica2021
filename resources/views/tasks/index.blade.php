@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tasks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Boards</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tasks Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Assignment</th>
                        <th>Status</th>
                        <th>Creation date</th>
                        <th>Board</th>
                        <th style="width: 40px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{$task->id}}</td>
                            <td>{{$task->name}}</td>
                            <td>{{$task->description}}</td>
                            <td>{{$task->assignment}}</td>
                            <td>
                                @if($task->status === \App\Models\Task::STATUS_CREATED)
                                    <span class="badge bg-default">{{ 'Created' }}</span>
                                @elseif ($task->status === \App\Models\Task::STATUS_IN_PROGRESS)
                                    <span class="badge bg-primary">  {{'Progress'}}</span>
                                @else
                                    <span class="badge bg-success">  {{'Done'}}</span>
                                @endif
                            </td>
                            <td>{{date('d-m-Y', strtotime($task->created_at))}}</td>
                            <td>{{$task->board()->first()->name}}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-xs btn-primary" type="button"
                                            data-user="{{json_encode($task)}}" data-toggle="modal"
                                            data-target="#edit-modal">
                                        <i class="fas fa-edit"></i></button>
                                @if(\Illuminate\Support\Facades\Auth::user()->role === \App\Models\User::ROLE_ADMIN ) <!-- || \Illuminate\Support\Facades\Auth::user()->id === $task->board()->users()->first()->id) -->
                                    <button class="btn btn-xs btn-danger" type="button"
                                            data-user="{{json_encode($task)}}" data-toggle="modal"
                                            data-target="#delete-modal">
                                        <i class="fas fa-trash"></i></button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    @if ($tasks->currentPage() >= 1)
                        <li class="page-item"><a class="page-link" href="{{$tasks->previousPageUrl()}}">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->url(1)}}">1</a></li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->url(2)}}">2</a></li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->nextPageUrl()}}">...</a></li>
                    @endif

                    @if ($tasks->currentPage() < $tasks->lastPage() )
                        <li class="page-item"><a class="page-link"
                                                 href="{{$tasks->url($tasks->lastPage())}}">{{$tasks->lastPage()}}</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="{{$tasks->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog">
                <form action="" method="POST" id="edit-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit task</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="editId" value=""/>
                            <div class="form-group">
                                <label for="editName">Name</label>
                                <div id="editName"><input name="name" id="editName" value=""/></div>
                            </div>
                            <div class="form-group">
                                <label for="editDescription">Description</label>
                                <div id="editDescription"><input name="name" id="editDescription" value=""/></div>
                            </div>
                            <div class="form-group">
                                <label for="editAssignment">Assignment</label>
                                <div id="editAssignment"><input name="name" id="editAssignment" value=""/></div>
                            </div>
                            <div class="form-group">
                                <label for="editStatus">Status</label>
                                <div id="editStatus"><input name="name" id="editDescription" value=""/></div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
        </div>
        <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog">
                <form action="" method="POST" id="delete-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Delete user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div id="deleteName"></div>
                            <input type="hidden" name="deleteId" value=""/>
                            <p>Are you sure you want to delete the task?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No !</button>
                            <button type="submit" class="btn btn-danger">Yes, delete!</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
@endsection
