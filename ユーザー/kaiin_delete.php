<?php
	session_start();
	
	if(isset($_SESSION['name'])):
		exit("直接アクセス禁止");
	endif;
	
	$dbname='mysql:host=localhost;dbname=ec_shop;charset=utf8';
	$id='root';
	$pw='';
	try{
		$pdo= new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES =>false));
	}
	catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}
	

	$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
	$stmt->bindParam(':id_name',$_SESSION["id_name"]);
	$stmt->execute();
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt=null;
	//DELETE
	$stmt=$pdo->prepare("DELETE FROM `kaiin` WHERE `id_name`=:id_name");
	$stmt->bindParam(':id_name',$_SESSION["id_name"]);
	$stmt->execute();
	$stmt=null;
	
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])):
		setcookie(session_name(), '', time()-1000);
	endif;
	session_destroy();

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>退会</title>
</head>
<body>
	<p>退会しました</p>
	<p><a href="TOP.php">TOPへ</a></p>
</body>
</html>