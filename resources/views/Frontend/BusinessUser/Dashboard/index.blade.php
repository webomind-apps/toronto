@extends('Frontend.Layout.app')

@section('main')

@include('Frontend.Layout.search-layout')

    <section class="package_page account mb-5" style="margin-top:300px;">
        <div class="container">
            <div class="row">
                @include('Frontend.BusinessUser.Dashboard.menu')
                <div class="col-md-9 bg-lg-grey">
                    <h3>Profile</h3>

                    <table class="w-100 mt-5">
                        <tr>
                            <th>Customer Id</th>
                            <td>: {{user()->ref_id??""}}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>: {{user()->fname??""}} {{user()->lname??""}}</td>
                        </tr>
                        <tr>
                            <th>Email ID</th>
                            <td>: {{user()->email??""}}</td>
                        </tr>
                        <tr>
                            <th>Mobile</th>
                            <td>: {{user()->phone??""}}</td>
                        </tr>
                        <tr>
                            <th>Password</th>
                            <td>: {{user()->show_password??""}}</td>
                        </tr>
                    </table>

                    <div class="col-lg-6 mt-3">
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="btn btn-danger">Remove Account</button>
                            </div>
                            <div class="col-sm-6">
                                <a href="{{route('business.user.profile.edit',user())}}">
                                   <button class="btn btn-info">Edit Account</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection





