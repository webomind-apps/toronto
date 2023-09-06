@extends('Backend.Admin.Layout.app')
@push('style')

@endpush
@section('main')
    <div class="page-title">
        <div class="title_left">

        </div>
    </div>
    <div class="clearfix"></div>


@endsection

@push('scripts')
    <script src="{{ asset('admin/js/page_user.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".module-title").text("User Details");
        });
    </script>
@endpush
