@extends('Backend.Admin.Layout.app')

@section('main')

<div class="page-title">
    <div class="title_left">
    </div>
    <div class="title_right">
        <div class="pull-right">

        </div>
    </div>
</div>
<div class="clearfix"></div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <table class="table table-striped table-bordered golo-datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Country</th>
                            <th>Province</th>
                            <th>City</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($cities as $key => $city)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$city->country->name ?? ""}}</td>
                            <td>{{$city->province->name ?? ""}}</td>
                            <td>{{$city->name ?? ""}}</td>
                            <td>
                                <form action={{route("admin.city.status")}} method="post">
                                @csrf
                                @method("put")
                                <input type="checkbox" class="js-switch" name="status"
                                    data-id="{{$city->id}}" {{(($city->status == 1)?"checked":"")}} onchange="this.form.submit();"/>
                                <input type="hidden" name="id" value={{$city->id}}/>
                                <input type="hidden" name="status" value={{$city->status}}/>
                                </form>
                            </td>
                            <td>
                                <a href="{{route("admin.city.edit",$city)}}"><button type="button" class="btn btn-warning btn-xs">Edit
                                </button></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $(".module-title").text("Cities");
    $(".top-add-button").html('<a href="{{route("admin.city.create")}}"><button class="btn btn-primary" type="button">+ Add New</button></a>');
});
</script>
@endpush
