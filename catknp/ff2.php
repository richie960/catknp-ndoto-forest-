<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance</title>
    <style>
        /* CSS for styling the under maintenance message */
        .under-maintenance {
            font-size: 24px;
            text-align: center;
            margin-top: 50px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="under-maintenance" id="maintenanceMessage"></div>

    <script>
        // JavaScript code to display under maintenance message
        window.onload = function() {
            // Get the current date and time
            var now = new Date();
            var hour = now.getHours();
            var day = now.getDay();

            // Check if it's between 8:00 PM and 6:00 AM or if it's Sunday (0)
            if ((hour >= 20 || hour < 6) || day === 0) {
                // Display under maintenance message
                document.getElementById('maintenanceMessage').innerText = 'Under Maintenance';
            }
        };
    </script>
</body>
</html>
