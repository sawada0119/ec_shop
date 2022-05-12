<?php
	session_start();
	session_regenerate_id(true);
	$_SESSION["id_name_henkou"]=null;
	$_SESSION["pass_henkou"]=null;
	$_SESSION["mail_henkou"]=null;
	$_SESSION["address_henkou"]=null;
	$_SESSION["tel_henkou"]=null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員情報の変更</title>
	<link rel="stylesheet" href="kaiin_henkou.css">
</head>
<body>
<?php
	if(isset($_SESSION['id_name'])):
?>
	<div class="waku">
	<h2>変更項目</h2>
	<p><?php echo $_SESSION["id_name"]; ?>様</p>
	<div class="koumoku">
		<p><a href='kaiin_henkou_pass.php'>パスワードの変更</a></p>
		<p><a href='kaiin_henkou_mail.php'>メールアドレスの変更</a></p>
		<p><a href='kaiin_henkou_address.php'>住所の変更</a></p>
		<p><a href='kaiin_henkou_tel.php'>電話番号の変更</a></p>
		<p><a href='kaiin_sakujo.php'>退会する</a></p>
	</div>
	</div>
	<div class="header">
		<a href="TOP.php">TOP</a>
	</div>
<?php
	else:
?>
	<p>ログインしなおしてください</p>
	<p><a href='staff_login.htm'>ログインページ</a></p>
<?php endif; ?>
</body>
</html>
