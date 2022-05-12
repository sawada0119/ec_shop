<?php
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
	<title><?php echo $result["name"]; ?>の商品追加</title>
</head>
<body>
	<form action="syouhin_update.php" method="post" enctype="multipart/form-data">
	<p>番号:<?php echo $result["id"]; ?></p>
	<p>商品名:<?php echo $result["name"]; ?></p>
	<p>作者名:<?php echo $result["author"]; ?></p>
	<p>値段:<?php echo $result["money"]; ?>円</p>
	<p>数量:<input type="text" name="suuryou" value="<?php if(!empty($result['suuryou'])) echo (htmlspecialchars( $result['suuryou'],ENT_QUOTES,"UTF-8")); ?>">冊追加する</p>
	<p>紹介文<?php echo nl2br($result["text"]); ?></p>
	<?php
		session_start();
		session_regenerate_id(true);
		$_SESSION['id']=$result["id"];
	?>
	<input type="submit" value="追加する">
	<input type="button" onclick="history.back()" value="戻る">
	</form>
</body>
</html>