<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Link Viewer</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .search-container {
    margin-top: 20px; /* Adjust margin-top to move the container closer to the top */
    margin-left: 20px; /* Adjust margin-left to move the container to the left */
    margin-bottom: 20px;
    width: 200px; /* Adjust width to decrease the size of the container */
}

.search-container input[type=text] {
    width: 100%; /* Set input field width to 100% to fill the container */
}

        .videos-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            gap: 20px;
            width: 100%;
            max-width: 800px;
        }
        .video-container {
            position: relative;
            width: calc(33.33% - 20px);
            box-sizing: border-box;
            margin-bottom: 20px;
            cursor: pointer;
        }
        .video-container iframe {
            width: 100%;
            height: 200px;
            border: none;
        }
        .description {
            text-align: center;
            margin-top: 5px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            overflow: auto;
        }
        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #000;
            padding: 10px;
            border-radius: 10px;
            width: 80%;
            height: 80%;
            max-width: 80%;
            max-height: 80%;
        }
        .modal-content iframe {
            width: 100%;
            height: 100%;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
            z-index: 10000;
        }
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            z-index: 10000;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="search-container">
        <input type="text" class="search-input" id="searchInput" placeholder="Search for videos..." oninput="filterVideos()">
    </div>
    <div class="videos-row" id="videosRow">
        <!-- Videos will be loaded here -->
    </div>
</div>

<div id="videoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <iframe id="modalIframe" src="" frameborder="0" allowfullscreen></iframe>
    </div>
    <button class="back-button" onclick="closeModal()">Go Back</button>
</div>

<script>
    window.onload = function() {
        preloadAllVideos();
    };

    let videoData = [];

    function preloadAllVideos() {
        var videosRow = document.getElementById("videosRow");
        <?php
        $file = 'test.txt';
        $contents = file_get_contents($file);
        $links_with_explanations = array_reverse(explode("\n", $contents));

        foreach ($links_with_explanations as $index => $link_with_explanation) {
            $parts = explode('|', $link_with_explanation);
            $videoLink = trim($parts[0]);
            $explanation = trim($parts[1]);
            echo "videoData.push({link: '$videoLink', explanation: '$explanation'});";
        }
        ?>

        videoData.forEach(video => {
            createVideoContainer(video);
        });
    }

    function createVideoContainer(video) {
        var videosRow = document.getElementById("videosRow");
        var videoContainer = document.createElement('div');
        videoContainer.classList.add('video-container');
        var iframe = document.createElement('iframe');
        iframe.src = 'https://www.youtube.com/embed/' + getYoutubeVideoId(video.link);
        videoContainer.appendChild(iframe);
        var description = document.createElement('p');
        description.textContent = video.explanation;
        description.classList.add('description');
        videoContainer.appendChild(description);
        videoContainer.onclick = function() { openModal('https://www.youtube.com/embed/' + getYoutubeVideoId(video.link)); };
        videosRow.appendChild(videoContainer);
    }

    function getYoutubeVideoId(url) {
        var video_id = '';
        var url_components = url.split(/(vi\/|v=|\/v\/|youtu\.be\/|\/embed\/)/);
        if (url_components[2] !== undefined) {
            video_id = url_components[2].split(/[^0-9a-z_-]/i)[0];
        } else {
            video_id = url;
        }
        return video_id;
    }

    function openModal(video) {
        var modal = document.getElementById("videoModal");
        var modalIframe = document.getElementById("modalIframe");
        modalIframe.src = video;
        modal.style.display = "block";
    }

    function closeModal() {
        var modal = document.getElementById("videoModal");
        modal.style.display = "none";
        var modalIframe = document.getElementById("modalIframe");
        modalIframe.src = "";
    }

    function filterVideos() {
        var input = document.getElementById("searchInput");
        var filter = input.value.toLowerCase();
        var videosRow = document.getElementById("videosRow");
        videosRow.innerHTML = '';

        videoData.forEach(video => {
            if (video.explanation.toLowerCase().includes(filter)) {
                createVideoContainer(video);
            }
        });
    }
</script>

</body>
</html>
