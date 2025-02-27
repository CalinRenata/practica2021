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
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
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
                <h3 class="card-title">Boards list</h3>
                <button class="btn btn-sm btn-primary"
                        type="button"
                        data-board="{{json_encode($boards)}}"
                        data-toggle="modal"
                        data-target="#boardCreateModal" style="margin-left: 1000px">
                    <i>Create board</i></button>
            </div>
            @if (session('success'))
                <div class="alert alert-success" role="alert">{{session('success')}}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{session('error')}}</div>
            @endif
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>User</th>
                        <th>Members</th>
                        <th style="width: 40px">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($boards as $board)
                        <tr>
                            <td>{{$board->id}}</td>
                            <td>
                                <a href="{{route('board.view', ['id' => $board->id])}}" class="link">{{$board->name}}</a>
                            </td>
                            <td>{{$board->user->name}}</td>
                            <td>
                                {{count($board->boardUsers)}}
                            </td>
                            <td>
                                @if ($board->user->id === \Illuminate\Support\Facades\Auth::user()->id || \Illuminate\Support\Facades\Auth::user()->role === \App\Models\User::ROLE_ADMIN)
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary"
                                                type="button"
                                                data-board="{{json_encode($board)}}"
                                                data-toggle="modal"
                                                data-target="#boardEditModal">
                                            <i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger"
                                                type="button"
                                                data-board="{{json_encode($board)}}"
                                                data-toggle="modal"
                                                data-target="#boardDeleteModal">
                                            <i class="fas fa-trash"></i></button>
                                    </div>
                                @else
                                    <p>No actions available</p>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                    @if ($boards->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{$boards->previousPageUrl()}}">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="{{$boards->url(1)}}">1</a></li>
                    @endif

                    @if ($boards->currentPage() > 3)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif
                    @if ($boards->currentPage() >= 3)
                        <li class="page-item"><a class="page-link" href="{{$boards->url($boards->currentPage() - 1)}}">{{$boards->currentPage() - 1}}</a></li>
                    @endif

                    <li class="page-item"><span class="page-link page-active">{{$boards->currentPage()}}</span></li>

                    @if ($boards->currentPage() <= $boards->lastPage() - 2)
                        <li class="page-item"><a class="page-link" href="{{$boards->url($boards->currentPage() + 1)}}">{{$boards->currentPage() + 1}}</a></li>
                    @endif

                    @if ($boards->currentPage() < $boards->lastPage() - 2)
                        <li class="page-item"><span class="page-link page-active">...</span></li>
                    @endif

                    @if ($boards->currentPage() < $boards->lastPage() )
                        <li class="page-item"><a class="page-link" href="{{$boards->url($boards->lastPage())}}">{{$boards->lastPage()}}</a></li>
                        <li class="page-item"><a class="page-link" href="{{$boards->nextPageUrl()}}">&raquo;</a></li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- /.card -->
        <div class="modal fade" id="boardCreateModal">
            <div class="modal-dialog">
                <form action="{{route('boards.create')}}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Create user</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if ($errors->has('name'))
                                <div class="alert alert-danger">{{$errors->first('name')}}</div> @endif
                            <div class="form-group">
                                <label for="boardCreateName">Name</label>
                                <input type="text" name="name" id="boardCreateName" class="form-control @if ($errors->has('name')) is-invalid @endif" />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create board</button>
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="boardEditModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="boardEditAlert"></div>
                        <input type="hidden" id="boardEditId" value="" />
                        <div class="form-group">
                            <label for="boardEditName">Name</label>
                            <input type="text" class="form-control" id="boardEditName" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="boardEditUsers">Board Users</label>
                            <select class="select2bs4" multiple="multiple" data-placeholder="Select board users" id="boardEditUsers" style="width: 100%;">
                                @foreach ($userList as $user)
                                    <option value="{{$user['id']}}">{{$user['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="boardEditButton">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="boardDeleteModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete board</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger hidden" id="boardDeleteAlert"></div>
                        <input type="hidden" id="boardDeleteId" value="" />
                        <p>Are you sure you want to delete: <span id="boardDeleteName"></span>?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" id="boardDeleteButton">Delete</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </section>
    <!-- /.content -->
@endsection
