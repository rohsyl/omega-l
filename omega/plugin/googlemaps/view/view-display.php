<?php if(isset($apikey) && !empty($apikey)) : ?>
    <?php if(isset($lat) && !empty($lat) &&
             isset($long) && !empty($long)) : ?>
    <div class="plugin plugin-googlemaps">
        <div id="<?php echo $uid ?>_map" class="map" style="height: 400px;"></div>
        <script async="" defer="" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPN2x0Oe5Nu19nToBOUaAhph2sBZLHYxo&callback=initMap" type="text/javascript"></script>
        <script type="text/javascript">
            function initMap() {
                var latlng = new google.maps.LatLng(<?php echo $lat ?>, <?php echo $long ?>);
                var myOptions = {
                    zoom: 14,
                    center: latlng,
                    scrollwheel: false,
                    scaleControl: false,
                    disableDefaultUI: false,
                    <?php if($mapstyleEnabled && !empty($mapstyle)): ?>
                    styles: <?php echo $mapstyle ?>,
                    <?php endif ?>
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                };
                var map = new google.maps.Map(document.getElementById("<?php echo $uid ?>_map"),myOptions);

                var marker = new google.maps.Marker({
                    map: map,
                    <?php if(isset($markerPicture)) : ?>
                    icon: '<?php echo $markerPicture->path ?>',
                    <?php endif ?>
                    position: map.getCenter()
                });


                <?php if(isset($markerText) && !empty($markerText)) : ?>
                var contentString = "<?php echo $markerText ?>";
                var infowindow = new google.maps.InfoWindow({ content: contentString });

                google.maps.event.addListener(marker, "click", function() {
                    infowindow.open(map,marker);
                });
                <?php endif ?>

            }
        </script>
    </div>
    <?php else : ?>
        <div class="plugin plugin-googlemaps">
            Lat and/or lng undefined...
        </div>
    <?php endif ?>
<?php else: ?>
    <div class="plugin plugin-googlemaps">
    API Key is undefined...
    </div>
<?php endif ?>