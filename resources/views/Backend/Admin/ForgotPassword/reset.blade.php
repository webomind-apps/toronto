@extends('Backend.Layout.app-login')

@section('main')
    <div>
        <div class="login_wrapper">
            <div class="animate form login_form">
                <img src="{{ asset('assets/images/assets/logo.png') }}" class="img-fluid">
                <section class="login_content">
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        <h1>Admin Password Reset</h1>

                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        @if ($errors->has('token'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('token') }}</strong>
                            </span>
                        @endif

                        <div>
                            <input type="email" class="form-control" name="email" placeholder="{{ __('Email') }}"
                                required="" value="{{ $request->email ?? old('email') }}" />
                        </div>

                        @if ($errors->has('email'))
                            <p style="color:red;">{{ $errors->first('email') }}</p>
                        @endif

                        <div class="position-relative">
                            <i class="fa fa-eye password-eye"></i>
                            <input type="password" class="form-control" name="password"
                                placeholder="{{ __('Password') }}" required="" />
                        </div>
                        @if ($errors->has('password'))
                            <p style="color:red;">{{ $errors->first('password') }}</p>
                        @endif

                        <div class="position-relative">
                            <i class="fa fa-eye password-eye"></i>
                            <input type="password" class="form-control" name="password_confirmation"
                                placeholder="{{ __('Confirmation Password') }}" required="" />
                        </div>

                        <div class="text-right">
                            <a href="{{ route('admin.login') }}">Login</a>
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
