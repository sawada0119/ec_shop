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
	<h2>退会</h2>
	<main>
	<form action="kaiin_sakujo_kakunin.php" method="post">
		ID名<br>
		<input type="text" name="id_name" size="20"><br>
		パスワード<br>
		<input type="password" name="pass" size="20"><br>
		<p>&nbsp;</p>
		<input type="submit" value="退会する"><br>
	</form>
	</main>
	<header>
		<p><a href="TOP.php">TOPへ</a></p>
	</header>
	</div>
</body>
</html>