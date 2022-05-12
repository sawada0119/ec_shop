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
	
	$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name ");
	$stmt->bindParam(':id_name',$_SESSION["id_name"]);
	$stmt->execute();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>パスワードの変更</title>
	<link rel="stylesheet" href="kaiin_henkou_koumoku.css">
</head>
<body>
<?php if($_SESSION["pass_henkou"]): ?>
		<h3>変更後のパスワードを入力してください</h3>
		<div class="henkou">
		<form action="kaiin_henkou_update.php" method="post">
		パスワード<br>
		<input type="password" name="pass_henkou" size="20">
		<input type="submit" value="送信"><br>
		</form>
		<a href="kaiin_henkou.php">各種変更項目</a>
		<a href="TOP.php">TOP</a>
		<?php unset($_SESSION['pass_henkou']); ?>
		</div>
<?php else: ?>
		<h3>ID名とパスワードを入力してください</h3>
		<div class="henkou">
		<form action="kaiin_henkou_kakunin.php" method="post">
		ID名<br>
		<input type="text" name="id_name" size="20"><br>
		パスワード<br>
		<input type="password" name="pass_henkou" size="20"><br>
		<input type="submit" value="送信"><br>
		</form>
		<p>&nbsp;</p>
		<a href="kaiin_henkou.php">各種変更項目</a>
		<a href="TOP.php">TOP</a>
		</div>
<?php endif; ?>
</body>
</html>