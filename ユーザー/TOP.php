<?php
	session_start();
	unset($_SESSION['id_name_henkou']);
	unset($_SESSION['pass_henkou']);
	unset($_SESSION['mail_henkou']);
	unset($_SESSION['address_henkou']);
	unset($_SESSION['tel_henkou']);
	
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
	<title>TOP</title>
	<link rel="stylesheet" href="TOP.css">
</head>
<body>
	<header>
		<ul>
			<li><a class="category" href="kadokawa_category.php">角川文庫</a></li>
			<li><a class="category" href="iwanami_category.php">岩波文庫</a></li>
			<li><a class="category" href="hayakawa_category.php">ハヤカワ文庫</a></li>
		</ul>
	</header>
	<form class="kensaku" action="kensaku.php" method="post">
		<input type="text" name="keyword" size="50">
		<input type="submit" value="検索">
	</form>
<?php	
	if(isset($_SESSION["id_name"])):
?>
	<div class="kaiin">
		こんにちは、<?php echo $_SESSION["id_name"]; ?>様
		<form action="logout.php" method="post">
			<input type="submit" value="ログアウト">
		</form>
		<a href="kaiin_henkou.php">会員設定変更</a>
	</div>
<?php
	else:
?>
	<div class="gest">
		こんにちは、ゲスト様
		<form action="login.htm" method="post">
			<input type="submit" value="ログイン">
		</form>
		<p><a href="kaiintouroku.htm">会員登録をしてない方はこちら</a></p>
	</div>
	<?php endif; ?>
	<div class="main_mune">
<?php	
		$stmt=$pdo->prepare("SELECT * FROM `syouhin` ORDER BY RAND() LIMIT 4");
		$stmt->execute();
	
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
?>
		<p><?php echo "<a href=kounyuu.php?id=".$result["id"].">"; ?><img width="120" src="<?php echo htmlspecialchars($result['img'],ENT_QUOTES,'UTF-8'); ?>" alt="商品画像"></a><br>
		<?php echo "<a href=kounyuu.php?id=".$result["id"].">"; ?><?php echo htmlspecialchars($result['name'],ENT_QUOTES,'UTF-8'); ?></a><br>
		<?php echo htmlspecialchars($result['author'],ENT_QUOTES,'UTF-8'); ?><br>
		\<?php echo htmlspecialchars($result['money'],ENT_QUOTES,'UTF-8'); ?></p>
<?php 
	}
		$stmt=null;
?>
		</div>
	<h2 class="sf">SF作品</h2>
	<div class="sf_mune">
<?php	
		$genre="SF";
		$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `genre`=:genre ORDER BY RAND() LIMIT 3");
		$stmt->bindParam(':genre',$genre);
		$stmt->execute();
	
		while($result_2= $stmt->fetch(PDO::FETCH_ASSOC)){ 
?>
		<p><?php echo "<a href=kounyuu.php?id=".$result_2["id"].">"; ?><img width="120" src="<?php echo htmlspecialchars($result_2['img'],ENT_QUOTES,'UTF-8'); ?>" alt="商品画像"></a><br>
		<?php echo "<a href=kounyuu.php?id=".$result_2["id"].">"; ?><?php echo htmlspecialchars($result_2['name'],ENT_QUOTES,'UTF-8'); ?></a><br>
		<?php echo htmlspecialchars($result_2['author'],ENT_QUOTES,'UTF-8'); ?><br>
		\<?php echo htmlspecialchars($result_2['money'],ENT_QUOTES,'UTF-8'); ?></p>
	
<?php 
		}
		$stmt=null;
?>
	</div>
</body>
</html>
