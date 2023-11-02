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
            <div class="mx-auto border rounded p-3" style="width: 70%;">
                <div class="container">
                    <img src="{{ asset($blog->image) }}" class="w-100" alt="">
                    <p class="date text-right my-2">{{ $blog->created_at->format('d-F-Y') }}</p>
                    <h2 style="color:#c2272d;" class="my-2">{{ $blog->title }}</h2>
                    {!! $blog->description !!}
                </div>
            </div>
        </div>
        </div>
    </main>
@endsection
