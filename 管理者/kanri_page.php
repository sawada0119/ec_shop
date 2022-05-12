<?php
	session_start();
	session_regenerate_id(true);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員ページ</title>
</head>
<body>
<?php
	if(isset($_SESSION['name'])):
?>
	<h1>会員ページ</h1>
	<p><a href='syouhintouroku.php'>商品の登録</a></p>
	<p><a href='syouhin_tuika.php'>商品の数量変更</a></p>
	<p><a href='syouhin_henkou.php'>商品の表示変更</a></p>
	<p><a href='syouhin_sakujo.php'>商品の削除</a></p>
	<p><a href='staff_logout.php'>ログアウト</a></p>
<?php
	else:
?>
	<p>ログインしなおしてください</p>
	<p><a href='staff_login.htm'>ログインページ</a></p>
<?php endif; ?>
</body>
</html>
