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
                            <th>Image</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($paymentMethods as $key => $paymentMethod)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <img class="place_list_thumb" src="{{ asset('storage/'.$paymentMethod->image) }}"
                                    alt="Payment Logo">
                            </td>
                            <td>{{$paymentMethod->name}}</td>
                            <td>
                                <form action={{route("admin.paymentMethod.status")}} method="post">
                                @csrf
                                @method("put")
                                <input type="checkbox" class="js-switch" name="status"
                                    data-id="{{$paymentMethod->id}}" {{(($paymentMethod->status == 1)?"checked":"")}} onchange="this.form.submit();"/>
                                <input type="hidden" name="id" value={{$paymentMethod->id}}/>
                                <input type="hidden" name="status" value={{$paymentMethod->status}}/>
                                </form>
                            </td>
                            <td>
                                <a href="{{route("admin.paymentMethod.edit",$paymentMethod)}}"><button type="button" class="btn btn-warning btn-xs">Edit
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
    $(".module-title").text("Payment Methods");
    $(".top-add-button").html('<a href="{{route("admin.paymentMethod.create")}}"><button class="btn btn-primary" type="button">+ Add New</button></a>');
});
</script>
@endpush
