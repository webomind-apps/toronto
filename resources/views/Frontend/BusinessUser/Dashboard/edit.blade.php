@extends('Frontend.Layout.app')

@push('style')
    <style>
        .form-controller {
            height: 40px;
            width: 350px;
        }

    </style>
@endpush

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')
    <section class="package_page account mb-5" style="margin-top:300px;">
        <div class="container">
            <div class="row">
                @include('Frontend.BusinessUser.Dashboard.menu')
                <div class="col-md-9 bg-lg-grey">
                    <h3>Edit Profile</h3>
                    <form action="{{ route('business.user.profile.update', $user) }}" method="post">
                        @method('put')
                        @csrf
                        <table class="w-100 mt-5">
                            <tr>
                                <th>First Name</th>
                                <td>: <input type="text" class="form-controller" placeholder="First Name" name="fname"
                                        value="{{ $user->fname }}" required />
                                    @if ($errors->has('fname'))
                                        <p style="color:red;">{{ $errors->first('fname') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>: <input type="text" class="form-controller" placeholder="Last Name" name="lname"
                                        value="{{ $user->lname }}" required />
                                    @if ($errors->has('lname'))
                                        <p style="color:red;">{{ $errors->first('lname') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Email ID</th>
                                <td>: <input type="email" class="form-controller" placeholder="Email Address"
                                        name="email" value="{{ $user->email }}" required />
                                    @if ($errors->has('email'))
                                        <p style="color:red;">{{ $errors->first('email') }}</p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile</th>
                                <td>: <input type="text" class="form-controller phone"
                                        placeholder="Mobile Number (444-444-4444)" id="user_mobile" name="phone"
                                        value="{{ $user->phone }}" required minlength="10" maxlength="14" />
                                    @if ($errors->has('phone'))
                                        <p style="color:red;">{{ $errors->first('phone') }}</p>
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div class="col-lg-6 mt-3">
                            <div class="row">
                                <div class="col-sm-6">
                                    <button class="btn btn-danger">Remove Account</button>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-info">Update Account</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    {{-- Ad --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
