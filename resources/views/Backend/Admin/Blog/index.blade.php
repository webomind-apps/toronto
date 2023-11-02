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
                                <th>Thumbnail</th>
                                <th>title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($blogs as $blog)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset($blog->image) }}" alt="" style="height: 50px;"></td>
                                    <td>{{ $blog->title }}</td>
                                    <td>{{ $blog->meta_description }}</td>
                                    <td>
                                        <form action={{ route('admin.blog.status') }} method="post">
                                            @csrf
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $blog->id }}" {{ $blog->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $blog->id }} />
                                            <input type="hidden" name="status" value={{ $blog->status }} />
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.blog.edit', $blog) }}"
                                            class="btn btn-warning btn-xs">Edit</a>
                                        <form method="POST"
                                            action="{{ route('admin.blog.destroy', $blog) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs" type="submit">Delete</button>
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
            count = "{{ $blogs->count() }}";
            $(".module-title").text("Blogs");
            // if (count >= 1) {
            $(".top-add-button").html(
                '<a href="{{ route('admin.blog.create') }}"><button class="btn btn-primary" type="button">+ Add New</button></a>'
            );
            // }
        });
    </script>
@endpush
