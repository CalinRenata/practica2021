@extends('base')

@section('content')
    <div class="login-box" style="margin-right: auto; margin-left: auto; margin-top: 100px">
        <div class="login-logo">
            <a href="{{route('login')}}">Log in</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                @if ($errors->has('login'))
                    <div class="alert alert-danger">{{$errors->first('login')}}</div> @endif

                <form action="{{route('login')}}" method="post">
                    @csrf
                    @if ($errors->has('email'))
                        <div class="alert alert-danger">{{$errors->first('email')}}</div> @endif
                    <div class="input-group mb-3">
                        <input name="email" type="email"
                               class="form-control @if ($errors->has('email')) is-invalid @endif" placeholder="Email"
                               value="{{old('email')}}">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @if ($errors->has('password'))
                        <div class="alert alert-danger">{{$errors->first('password')}}</div> @endif
                    <div class="input-group mb-3">
                        <input name="password" type="password"
                               class="form-control @if ($errors->has('password')) is-invalid @endif"
                               placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-primary">
                        <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                    </a>
                    <a href="#" class="btn btn-block btn-danger">
                        <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
                    </a>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="{{route('forget-password')}}">I forgot my password</a>
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
