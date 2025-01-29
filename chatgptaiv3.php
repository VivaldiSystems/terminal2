<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$question = "";

if (empty($_GET))
{

  $question = "Who is the President of the United States?";

}
else
{
   $question = $_GET['prompt']; 
}




// Your OpenAI API key
$api_key = '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';



// Set up the request data  davinci-codex
$data = array(
    'model' => 'text-davinci-002',
    'prompt' => $question,
    'temperature' => 0.5,
    'max_tokens' => 100
);

// Set up the request headers
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key
);

// Set up the request options
$options = array(
    'http' => array(
        'header' => implode("\r\n", $headers),
        'method' => 'POST',
        'content' => json_encode($data),
        'limit' => 10,
        'ignore_errors' => true // handle HTTP errors manually
    ),
    'ssl' => array(
        'verify_peer' => true, // enable SSL certificate verification
        'verify_peer_name' => true // verify that the certificate's common name matches the hostname
    )
);

// Send the API request and get the response
$url = 'https://api.openai.com/v1/completions';
$response = file_get_contents($url, false, stream_context_create($options));

// Check for HTTP errors
$http_status = explode(' ', $http_response_header[0])[1];
if ($http_status != 200) {
    echo "Error: HTTP status code $http_status";
    echo $response;
    exit();
}

// Parse the response and display the result
$result = json_decode($response, true)['choices'][0]['text'];
echo $result;


?>