@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Boards</h1>
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
                <h3 class="card-title">Boards Table</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>User</th>
                        <th style="width: 40px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($boards as $board)
                        @if(\Illuminate\Support\Facades\Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                            <tr>
                                <td>{{$board->id}}</td>
                                <td>{{$board->name}}</td>
                                <td>{{$board->user()->first()->name}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-xs btn-primary" type="button"
                                                data-user="{{json_encode($board)}}" data-toggle="modal"
                                                data-target="#edit-modal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-xs btn-danger" type="button"
                                                data-user="{{json_encode($board)}}" data-toggle="modal"
                                                data-target="#delete-modal">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @if($board->user_id === \Illuminate\Support\Facades\Auth::user()->id)
                                <tr>
                                    <td>{{$board->id}}</td>
                                    <td><a href="{{route('tasks.all')}}">{{$board->name}}</a></td>
                                    <td>{{$board->user()->first()->name}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs btn-primary" type="button"
                                                    data-user="{{json_encode($board)}}" data-toggle="modal"
                                                    data-target="#edit-modal">
                                                <i class="fas fa-edit"></i></button>
                                            <button class="btn btn-xs btn-danger" type="button"
                                                    data-user="{{json_encode($board)}}" data-toggle="modal"
                                                    data-target="#delete-modal">
                                                <i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    @if ($boards->currentPage() >= 1)
                        <li class="page-item"><a class="page-link" href="{{$boards->previousPageUrl()}}">&laquo;</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="{{$boards->url(1)}}">1</a></li>
                        <li class="page-item"><a class="page-link" href="{{$boards->url(2)}}">2</a></li>
                        <li class="page-item"><a class="page-link" href="{{$boards->nextPageUrl()}}">...</a></li>
                    @endif

                    @if ($boards->currentPage() < $boards->lastPage() )
                        <li class="page-item"><a class="page-link"
                                                 href="{{$boards->url($boards->lastPage())}}">{{$boards->lastPage()}}</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="{{$boards->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /.card -->

        <div class="modal fade" id="edit-modal">
            <div class="modal-dialog">
                <form action="{{ route('boards.update',$board->id) }}" method="POST" id="edit-form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit board</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="editId" value=""/>
                            <div class="form-group">
                                <label for="editRole">Name</label>
                                <div id="editName"><input name="name" id="editName" value=""/></div>
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
            <!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="delete-modal">
            <div class="modal-dialog">
                <form action="{{ route('users.destroy',$board->id) }}" method="POST" id="delete-form">
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
                            <p>Are you sure you want to delete the board?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">No !</button>
                            <button type="submit" class="btn btn-danger">Yes, delete!</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
@endsection
