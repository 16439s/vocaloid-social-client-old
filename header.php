<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Timeline</title>
<style>
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
}

.menu {
    text-decoration: none;
    color: #fff;
}
</style>
</head>
<body>
<div class="header">
    <div>Vocaloid.social Timeline</div>
    <div>
        <a class="menu" href="/">Local Timeline</a>
        <a class="menu" href="/global.php">Global Timeline</a>
        <?php
        // CookieからTOKENを取得してチェック
        if (isset($_COOKIE['token'])) {
            // TOKENがある場合は投稿ページへのリンクを表示
            echo '<a class="menu" href="/create.php">新規投稿</a>';
            echo '<a class="menu" href="/logout.php">ログアウト</a>';
        } else {
            // TOKENがない場合はログインページへのリンクを表示
            echo '<a class="menu" href="/login.php">ログイン</a>';
        }
        ?>
    </div>
</div>
