  <button id="captureBtn">Capture Screenshot</button>
    <div id="screenshotResult"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script>
        document.getElementById('captureBtn').addEventListener('click', function() {
            html2canvas(document.body).then(function(canvas) {
                var imgData = canvas.toDataURL('image/png');

                // Sending the data to server to save
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'save_screenshot.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Display the result from the server
                            document.getElementById('screenshotResult').innerHTML = 'Screenshot saved as: ' + xhr.responseText;
                        } else {
                            console.error('Error saving screenshot:', xhr.status);
                        }
                    }
                };
                xhr.send('imgData=' + encodeURIComponent(imgData));
            }).catch(function(error) {
                console.error('Error capturing screenshot:', error);
            });
        });
    </script>