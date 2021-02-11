<?php
    
?>

<?php include('../common/_header.php'); ?>

<body>
    <main>
        <h1>新規ユーザ登録</h1>

        <div class="error-message">
            <ul>
                <li>エラーメッセージ表示枠テスト1</li>
                <li>エラーメッセージ表示枠テスト2</li>
            </ul>
        </div>
        
        <div id="contents">
            <form action="new_register_check.php">
                <label for="user_name">表示名</label>
                <input id="user_name" type="text" name="user_name">
                <label for="email">メールアドレス</label>
                <input id="email" type="text" name="email">
                <label for="email_flag">メール通知を受け取る</label>
                <input id="email_flag" type="checkbox" name="email_flag">
                <label for="icon_img">アイコン画像</label>
                <input id="icon_img" type="file" name="icon_image">
                <input type="submit" value="登録">
                <input type="submit" onclick="history.back();" value="キャンセル">
            </form>
        </div>
    </main>

<?php include('../common/_footer.php'); ?>