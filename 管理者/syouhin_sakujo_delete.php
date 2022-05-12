<?php
	session_start();
	
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
	//DELETE
	$stmt=$pdo->prepare("DELETE FROM `syouhin` WHERE `id`=:id");
	$stmt->bindParam(':id',$_SESSION["id"]);
	$stmt->execute();
	$stmt=null;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品削除</title>
</head>
<body>
	<p>商品を削除しました</p>
	<p><a href="kanri_page.php">管理ページへ</a></p>
	<p><a href="syouhin_sakujo.php">商品一覧へ</a></p>
</body>
</html>