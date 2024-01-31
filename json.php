<?php
// POSTデータの準備
$postData = [
    "withFiles" => false,
    "withRenotes" => true,
    "limit" => 30,
];

// POSTリクエストを送信
$apiUrl = "https://vocaloid.social/api/notes/global-timeline";
$options = [
    'http' => [
        'header' => "Content-type: application/json",
        'method' => 'POST',
        'content' => json_encode($postData)
    ]
];
$context = stream_context_create($options);
$response = file_get_contents($apiUrl, false, $context);

header('Content-Type: application/json');

if ($response === FALSE) {
    echo json_encode(["error" => "Failed to fetch data from API"]);
} else {
    echo $response;
}
?>
