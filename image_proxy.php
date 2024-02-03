<?php
// URLパラメータから画像のURLを取得
$imageUrl = isset($_GET['url']) ? $_GET['url'] : null;

if ($imageUrl !== null) {
    // 画像のコンテンツタイプを取得
    $imageInfo = getimagesize($imageUrl);
    if ($imageInfo !== false) {
        $contentType = $imageInfo['mime'];

        // 画像データを直接送信
        header('Content-Type: ' . $contentType);
        readfile($imageUrl);
        exit();
    }
}

// エラーの場合はデフォルトの画像を送信
header('Content-Type: image/png');
readfile('default_image.png');
?>
