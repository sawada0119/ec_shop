<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン画面</title>
	<link rel="stylesheet" href="login.css">
</head>
<body>
	<div>
	<h2>ログイン</h2>
	<main>
	<form action="login_kakunin.php" method="post">
		ID名<br>
		<input type="text" name="name" size="20"><br>
		パスワード<br>
		<input type="password" name="pass" size="20"><br>
		<p>&nbsp;</p>
		<input type="submit" value="ログイン"><br>
	</form>
	</main>
	<submain>
	<p>会員登録をしていない方はこちら</p>
	<p><a href="kaiintouroku.htm">会員登録</a></p>
	</submain>
	<header>
	<p><a href="TOP.php">TOPへ</a></p>
	</header>
	</div>
</body>
</html>