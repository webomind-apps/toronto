<div class="map-heading">
    <h4>
        @if ($search_category)
        <b>{{ $search_category }}</b>
    @elseif ($search_city)
        <b>{{ $search_city }}</b>
    @endif

    @if ($search_city && !empty($search_category))
        in <b>{{ $search_city }}</b>
    @else
        in <b>Toronto Connection ON</b>
    @endif
    </h4>
    <p class="result-count">({{$businesses->total()}} Result(s))</p>
</div>
