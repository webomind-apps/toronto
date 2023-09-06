@extends('Backend.Layout.app-login')

@section('main')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <img src="{{ asset('assets/images/assets/logo.png') }}" class="img-fluid">
                <section class="login_content">
                    <form action="{{ route('user.password.email') }}" method="POST">
                        @csrf
                        <h1>User Forgot Password</h1>

                        @if (session('error'))
                            <span class="text-danger" role="alert">
                                <small>{{ session('error') }}</small>
                            </span>
                        @endif

                        @if (session('status'))
                        <span class="text-success" role="alert">
                            <small>{{ session('status') }}</small>
                        </span>
                        @endif

                        @error('email')
                            <span class="text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror

                        <div>
                            <input type="text" class="form-control" name="email" placeholder="{{ __('Email') }}"
                                required="" />
                        </div>

                        <div class="text-right">
                            <a href="{{route("home.index")}}">Login</a>
                        </div>

                        <div>
                            <button class="btn btn-primary" id="submit_login">{{ __('Submit') }}</button>
                        </div>
                        <div class="clearfix"></div>
                    </form>

                    <div class="separator">
                        <div>
                            <p>{{ __('© 2021 All Rights Reserved.') }}</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
