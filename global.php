<?php
// Load font size from cookie or set default
$fontsize = isset($_COOKIE['fontsize']) ? $_COOKIE['fontsize'] : 'medium';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Global Timeline</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 20px;
    font-size: <?php echo $fontsize; ?>;
}

.card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.card p {
    margin: 10px 0;
}

.card img {
    max-width: 100%;
    border-radius: 5px;
    margin-top: 10px;
}

.card strong {
    color: #333;
}

.card a {
    color: #007bff;
    text-decoration: none;
}

.card a:hover {
    text-decoration: underline;
}

.renote-note-message {
    color: #777;
    font-style: italic;
    margin-top: 5px;
}

</style>
</head>
<body>
  <?php include 'header.php'; ?>
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

if ($response === FALSE) {
    echo "Failed to fetch data from API";
} else {
    $responseData = json_decode($response, true);
    if (is_array($responseData)) {
        foreach ($responseData as $note) {
            // 投稿IDを取得
            $postID = $note['id'];

            echo "<div class='card'>";
            echo "<p><strong>{$note['user']['name']}</strong> @{$note['user']['username']}@{$note['user']['host']}</p>";
            echo "<p>" . ($note['text'] ?? $note['cw']) . "</p>"; // 投稿内容
            echo "<p>" . date('Y/m/d H:i:s', strtotime($note['createdAt'])) . "</p>"; // 作成日時
            echo "<p style='text-align: right;'>投稿ID: $postID</p>"; // 投稿IDを表示

            // リノートの場合のメッセージを表示
            if ($note['renoteId'] !== null) {
                echo "<p class='renote-note-message'>※このノートはリノートです。</p>";
            }

            echo "</div>";
        }
    } else {
        echo "Invalid response from API";
    }
}
?>

</body>
</html>
