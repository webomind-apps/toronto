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
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($sub_categories as $key => $sub_category)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{$sub_category->category->name ?? ""}}</td>
                            <td>{{$sub_category->name ?? ""}}</td>
                            <td>
                                <form action={{route("admin.subCategory.status")}} method="post">
                                @csrf
                                @method("put")
                                <input type="checkbox" class="js-switch" name="status"
                                    data-id="{{$sub_category->id}}" {{(($sub_category->status == 1)?"checked":"")}} onchange="this.form.submit();"/>
                                <input type="hidden" name="id" value={{$sub_category->id}}/>
                                <input type="hidden" name="status" value={{$sub_category->status}}/>
                                </form>
                            </td>
                            <td>
                                <a href="{{route("admin.subCategory.edit",$sub_category)}}"><button type="button" class="btn btn-warning btn-xs">Edit
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
    $(".module-title").text("Sub Categories");
    $(".top-add-button").html('<a href="{{route("admin.subCategory.create")}}"><button class="btn btn-primary" type="button">+ Add New</button></a>');
});
</script>
@endpush
