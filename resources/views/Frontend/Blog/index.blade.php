@extends('Frontend.Layout.app')

@push('style')
    <style>

    </style>
@endpush

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')
    <main id="main" class="site-main contact-main">
        <div class="site-content site-contact" style="margin-top:18%;">
            <h1 class="text-center mb-5">Blogs</h1>
            <div class="container">
                <div class="row">
                    @foreach ($blogs as $blog)
                        <div class="col-md-3">
                            <div class="blog-style1 h-100">
                                <div class="blog-img">
                                    <img class="w-100 blog-image" src="{{ asset($blog->image) }}" alt="" style="height:180px;">
                                </div>
                                <div class="blog-content">
                                    <p class="date">{{ $blog->created_at->format('d-F-Y') }}</p>
                                    <h4 class="title mt-1">
                                        <a href="{{ route('blog.details', $blog->slug) }}">{{ $blog->title }}</a>
                                    </h4>
                                    <p class="text mb-0">{{$blog->meta_description}}</p>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="featured-parts rounded m-t-30">
                            <div class="featured-img">
                                <a href="{{ route('blog.details', $blog->slug) }}" title="">
                                    <img src="{{ asset($blog->image) }}" alt="">
                                </a>
                                <div class="featured-new">
                                    <a href="#"> {{ $blog->created_at->format('d-F-Y') }} </a>
                                </div>
                            </div>
                            <div class="featured-text">
                                <div class="text-top d-flex justify-content-between">
                                    <div class="heading">
                                        <a href="{{ route('blog.details', $blog->slug) }}" title="">
                                            {{ $blog->title }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </main>
    <style>
        .blog-style1 {
            background-color: #ffffff;
            border-radius: 10px;
            -webkit-box-shadow: 0px 6px 15px rgba(64, 79, 104, 0.05);
            -moz-box-shadow: 0px 6px 15px rgba(64, 79, 104, 0.05);
            -o-box-shadow: 0px 6px 15px rgba(64, 79, 104, 0.05);
            box-shadow: 0px 6px 15px rgba(64, 79, 104, 0.05);
            margin-bottom: 30px;
            position: relative;
            -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            -ms-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            transition: all 0.4s ease;
        }

        .blog-content h4.title {
            font-size: 22px;
            font-weight: 500;
        }

        .blog-content:hover h4.title a {
            color: #c2272d;
        }

        .blog-image {
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
        }

        .blog-style1 .blog-content {
            padding: 20px 30px;
            position: relative;
            padding-bottom: 30px
        }

        .blog-style1 .date {
            color: var(--body-text-color);
            font-family: var(--title-font-family);
            font-weight: 400;
            font-size: 14px;
            color: #c2272d;
        }
    </style>
@endsection
