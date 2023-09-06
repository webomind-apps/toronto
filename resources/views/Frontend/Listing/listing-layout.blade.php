@php
    $center = null;
    $markers = [];
@endphp

@foreach ($businesses as $mapPlace)
    @if ($mapPlace->lat != null && $mapPlace->lng != null)
        @php
            array_push($markers, [
                $mapPlace->name,
                $mapPlace->lat,
                $mapPlace->lng,
                $loop->iteration,
            ]);

            if($center == null){
                $center = [$mapPlace->lat, $mapPlace->lng];
            }
        @endphp
    @endif
@endforeach

@if ($center == null)
    @php
        $center = [43.651070, -79.347015];
    @endphp
@endif

 <section class="listing_section">
     <div class="container">
         <div class="col-12">
             <div class="row">
                 <div class="col-lg-9">

                     {{-- Header --}}
                     @include('Frontend.Listing.header')
                     {{-- product List --}}
                     @include('Frontend.Listing.list')
                 </div>
                 <div class="col-lg-3 pt-100">

                     <div class="right-desc mt-5">
                         <a href="{{ url()->full() }}&listing=map">
                             <div id="map" style="width:280px;height:300px;margin-top:-120px;margin-bottom:15px;" ></div>
                         </a>

                         @foreach ($advertisement300s as $advertisement)

                         <a href="{{$advertisement->link}}" target="_blank">
                             @if(!empty($advertisement->image) && file_exists(public_path('storage/'.$advertisement->image)))
                             <img src="{{ asset('storage/'.$advertisement->image) }}" class="img-fluid my-2" alt="ad banner">
                             @else
                             <img src="{{asset('defaultImg/defaultImg.png')}}" class="img-fluid my-2" alt="ad banner" />
                             @endif
                         </a>

                         @endforeach

                        @foreach ($advertisement600s as $advertisement)

                         <a href="https://{{$advertisement->link}}" target="_blank">
                             @if(!empty($advertisement->image) && file_exists(public_path('storage/'.$advertisement->image)))
                             <img src="{{ asset('storage/'.$advertisement->image) }}" class="img-fluid my-2" alt="ad banner">
                             @else
                             <img src="{{asset('defaultImg/defaultImg.png')}}" class="img-fluid my-2" alt="ad banner" />
                             @endif
                         </a>
                         @endforeach
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </section>
 @push('scripts')
 <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeEeKz4H-KQTFABe1UTs9h5KUlpqsZ10Q&callback=initMap&libraries=&v=weekly" defer ></script>
 <script>
     var arr = <?php echo json_encode($markers) ?>;
     console.log(arr);

        // init map
        function initMap() {
            setTimeout(() => {
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 10,
                    center: { lat: parseFloat('{{ $center[0] }}'), lng: parseFloat('{{ $center[1] }}') },
                });
                setMarkers(map);
            }, 2000);
        }

        const beaches = <?php echo json_encode($markers) ?>;

        // set marker
        function setMarkers(map) {
            for (let i = 0; i < beaches.length; i++) {
                const beach = beaches[i];
                new google.maps.Marker({
                    position: { lat: parseFloat(beach[1]), lng: parseFloat(beach[2]) },
                    map,
                    label: beach[3].toString(),
                    animation: google.maps.Animation.DROP,
                    // icon: {
                    //     path:
                    //     strokeColor: "blue",
                    //     scale: 1
                    // },
                    title: beach[0],
                    // zIndex: beach[3],
                });
            }
        }



 </script>
 @endpush
