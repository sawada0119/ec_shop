<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
	<link rel="stylesheet" href="login.css">
</head>
<body>
	<h2>ログイン</h2>
<?php
	$dbname = 'mysql:host=localhost;dbname=ec_shop;charset=utf8';
	$id = 'root';
	$pw = '';

	try {
		$pdo = new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES => false));
	}
	catch (PDOException $e) {
		die('データベース接続失敗。'.$e->getMessage());
	}

	if($_SERVER["REQUEST_METHOD"]!=="POST"):
		die("直接アクセス禁止");
	endif;
	
	
	$stmt=$pdo->prepare("SELECT `pass` FROM `kaiin` WHERE `id_name`=:id_name");
	$stmt->bindParam(":id_name",$_POST["name"]);
	$stmt->execute();
	$result=$stmt->fetch();
	if($result):
		if(password_verify($_POST["pass"],$result["pass"])):
?>
	<?php 
	session_start();
		session_regenerate_id(true);
		$_SESSION['id_name']=$_POST["name"];
		$_SESSION['pass']=$_POST["pass"];
	header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/TOP.php"); ?>
<?php
		else:
			$errors="!ID名もしくはパスワードが違います";
		endif;
	else:
		$errors="!ID名もしくはパスワードが違います";
	endif;
	$stmt=null;
	if(isset($errors)):
?>
	<main>
	
	<form action="login_kakunin.php" method="post">
		<p class="error"><?php echo $errors; ?></p>
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
<?php
	endif;
	$pdo=null;
?>
</body>
</html>
