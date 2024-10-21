<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        #map {
            height: 400px;
            margin-bottom: 20px;
        }
        #info {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id="info">
        Obtained Location: <span id="obtainedLocation">Latitude: 0, Longitude: 0</span><br>
        Expected Location: <?php
            // Read coordinates from the text file
            $coordinates = file_get_contents('coordinates.txt');
            // Extract latitude and longitude values
            preg_match('/Latitude: (.*), Longitude: (.*)/', $coordinates, $matches);
            $latitude = $matches[1];
            $longitude = $matches[2];
            echo "<span id='expectedLocation'>Latitude: $latitude, Longitude: $longitude</span>";
        ?><br>
        Remaining Distance: <span id="remainingDistance">Calculating...</span>
    </div>

    <script>
        // Define coordinates for expected location
        var expectedLocation = [<?php echo $latitude ?>, <?php echo $longitude ?>]; // Replace with your expected coordinates

        // Function to create map
        function createMap(obtainedLocation) {
            var map = L.map('map').setView(obtainedLocation, 10);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Add markers for expected and obtained locations with different colors
            var expectedMarker = L.marker(expectedLocation, {icon: L.icon({iconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-blue.png'})}).addTo(map);
            var obtainedMarker = L.marker(obtainedLocation, {icon: L.icon({iconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-red.png'})}).addTo(map);

            // Bind popup with coordinates to markers
            expectedMarker.bindPopup('Expected Location<br>Latitude: ' + expectedLocation[0] + '<br>Longitude: ' + expectedLocation[1]);
            obtainedMarker.bindPopup('Obtained Location<br>Latitude: ' + obtainedLocation[0] + '<br>Longitude: ' + obtainedLocation[1]);

            // Draw a polyline between the two points
            var polyline = L.polyline([expectedLocation, obtainedLocation], {color: 'green'}).addTo(map);

            // Function to update location and distance
            function updateLocationAndDistance() {
                // Update the obtained location
                document.getElementById('obtainedLocation').innerText = 'Latitude: ' + obtainedLocation[0] + ', Longitude: ' + obtainedLocation[1];

                // Calculate distance between two points
                var distance = map.distance(expectedLocation, obtainedLocation);

                // Update the remaining distance information if it's greater than a threshold
                var thresholdDistance = 0.0006; // About 11.1 meters in this example
                if (distance > thresholdDistance) {
                    // Calculate remaining distance
                    var remainingDistance = (distance - thresholdDistance).toFixed(2);
                    document.getElementById('remainingDistance').innerText = remainingDistance + ' meters';
                } else {
                    document.getElementById('remainingDistance').innerText = 'Close enough';
                }

                // Send obtained location to PHP script using AJAX
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                        latitude: obtainedLocation[0],
                        longitude: obtainedLocation[1]
                    },
                    success: function(response) {
                        console.log(response); // Log response from PHP script
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving coordinates:', error);
                    }
                });
            }

            // Update location and distance
            updateLocationAndDistance();

            // Update location and distance every 30 seconds
            setInterval(function() {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var obtainedLocation = [position.coords.latitude, position.coords.longitude];
                    obtainedMarker.setLatLng(obtainedLocation);
                    polyline.setLatLngs([expectedLocation, obtainedLocation]);
                    updateLocationAndDistance();
                });
            }, 

30000); // 30 seconds
        }

        // Get user's current location using geolocation
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var obtainedLocation = [position.coords.latitude, position.coords.longitude];
                createMap(obtainedLocation);
            }, function () {
                // Handle geolocation error
                console.error('Error getting geolocation.');
            });
        } else {
            // Geolocation not supported
            console.error('Geolocation is not supported.');
        }
    </script>
      <script>
        // Reload the page every 1 minute (60 seconds)
        setInterval(function() {
            location.reload();
        }, 30000); // 60000 milliseconds = 60 seconds
    </script>
</body>
</html>
<?php
// Check if latitude, longitude, and name are set in the POST request
if (isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['name'])) {
    // Assign POST values to variables
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $name = $_POST['name'];

    // Save the received data to a text file
    $data = "Latitude: $latitude, Longitude: $longitude, Name: $name\n";
    file_put_contents('coordinates2.txt', $data, FILE_APPEND);

    // Echo success message
    echo "Coordinates saved successfully.";
} else {
    // If any of the required POST parameters are missing, echo an error message
    echo "Error: Latitude, longitude, or name not set.";
}

// Output all the data ever stored in the text file
$allData = file_get_contents('coordinates.txt');
echo "<pre>$allData</pre>";
echo "no data";
?>
