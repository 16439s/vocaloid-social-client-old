<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Local Timeline</title>
<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f0f2f5;
    margin: 0;
    padding: 20px;
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
    width: 10em; /* 絵文字のサイズを24emに設定 */
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
// 絵文字の画像URLを取得する関数
function getEmojiImageUrl($emojiName) {
    $apiUrl = "https://vocaloid.social/api/emoji?name=" . urlencode($emojiName);
    $response = file_get_contents($apiUrl);

    if ($response !== FALSE) {
        $emojiData = json_decode($response, true);
        if (isset($emojiData['url'])) {
            return $emojiData['url'];
        }
    }
    return null;
}

// テキスト内の絵文字を置き換える関数
function replaceEmojis($text) {
    preg_match_all("/:(.*?):/", $text, $matches);
    foreach ($matches[1] as $emojiName) {
        $imageUrl = getEmojiImageUrl($emojiName);
        if ($imageUrl !== null) {
            $text = str_replace(":$emojiName:", "<img src='$imageUrl' alt='$emojiName'>", $text);
        }
    }
    return $text;
}

// POSTデータの準備
$postData = [
    "withFiles" => false,
    "withRenotes" => true,
    "withReplies" => false,
    "limit" => 30,
];

// POSTリクエストを送信
$apiUrl = "https://vocaloid.social/api/notes/local-timeline";
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
            echo "<p><strong>{$note['user']['name']}</strong> @{$note['user']['username']}</p>";

            // テキスト内の絵文字を置き換える
            $text = replaceEmojis($note['text'] ?? $note['cw']);
            echo "<p>$text</p>"; // 投稿内容

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
