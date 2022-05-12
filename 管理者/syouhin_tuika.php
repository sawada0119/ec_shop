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
	
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` ORDER BY `id` DESC");
	$stmt->execute();
	
	$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品追加</title>
</head>
<body>
<?php
	
	foreach($result as $shop){
?>
	<p>商品名:<?php echo $shop['name']; ?></p>
	<p>作者:<?php echo $shop['author']; ?></p>
	<p>カテゴリー:<?php echo $shop['category']; ?></p>
	<p>ジャンル:<?php echo $shop['genre']; ?></p>
	<p>値段:<?php echo $shop['money']; ?>円</p>
	<p>数量:<?php echo $shop['suuryou']; ?>個</p>
	<p><img width="100" src="<?php echo $shop['img']; ?>" alt="商品画像"></p>
	<?php echo "<a href=syouhin_tuika_kakunin.php?id=".$shop["id"].">追加</a>"; ?>
	<p>----------------------------</p>
<?php } ?>
</body>
</html>