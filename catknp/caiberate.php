<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Save Coordinates with PHP</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <h2>Save Coordinates with PHP</h2>
    <button onclick="saveCoordinates()">Save Current Coordinates</button>

    <script>
        function saveCoordinates() {
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Send coordinates to PHP script using AJAX
                $.ajax({
                    url: 'save_coordinates.php',
                    type: 'POST',
                    data: {
                        latitude: latitude,
                        longitude: longitude
                    },
                    success: function(response) {
                        alert(response); // Display response from PHP script
                    },
                    error: function(xhr, status, error) {
                        console.error('Error saving coordinates:', error);
                        alert('Error saving coordinates. Please try again.');
                    }
                });
            }, function(error) {
                console.error('Error getting geolocation:', error);
                alert('Error getting geolocation. Unable to save coordinates.');
            });
        }
    </script>
</body>
</html>
