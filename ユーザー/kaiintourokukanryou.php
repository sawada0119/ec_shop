<?php
	session_start();

	$dbname = 'mysql:host=localhost;dbname=ec_shop;charset=utf8';
	$id = 'root';
	$pw = '';
	
	try{
		$pdo = new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES => false));
	}
	catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}
	
	$errors=array();
	
	if($_SERVER["REQUEST_METHOD"]!=="POST"):
		$pdo=null;
		exit("直接アクセス禁止");
	endif;
	
	$passhash=password_hash($_SESSION["pass"],PASSWORD_DEFAULT);
	$stmt = $pdo -> prepare('INSERT INTO `kaiin` (`id_name`,`pass`,`mail`,`postal_code`,`address`,`tel`) VALUES (:id_name,:pass,:mail,:postal_code,:address,:tel)');
		$stmt -> bindParam(':id_name',$_SESSION["id_name"]);
		$stmt -> bindParam(':pass',$passhash);
		$stmt -> bindParam(':mail',$_SESSION["mail"]);
		$stmt -> bindParam(':postal_code',$_SESSION["postal_code"]);
		$stmt -> bindParam(':address',$_SESSION["address"]);
		$stmt -> bindParam(':tel',$_SESSION["tel"]);
		$stmt->execute();
		$stmt=null;
	$pdo=null;
	
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])):
		setcookie(session_name(), '', time()-1000);
	endif;
	session_destroy();
?>
<DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>会員登録</title>
	<link rel="stylesheet" href="">
</head>
<body>
	<h3>登録完了しました</h3>
	<p><a href="login.htm">ログインへ</a></p>
	<p><a href="TOP.php">TOPへ</a></p>
</body>
</html>