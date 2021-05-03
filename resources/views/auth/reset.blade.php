@extends('base')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{route('reset-password')}}"><b>Admin</b>LTE</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>

                @if ($errors->has('reset-password'))
                    <div class="alert alert-danger">{{$errors->first('reset-password')}}</div> @endif

                <form action="{{route('reset-password')}}" method="post">
                    @csrf

                    @if ($errors->has('password'))
                        <div class="alert alert-danger">{{$errors->first('password')}}</div> @endif

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>

                    @if ($errors->has('retype_pass'))
                        <div class="alert alert-danger">{{$errors->first('retype_pass')}}</div> @endif

                    <div class="input-group mb-3">
                        <input type="password" name="retype_pass" class="form-control" placeholder="Confirm Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Change password</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="login.html">Login</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
