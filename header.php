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
    position: relative; /* メニュー位置を相対指定するため */
}

.menu {
    text-decoration: none;
    color: #fff;
}

.menu-toggle {
    cursor: pointer;
    display: none; /* 初期状態では非表示 */
    position: absolute; /* ハンバーガーメニューの位置を絶対指定 */
    right: 20px; /* ハンバーガーメニューを右端に移動 */
    top: 50%; /* ハンバーガーメニューを中央に配置 */
    transform: translateY(-50%); /* ハンバーガーメニューを垂直方向に中央揃え */
}

.menu-links {
    display: flex;
    flex-direction: column;
    background-color: #007bff;
    padding: 10px;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

@media screen and (max-width: 600px) {
    .header {
        flex-direction: column;
        align-items: flex-start;
    }

    .menu-toggle {
        display: block; /* 小さい画面で表示 */
    }

    .menu-links {
        display: none; /* 小さい画面では非表示 */
        position: absolute;
        top: 60px; /* ヘッダーの高さに合わせて調整 */
        right: 20px;
    }

    .menu-links.show-menu {
        display: flex; /* show-menuが適用されたときに表示 */
    }
}
</style>
</head>
<body>
<div class="header">
    <div>Vocaloid.social Timeline</div>
    <div class="menu-toggle" onclick="toggleMenu()">
        <!-- ハンバーガーメニューアイコン（SVG） -->
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M3 6H21V8H3V6ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z" fill="white"/>
        </svg>
    </div>
    <div class="menu-links">
        <a class="menu" href="/">Local Timeline</a>
        <a class="menu" href="/global.php">Global Timeline</a>
        <?php
        if (isset($_COOKIE['token'])) {
            echo '<a class="menu" href="/create.php">新規投稿</a>';
            echo '<a class="menu" href="/logout.php">ログアウト</a>';
        } else {
            echo '<a class="menu" href="/login.php">ログイン</a>';
        }
        ?>
    </div>
</div>

<script>
function toggleMenu() {
    var menuLinks = document.querySelector('.menu-links');
    menuLinks.classList.toggle('show-menu');
}
</script>
</body>
</html>
