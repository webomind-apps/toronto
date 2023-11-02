@extends('Frontend.Layout.app')

@push('style')
    <style>

    </style>
@endpush

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')

    <main id="main" class="site-main contact-main" >

        <div class="site-content site-contact" style="margin-top:18%;">
            <h1 class="text-center">Contact Us</h1>
            <div class="container">

                <div class="row">

                    <div class="col-md-6">

                        <div class="contact-text">

                            <h2>{{__('Our Offices')}}</h2>

                            <div class="contact-box">

                                <h3>{{__('London (HQ)')}}</h3>

                                <p>{{__('Unit TAP.E, 80 Long Lane, London, SE1 4GT')}}</p>

                                <p>{{__('+44 (0)34 5312 3505')}}</p>

                                <a href="#" title="Get Direction">{{__('Get Direction')}}</a>

                            </div>

                            <div class="contact-box">

                                <h3>{{__('Paris')}}</h3>

                                <p>{{__('Station F, 2 Parvis Alan Turing, 8742, Paris France')}}</p>

                                <p>{{__('+44 (0)34 5312 3505')}}</p>

                                <a href="#" title="{{__('Get Direction')}}">{{__('Get Direction')}}</a>

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="contact-form">

                            <h2>{{__('Get in touch with us')}}</h2>

                            <form action="{{route('contact.submit')}}" method="POST" class="form-underline">

                                @csrf

                                <div class="field-inline">

                                    <div class="field-input">

                                        <input type="text" class="name" name="fname" placeholder="{{__('First name')}} *" required>

                                    </div>

                                    <div class="field-input">

                                        <input type="text" class="name" name="lname" placeholder="{{__('Last name')}} *" required>

                                    </div>

                                </div>

                                <div class="field-input emailRow">

                                    <input type="email" class="email" name="email" placeholder="{{__('Email')}} *" required>
                                    <div class="field-error emailErr" >Invalid email address</div>
                                </div>

                                <div class="field-input">

                                    <input type="tel" class="phone" name="phone" placeholder="{{__('Phone number (444-444-4444)')}} *" required>
                                </div>

                                <div class="field-textarea">

                                    <textarea name="message" placeholder="{{__('Message')}} *" required></textarea>

                                </div>

                                <div class="field-submit">

                                    <input type="submit" value="{{__('Send Message')}}" class="btn">

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $(".name").keypress(function(e) {
                if (e.which == 32) {
                    return true;
                } else if (e.which > 31 && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which >
                        122) || e.which == 13) {
                    return false;
                }
                if ($(this).val().length > 30) {
                    return false;
                }
            });

            $(".email").change(function() {
                email = $(this).val();
                emailErr = $(this).parents('.emailRow').find(".emailErr");
                pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                if (!pattern.test(email)) {
                    emailErr.css("display", "block");
                    $(this).val("");
                } else {
                    emailErr.css("display", "none");
                }
            });
        });
    </script>
@endpush
