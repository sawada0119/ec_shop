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
	//ID名
	$id_name=null;
	if(!isset($_POST["id_name"]) || !strlen($_POST["id_name"])):
		$errors["id_name"]="ID名が入力されていません";
	elseif(!($_POST["id_name"]===$_SESSION["id_name"])):
		$errors["id_name"]="ID名が間違っています";
	else:
		$name=$_POST["id_name"];
	endif;
	//パスワード
	$pass=null;
	if(!isset($_POST["pass"]) || !strlen($_POST["pass"])):
		$errors["pass"]="パスワードが入力されていません";
	elseif(!($_POST["pass"]===$_SESSION["pass"])):
		$errors["pass"]="パスワードが間違っています";
	else:
		$pass=$_POST["pass"];
	endif;
?>
<DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>退会</title>
	<link rel="stylesheet" href="kaiintouroku.css">
</head>
<body>
<?php if (count($errors)): ?>
		<div>
		<ul class="error_list">
		<?php foreach($errors as $error): ?>
		<li>
			<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
		</li>
		<?php endforeach; ?>
		</ul>
	<h2>退会</h2>
	<form action="kaiin_sakujo_kakunin.php" method="post">
		<table>
			<tr>
				<th><label for="name">ID名</label></th>
				<td>ID名を入力してください<br>
				<input type="text" name="id_name" size="20"><br>
				</td>
			</tr>
			<tr>
				<th><label for="pass">パスワード</label></th>
				<td>パスワードを入力してください<br>
				<p><input type="password" name="pass" size="20"><br>
				</td>
			</tr>
			<tr>
				<th colspan="2"><input type="submit" value="退会する"></th>
			</tr>
		</table>
	</form>
	<p><a href="TOP.php">TOPへ</a></p>
	</div>
	</ul>
<?php else: ?>
	<div>
		<form action="kaiin_delete.php" >
			<p>本当に退会しますか？</p>
			<input type="submit" value="退会する">
			<p><a href="TOP.php">TOPへ</a></p>
		</form>
	</div>
<?php endif; ?>
</body>
</html>