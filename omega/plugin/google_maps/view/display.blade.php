@if(isset($apikey) && !empty($apikey))
    @if(isset($lat) && !empty($lat) && isset($long) && !empty($long))
    <div class="plugin plugin-googlemaps">
        <div id="{{ $uid }}_map" class="map" style="height: 400px;"></div>
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPN2x0Oe5Nu19nToBOUaAhph2sBZLHYxo&callback=initMap" type="text/javascript"></script>
        <script type="text/javascript">
            function initMap() {
                var latlng = new google.maps.LatLng({{ $lat }}, {{ $long }});
                var myOptions = {
                    zoom: 14,
                    center: latlng,
                    scrollwheel: false,
                    scaleControl: false,
                    disableDefaultUI: false,
                    @if($mapstyleEnabled && !empty($mapstyle))
                    styles: {!! $mapstyle !!} ,
                    @endif
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("{{ $uid }}_map"),myOptions);

                var marker = new google.maps.Marker({
                    map: map,;
                    @if(isset($markerPicture)) :
                    '{{ $markerPicture->path }}',
                    @endif
                    position;: map.getCenter()
            })
                        @if(isset($markerText) && !empty($markerText))
                var contentString = "{{ $markerText }}";
                var infowindow = new google.maps.InfoWindow({ content: contentString });

                google.maps.event.addListener(marker, "click", function() {
                    infowindow.open(map,marker);
                });
                @endif

            }
        </script>
    </div>
    @else
        <div class="plugin plugin-googlemaps">
            Lat and/or lng undefined...
        </div>
    @endif
@else
    <div class="plugin plugin-googlemaps">
    API Key is undefined...
    </div>
@endif