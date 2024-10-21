<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screen Capture</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
</head>
<body>
    <h1>Screen Capture</h1>
    <button id="captureBtn">Capture Screen</button>
    <div id="screenshotContainer"></div>

    <script>
        document.getElementById('captureBtn').addEventListener('click', () => {
            html2canvas(document.body).then(canvas => {
                // Display the screenshot on the page
                const screenshotContainer = document.getElementById('screenshotContainer');
                screenshotContainer.innerHTML = '';
                screenshotContainer.appendChild(canvas);
            });
        });
    </script>
</body>
</html>
