<!DOCTYPE html>
<html>
<head>
    <title>Google Maps Integration</title>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Waste Collection Tracking</h1>
    <div id="map"></div>

    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: { lat: 0, lng: 0 } // Default center
            });

            fetch('fetch_location.php')
                .then(response => response.json())
                .then(data => {
                    var latLng = new google.maps.LatLng(data.latitude, data.longitude);
                    map.setCenter(latLng);

                    var marker = new google.maps.Marker({
                        position: latLng,
                        map: map
                    });
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async defer></script>
</body>
</html>
