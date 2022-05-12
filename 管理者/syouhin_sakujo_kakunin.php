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
	
	$stmt->execute(array(':id'=>$_GET["id"]));
	$result=0;
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?php echo $result["name"]; ?>の商品削除</title>
</head>
<body>
	<form action="syouhin_sakujo_delete.php" method="post" enctype="multipart/form-data">
	<p>番号:<?php echo $result["id"]; ?></p>
	<p><img width="100" src="<?php echo $result['img']; ?>" alt="商品画像"></p>
	<p>商品名:<?php echo $result["name"]; ?></p>
	<p>作者名:<?php echo $result["author"]; ?></p>
	<p>カテゴリー:<?php echo $result["category"]; ?></p>
	<p>ジャンル:<?php echo $result["genre"]; ?></p>
	<p>数量:<?php echo $result["suuryou"]; ?></p>
	<p>値段:<?php echo $result["money"]; ?></p>
	<p>紹介文<?php echo nl2br($result["text"]); ?></p>
<?php
	$_SESSION["id"]=$result["id"];
?>
	<input type="submit" value="削除する">
	<input type="button" onclick="history.back()" value="戻る">
	</form>
</body>
</html>