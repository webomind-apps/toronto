<section class="listing_section" id="map-view">
    <div class="row">
        <div class="col-lg-3 d-md-block d-none pr-0">
            <div class="left-listing px-3 py-3">
                <div class="left-listing-heding">
                    @include('Frontend.Listing.Map.map-heading')
                </div>
                <div class="left-listing-items">

                    @forelse ($businesses as $business)
                        @include('Frontend.Listing.Map.map-list', ['item' => $business])
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
        <div class="col-lg-9 p-0">
            <div id="map" class="mapview-map"></div>
        </div>
    </div>
</section>

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
                $mapPlace
            ]);

            if($center == null) $center = [$mapPlace->lat, $mapPlace->lng];
        @endphp
    @endif
@endforeach

@if ($center == null)
    @php
        $center = [12.972442, 77.580643];
    @endphp
@endif

@push('scripts')
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBeEeKz4H-KQTFABe1UTs9h5KUlpqsZ10Q&callback=initMap&libraries=&v=weekly" defer ></script>
    <script>
        var items = <?=  json_encode($markers) ?>;

        // content
        function markerContent(marker, infowindow){
            marker.addListener("click", () => {
                infowindow.open({
                    anchor: marker,
                    map,
                    shouldFocus: false,
                });
            });
        }

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


        // set marker
        function setMarkers(map) {
            for (let i = 0; i < items.length; i++) {
                const item = items[i];
                const marker = new google.maps.Marker({
                    position: { lat: parseFloat(item[1]), lng: parseFloat(item[2]) },
                    map,
                    label: item[3].toString(),
                    animation: google.maps.Animation.DROP,
                    title: item[0],
                    zIndex: item[3],
                });
                console.log(item[4]);
                var contentString =
                    '<div id="content" class="map-marker-item">' +
                        '<div id="siteNotice mr-3"></div>'+
                        '<div>'+
                            '<h6><a class="itemName mb-2" >'+ item[4]['name'] +'</a></h6>'+
                            '<div class="address text-truncate">'+ item[4]['address'] +'</div>'+
                            '<div class="moreDescription">'+ item[4]['description'] +'</div>'+
                        '</div>'+
                    '</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString,
                    maxWidth: 350,
                });

                markerContent(marker,infowindow)

            }
        }



 </script>

@endpush
