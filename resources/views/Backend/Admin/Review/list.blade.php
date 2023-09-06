@extends('Backend.Admin.Layout.app')
@push('style')

@endpush
@section('main')
    <div class="page-title">
        <div class="title_left">

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                            <tr>
                                <th width="3%">ID</th>
                                <th width="15%">Business</th>
                                <th width="15%">Email</th>
                                <th width="15%">Comment</th>
                                <th width="5%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reviews as $key => $review)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $review->business->name }}</td>
                                    <td>{{ $review->email }}</td>
                                    <td>{{ $review->comment }}</td>
                                    <td>
                                        <form action={{route("admin.review.status")}} method="post">
                                        @csrf
                                        @method("put")
                                        <input type="checkbox" class="js-switch" name="status"
                                            data-id="{{$review->id}}" {{(($review->status == 1)?"checked":"")}} onchange="this.form.submit();"/>
                                        <input type="hidden" name="id" value={{$review->id}}/>
                                        <input type="hidden" name="status" value={{$review->status}}/>
                                        </form>
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
            $(".module-title").text("User");
            $(".x_panel").css("width", "auto");
        });
    </script>
@endpush
