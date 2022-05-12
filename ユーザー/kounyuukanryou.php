<?php
	session_start();
	session_regenerate_id(true);
	
	$dbname='mysql:host=localhost;dbname=ec_shop;charset=utf8';
	$id='root';
	$pw='';
	try{
		$pdo= new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES =>false));
	}
	catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}
	
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `id`=:id");
	$stmt->bindParam(':id',$_SESSION["id"]);
	$stmt->execute();
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt=null;
	//UPDATE
	$sql = 'UPDATE `syouhin` SET `suuryou`=:suuryou WHERE `id`=:id';
	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':suuryou',$_SESSION['i']);
	$stmt->bindParam(':id',$_SESSION['id']);
	$stmt->execute();
	$stmt=null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>購入完了</title>
</head>
<body>
	<p>購入完了しました!</p>
	<p><a href="TOP.php">TOPへ</a></p>
</body>
</html>