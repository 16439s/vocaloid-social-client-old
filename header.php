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

/* メニューのスタイル */
.menu-toggle {
    cursor: pointer;
}

/* メニューのスタイル */
.menu-links {
    display: none; /* デフォルトでは非表示 */
    flex-direction: column;
    position: absolute;
    top: 50px; /* ヘッダーの高さに合わせて調整 */
    right: 20px;
    background-color: #007bff;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

/* 小さい画面用のメニューのスタイル */
@media screen and (max-width: 600px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu-links {
        position: static;
        display: flex;
        flex-direction: column;
        background-color: transparent;
        box-shadow: none;
    }
}

/* メニューが表示されるときのスタイル */
.show-menu {
    display: flex;
}
</style>
</head>
<body>
<div class="header">
    <div>Vocaloid.social Timeline</div>
    <!-- ハンバーガーメニューアイコン（SVG） -->
    <div class="menu-toggle" onclick="toggleMenu()">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6H21V8H3V6ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z" fill="white"/>
        </svg>
    </div>
    <div class="menu-links">
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

<script>
// メニューを切り替える関数
function toggleMenu() {
    var menuLinks = document.querySelector('.menu-links');
    menuLinks.classList.toggle('show-menu'); // show-menuクラスをトグル
}
</script>
</body>
</html>
