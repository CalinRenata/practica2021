@extends('layout.main')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body">


                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                    <h3>{{$nrboards}}</h3>
                                <p>{{$user->role === \App\Models\User::ROLE_ADMIN ? 'Boards created' : 'Boards available' }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{route('boards.all')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$tasks}}</h3>
                                <p>{{$user->role === \App\Models\User::ROLE_ADMIN ? 'Tasks created' : 'Tasks assigned' }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">&nbsp;</a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$nruser}}</h3>
                                <p>Users </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            @if($user->role === \App\Models\User::ROLE_ADMIN)
                            <a href="{{route('users.all')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="#" class="small-box-footer">&nbsp;</a>
                            @endif
                        </div>
                    </div>

                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$nradmin}}</h3>

                                <p>Admins</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            @if($user->role === \App\Models\User::ROLE_ADMIN)
                                <a href="{{route('users.all')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            @else
                                <a href="#" class="small-box-footer">&nbsp;</a>
                            @endif
                        </div>
                    </div>
                    <!-- ./col -->
                </div>


            </div>
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
