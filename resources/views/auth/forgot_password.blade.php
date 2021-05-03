@extends('base')

@section('content')
    <div class="login-box" style="margin-left: auto; margin-right: auto; margin-top: 100px">
        <div class="login-logo">
            <a href="{{route('forget-password')}}">Reset password</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                @if ($errors->has('forget-password'))
                    <div class="alert alert-danger">{{$errors->first('forget-password')}}</div> @endif

                <form action="{{route('forget-password')}}" method="post">
                    @csrf
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{route('login')}}">Login</a>
                </p>
                <p class="mb-0">
                    <a href="{{route('register')}}" class="text-center">New account</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
@endsection
