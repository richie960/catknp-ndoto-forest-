<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenAI Chat</title>
</head>
<body>
    <h1>OpenAI Chat</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="user_input">Your message:</label><br>
        <input type="text" id="user_input" name="user_input"><br><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    // Set your OpenAI API key
    $apiKey = 'Jxu46qPS1uV2Avyc';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Define the endpoint URL
        $endpoint = 'https://api.openai.com/v1/completions';

        // Prepare the request data
        $data = [
            "model" => "text-davinci-003",
            "prompt" => $_POST['user_input'],
            "max_tokens" => 150
        ];

        // Encode the data for sending
        $postData = json_encode($data);

        // Set up cURL
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ]);

        // Execute the request
        $response = curl_exec($ch);

        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        // Close cURL resource
        curl_close($ch);

        // Decode the response
        $responseData = json_decode($response, true);

        // Output the assistant's response
        echo '<p><strong>Assistant:</strong> ' . $responseData['choices'][0]['text'] . '</p>';
    }
    ?>
</body>
</html>
