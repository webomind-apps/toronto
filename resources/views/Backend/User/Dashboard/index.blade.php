@extends('Backend.User.Layout.app')
<style>


</style>
@section('main')

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("Dashboard");
        });
    </script>
@endpush
