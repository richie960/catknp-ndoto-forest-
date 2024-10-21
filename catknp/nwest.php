<!DOCTYPE html>
<html>
<head>
    <title>Take Screenshot</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>
<body>
    <button id="screenshotBtn">Take Screenshot</button>

    <script>
        document.getElementById('screenshotBtn').addEventListener('click', function() {
            // Capture screenshot of the entire page
            html2canvas(document.body).then(function(canvas) {
                // Convert the canvas to a data URL representing a PNG image
                var dataURL = canvas.toDataURL('image/png');

                // Create a link element to download the screenshot
                var link = document.createElement('a');
                link.href = dataURL;
                link.download = 'screenshot.png';

                // Click the link to download the screenshot
                link.click();
            });
        });
    </script>
</body>
</html>
