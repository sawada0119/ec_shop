<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>ログイン</title>
	<link rel="stylesheet" href="login.css">
</head>
<body>
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
	
	
	$stmt=$pdo->prepare("SELECT `pass` FROM `staff` WHERE `name`=:name");
	$stmt->bindParam(":name",$_POST["name"]);
	$stmt->execute();
	$result=$stmt->fetch();
	if($result):
		if(password_verify($_POST["pass"],$result["pass"])):
?>
	<?php 
	session_start();
		session_regenerate_id(true);
		$_SESSION['name']=$_POST["name"];
		$_SESSION['pass']=$_POST["pass"];
	header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/管理者/kanri_page.php"); ?>
<?php
		else:
			$errors="ID名もしくはパスワードが違います";
		endif;
	else:
		$errors="ID名もしくはパスワードが違います";
	endif;
	$stmt=null;
	if(isset($errors)):
?>
	<p><?php echo $errors; ?></p>
	<form action="staff_login.php" method="post">
		ID名<br>
		<input type="text" name="name" size="20"><br>
		パスワード<br>
		<input type="password" name="pass" size="20"><br>
		<input type="submit" value="ログイン"><br>
	</form>
	<p>会員登録をしていない方はこちら</p>
	<p><a href="staff_kaiin.htm">スタッフの登録</a></p>
<?php
	endif;
	$pdo=null;
?>
</body>
</html>
