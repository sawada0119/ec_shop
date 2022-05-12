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
	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>角川文庫カテゴリー</title>
	<link rel="stylesheet" href="kensaku.css">
</head>
<body>
	<header>
		<ul>
			<li><a href="kadokawa_category.php">角川文庫</a></li>
			<li><a href="iwanami_category.php">岩波文庫</a></li>
			<li><a href="hayakawa_category.php">ハヤカワ文庫</a></li>
		</ul>
	</header>
	<form action="kensaku.php" method="post">
		<input type="text" name="keyword" size="50">
		<input type="submit" value="検索">
	</form>
	</header>
	
<?php	
		if(isset($_SESSION["id_name"])):
?>
	<div class="kaiin">
	<p><?php echo $_SESSION["id_name"]; ?>様</p>
	<form action="logout.php" method="post">
		<input type="submit" value="ログアウト">
	</form>
	</div>
<?php
		else:
?>
	<div class="gest">
	<p>ゲスト様</p>
	<form action="login.htm" method="post">
		<input type="submit" value="ログイン">
	</form>
	</div>
<?php 
		endif;
?>
	<div class="syouhin_mune">
<?php
	$category="角川文庫";
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `category`=:category");
	$stmt->bindParam(':category',$category);
	$stmt->execute();
	$result=$stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $shop){
?>
	<p><?php echo "<a href=kounyuu.php?id=".$shop["id"].">"; ?><img width="200" src="<?php echo htmlspecialchars($shop['img'],ENT_QUOTES,'UTF-8'); ?>" alt="商品画像"></a><br>
	商品名:<?php echo "<a href=kounyuu.php?id=".$shop["id"].">"; ?><?php echo htmlspecialchars($shop['name'],ENT_QUOTES,'UTF-8'); ?></a><br>
	値段:<?php echo htmlspecialchars($shop['money'],ENT_QUOTES,'UTF-8'); ?>円<br>
	数量:<?php echo htmlspecialchars($shop['suuryou'],ENT_QUOTES,'UTF-8'); ?>個</p>
	<?php }
	$stmt=null;
?>
	</div>
	<div class="koumoku">
		<a href="TOP.php">TOP</a>
	</div>
</body>
</html>