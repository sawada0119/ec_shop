<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員情報の変更</title>
	<link rel="stylesheet" href="kaiin_henkou_koumoku.css">
</head>
<body>
<?php
	session_start();
	
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
	
	//パスワードの変更
	if(isset($_POST["id_name"]) && ($_POST["pass_henkou"])):
		$stmt=$pdo->prepare("SELECT `pass` FROM `kaiin` WHERE `id_name`=:id_name");
		$stmt->bindParam(":id_name",$_POST["id_name"]);
		$stmt->execute();
		$result=$stmt->fetch();
		if($result):
			if(password_verify($_POST["pass_henkou"],$result["pass"])):
				$_SESSION["pass_henkou"]=$_POST["pass_henkou"];
				header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/kaiin_henkou_pass.php"); //
			else:
				$errors="ID名もしくはパスワードが違います";
			endif;
		else:
			$errors="ID名もしくはパスワードが違います";
		endif;
		$stmt=null;
		if(isset($errors)):
?>
			<h3>ID名とパスワードを入力してください</h3>
			<p class="error"><?php echo $errors; ?></p>
			<div class="henkou">
			<form action="kaiin_henkou_kakunin.php" method="post">
			ID名<br>
			<input type="text" name="id_name" size="20"><br>
			パスワード<br>
			<input type="password" name="pass_henkou" size="20"><br>
			<input type="submit" value="送信"><br>
			</form>
			<p>&nbsp;</p>
			<p><a href="kaiin_henkou.php">各種変更項目</a></p>
			<p><a href="TOP.php">TOP</a></p>
			</div>
<?php
		endif;
		$pdo=null;
	//メールアドレス
	elseif(isset($_POST["id_name_mail_henkou"]) && ($_POST["pass"])):
		$stmt=$pdo->prepare("SELECT `pass` FROM `kaiin` WHERE `id_name`=:id_name");
		$stmt->bindParam(":id_name",$_POST["id_name_mail_henkou"]);
		$stmt->execute();
		$result=$stmt->fetch();
		if($result):
			if(password_verify($_POST["pass"],$result["pass"])):
				$_SESSION["mail_henkou"]=$_POST["id_name_mail_henkou"];
				header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/kaiin_henkou_mail.php"); //
			else:
				$errors="ID名もしくはパスワードが違います";
			endif;
		else:
			$errors="ID名もしくはパスワードが違います";
		endif;
		$stmt=null;
		if(isset($errors)):
?>
			<h3>ID名とパスワードを入力してください</h3>
			<p class="error"><?php echo $errors; ?></p>
			<div class="henkou">
			<form action="kaiin_henkou_kakunin.php" method="post">
			ID名<br>
			<input type="text" name="id_name_mail_henkou" size="50"><br>
			パスワード<br>
			<input type="password" name="pass" size="20"><br>
			<input type="submit" value="送信"><br>
			</form>
			<p>&nbsp;</p>
			<p><a href="kaiin_henkou.php">各種変更項目</a></p>
			<p><a href="TOP.php">TOP</a></p>
			</div>
<?php
		endif;
		$pdo=null;
	//郵便番号・住所
	elseif(isset($_POST["id_name_address_henkou"]) && ($_POST["pass"])):
		$stmt=$pdo->prepare("SELECT `pass` FROM `kaiin` WHERE `id_name`=:id_name");
		$stmt->bindParam(":id_name",$_POST["id_name_address_henkou"]);
		$stmt->execute();
		$result=$stmt->fetch();
		if($result):
			if(password_verify($_POST["pass"],$result["pass"])):
				$_SESSION["address_henkou"]=$_POST["id_name_address_henkou"];
				header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/kaiin_henkou_address.php"); //
			else:
				$errors="ID名もしくはパスワードが違います";
			endif;
		else:
			$errors="ID名もしくはパスワードが違います";
		endif;
		$stmt=null;
		if(isset($errors)):
?>
			<h3>ID名とパスワードを入力してください</h3>
			<p class="error"><?php echo $errors; ?></p>
			<div class="henkou">
			<form action="kaiin_henkou_kakunin.php" method="post">
			ID名<br>
			<input type="text" name="id_name_address_henkou" size="20"><br>
			パスワード<br>
			<input type="password" name="pass" size="20"><br>
			<input type="submit" value="送信"><br>
			</form>
			<p>&nbsp;</p>
			<p><a href="kaiin_henkou.php">各種変更項目</a></p>
			<p><a href="TOP.php">TOP</a></p>
			</div>
<?php
		endif;
		$pdo=null;
	//電話番号
	elseif(isset($_POST["id_name_tel_henkou"]) && ($_POST["pass"])):
		$stmt=$pdo->prepare("SELECT `pass` FROM `kaiin` WHERE `id_name`=:id_name");
		$stmt->bindParam(":id_name",$_POST["id_name_tel_henkou"]);
		$stmt->execute();
		$result=$stmt->fetch();
		if($result):
			if(password_verify($_POST["pass"],$result["pass"])):
				$_SESSION["tel_henkou"]=$_POST["id_name_tel_henkou"];
				header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/kaiin_henkou_tel.php"); //
			else:
				$errors="ID名もしくはパスワードが違います";
			endif;
		else:
			$errors="ID名もしくはパスワードが違います";
		endif;
		$stmt=null;
		if(isset($errors)):
?>
			<h3>ID名とパスワードを入力してください</h3>
			<p class="error"><?php echo $errors; ?></p>
			<div class="henkou">
			<form action="kaiin_henkou_kakunin.php" method="post">
			ID名<br>
			<input type="text" name="id_name_tel_henkou" size="20"><br>
			パスワード<br>
			<input type="password" name="pass" size="20"><br>
			<input type="submit" value="送信"><br>
			</form>
			<p>&nbsp;</p>
			<p><a href="kaiin_henkou.php">各種変更項目</a></p>
			<p><a href="TOP.php">TOP</a></p>
			</div>
<?php
		endif;
		$pdo=null;
	else:
?>
		<h3>ID名とパスワードを入力してください</h3>
		<div class="henkou">
		<form action="kaiin_henkou_kakunin.php" method="post">
		ID名<br>
		<input type="text" name="id_name_tel_henkou" size="20"><br>
		パスワード<br>
		<input type="password" name="pass" size="20"><br>
		<input type="submit" value="送信"><br>
		</form>
		<p>&nbsp;</p>
		<p><a href="kaiin_henkou.php">各種変更項目</a></p>
		<p><a href="TOP.php">TOP</a></p>
<?php
	endif;
?>
</body>
</html>