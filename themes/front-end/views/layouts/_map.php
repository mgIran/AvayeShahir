<section class="map">
    <div id="google-map"></div>
</section>
<?
Yii::app()->clientScript->registerScriptFile("http://maps.googleapis.com/maps/api/js");
Yii::app()->clientScript->registerScript("google-map-scripts","
        var map;
        var marker;
        var myCenter=new google.maps.LatLng(34.62837015639111,50.890497923028306);
        function initialize()
        {
            var mapProp = {
                center:myCenter,
                zoom:15,
                scrollwheel: false
            };
            map = new google.maps.Map(document.getElementById('google-map'),mapProp);
            placeMarker(myCenter ,map);
        }

        function placeMarker(location ,map) {

            if(marker != undefined)
                marker.setMap(null);
            marker = new google.maps.Marker({
                position: location,
                map: map,
            });
        }
        google.maps.event.addDomListener(window, 'load', initialize);");