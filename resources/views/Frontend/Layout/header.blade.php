<div class="topbar">
    <!-- Header  -->
    <div class="header ">
        <div class="container po-relative">
            <nav class="navbar navbar-expand-lg hover-dropdown header-nav-bar">
                <a title="Logo" href="{{ route('home.index') }}" class="navbar-brand">
                    <img src="{{ asset('assets/images/assets/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#h5-info"
                    aria-expanded="false" aria-label="Toggle navigation"><i class="fa fa-bars"></i></button>
                <div class="collapse navbar-collapse" id="h5-info">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.index') }}"> Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home.blogs') }}"> Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('advertise.with.us') }}">Advertise with Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact.us') }}">Contact Us </a>
                        </li>
                    </ul>
                    <div class="header_r d-flex @guest nopadding @endguest">

                        @if (Auth::guard('user')->check() || Auth::guard('business_user')->check())
                            @php
                                if (Auth::guard('business_user')->check()) {
                                    $auth = Auth::guard('business_user')->user();
                                } elseif (Auth::guard('user')->check()) {
                                    $auth = Auth::guard('user')->user();
                                }
                            @endphp
                            <div class="dropdown avatar-user mr-2">
                                <a class="dropdown-toggle nav-link" title="{{ $auth->name }}" type="button"
                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <div class="avatar-box">
                                        <span class="userAlterImg">{{ $auth->fname[0] }}</span>
                                    </div>
                                    <span>
                                        {{ $auth->name }}
                                    </span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                        href="
                                          @if (Auth::guard('business_user')->check()) {{ route('business.user.profile') }}
                                    @elseif(Auth::guard('user')->check())
                                        {{ route('user.dashboard') }} @endif

                        ">{{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="javascript:void(0)"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                    <form class="d-none" id="logout-form"
                                        action="
                             @if (Auth::guard('business_user')->check()) {{ route('business.user.logout') }}
                        @elseif(Auth::guard('user')->check())
                            {{ route('user.logout') }} @endif
                            "
                                        method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="post_ad dropdown" style="padding: 5px;">
                                <a class="nav-link dropdown-toggle" id="sdfdsf" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" href="#">Registration</a>
                                <div class="dropdown-menu" aria-labelledby="sdfdsf">
                                    <a class="dropdown-item"
                                        href="{{ route('registration.step1') }}">{{ __('Business Registration') }}</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                        data-target="#business-user-register">{{ __('User Registration') }}</a>
                                </div>
                            </div>

                            <div class="post_ad dropdown" style="padding: 5px;">
                                <a class="nav-link dropdown-toggle" id="sdfsadfdsf" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false" href="#">Login</a>
                                <div class="dropdown-menu" aria-labelledby="sdfsadfdsf">
                                    <a class="dropdown-item loginClick businessLoginClick" data-toggle="modal"
                                        data-target="#user-login">{{ __('Business Login') }}</a>
                                    <a class="dropdown-item loginClick userLoginClick" data-toggle="modal"
                                        data-target="#business-user-login">{{ __('User Login') }}</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="business-user-login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login to Toronto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true"><img src="{{ asset('webo/images/close.png') }}" alt="desi-con Plus"></span>
                </button>
            </div>
            <div class="modal-body">
                @if (session('business-user-error'))
                    <span class="text-danger" role="alert">
                        <small>{{ session('business-user-error') }}</small>
                    </span>
                @endif
                <form action="{{ route('business.user.login') }}" class="form-log form-content" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <small class="form-text text-danger d-none" id="login_otp_error">error!</small>
                            <div class="form-group has-feedback">
                                <input type="text" id="email" name="email" class="form-control"
                                    name="email" placeholder="Email Address" required>
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group has-feedback">
                                <i class="fa fa-eye password-eye"></i>
                                <input type="password" class="form-control password mt-10" id="password"
                                    name="password" placeholder="Password" required>
                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="buttons login_btn" type="submit" id="" name="login">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="form-info">
                        <div class="md-checkbox">
                        </div>
                        <div class="forgot-password forgotClick">
                            <a href="{{ route('business.user.password.request') }}">{{ __('Forgot password') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="user-login" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Login to Toronto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true"><img src="{{ asset('webo/images/close.png') }}"
                            alt="desi-con Plus"></span> </button>
            </div>
            <div class="modal-body">

                @if (session('user-error'))
                    <span class="text-danger" role="alert">
                        <small>{{ session('user-error') }}</small>
                    </span>
                @endif
                <form action="{{ route('user.login') }}" class="form-log form-content" method="POST">
                    @csrf
                    @if (session('error'))
                        <span class="text-danger" role="alert">
                            <small>{{ session('error') }}</small>
                        </span>
                    @endif
                    <div class="row">
                        <div class="col-sm-12">
                            <small class="form-text text-danger d-none" id="login_otp_error">error!</small>
                            <div class="form-group has-feedback">
                                <input type="text" id="email" name="email" class="form-control"
                                    name="email" placeholder="Email Address" required>
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group has-feedback">
                                <i class="fa fa-eye password-eye"></i>
                                <input type="password" class="form-control password mt-10" id="password"
                                    name="password" placeholder="Password" required>
                                @error('password')
                                    <span class="text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="buttons login_btn" type="submit" id="" name="login">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="form-info">
                        <div class="md-checkbox">
                        </div>
                        <div class="forgot-password forgotClick">
                            <a href="{{ route('user.password.request') }}">{{ __('Forgot password') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="business-user-register" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Registration</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span
                        aria-hidden="true"><img src="{{ asset('webo/images/close.png') }}"
                            alt="desi-con Plus"></span> </button>
            </div>
            <div class="modal-body">
                <form class="form-sign form-content" id="register"
                    action="{{ route('business.user.registration') }}" method="post">
                    <div class="row">
                        <div class="col-sm-12">
                            @csrf
                            <small class="form-text text-danger d-none" id="register_error">error!</small>

                            <div class="form-group has-feedback">
                                <input type="text" class="form-control name" name="fname"
                                    placeholder="First Name" value="{{ old('fname') }}" required>
                                @if ($errors->has('fname'))
                                    <p style="color:red;">
                                        {{ $errors->first('fname') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control name" name="lname"
                                    placeholder="Last Name" value="{{ old('lname') }}" required>
                                @if ($errors->has('lname'))
                                    <p style="color:red;">
                                        {{ $errors->first('lname') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group has-feedback">

                                <input type="email" class="form-control email-unique" name="email"
                                    placeholder="Email" value="{{ old('email') }}" data-field="email"
                                    data-table="business_users" required>
                                @if ($errors->has('email'))
                                    <p style="color:red;">
                                        {{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group has-feedback">

                                <input type="text" class="form-control phone" name="phone"
                                    placeholder="Mobile (444-444-4444)" value="{{ old('phone') }}" minlength="10"
                                    maxlength="12" required>
                                @if ($errors->has('phone'))
                                    <p style="color:red;">
                                        {{ $errors->first('phone') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group has-feedback passDiv">
                                <i class="fa fa-eye password-eye"></i>
                                <input type="password" class="form-control" id="register_password" name="password"
                                    placeholder="Password" required>
                                @if ($errors->has('password'))
                                    <p style="color:red;">
                                        {{ $errors->first('password') }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group has-feedback passDiv">
                                <i class="fa fa-eye password-eye"></i>
                                <input type="password" class="form-control" id="register_password_confirmation"
                                    name="password_confirmation" placeholder="Confirm Password" required>
                                @if ($errors->has('password_confirmation'))
                                    <p style="color:red;">
                                        {{ $errors->first('password_confirmation') }}</p>
                                @endif

                            </div>
                        </div>

                    </div>

                    <div class="form-group">
                        <button type="submit" class="buttons login_btn" name="login" value="Login"
                            id="submit_register">{{ __('Sign Up') }}
                        </button>
                    </div>

                </form>


            </div>
            <div class="register text-center">Already a member? <a href="#">Login</a></div>
        </div>
    </div>
</div>

@push('scripts')
    @error('business-user-error')
        <script>
            $(document).ready(function() {
                $("#business-user-login").modal("show");
            });
        </script>
    @enderror

    @if (session('user-error'))
        <script>
            $(document).ready(function() {
                $("#user-login").modal("show");
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {
            $("#register_password_confirmation").change(function(e) {
                $(this).parent('div').find('.conPassErr').remove();
                if ($("#register_password").val() != $(this).val()) {
                    $(this).parent("div").append(
                        '<div style="color:red" class="conPassErr" >Password and confirmation password is wrong</div>'
                    );
                    $(this).val("");
                }
            });
        });
    </script>


    {{-- gio location --}}
    <script>
        // get Geolocation cookie
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return null;
        }

        // Delte cookie
        function delete_cookie(name) {
            document.cookie = name + '=';
        }

        // success callback
        const successCallback = (position) => {
            let tempo = position.coords.latitude + '|' + position.coords.latitude;
            document.cookie = 'geolocation=' + tempo;
            window.location.reload();
        }

        // Error callback
        const errorCallback = (err) => {
            console.error(err);
            delete_cookie('geolocation');
        }

        // int geolocation
        $(function() {
            if (getCookie('geolocation') == null) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback, {
                    enableHighAccuracy: true
                })
            }
        });
    </script>
@endpush
