<?php
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
	$name=null;
	if(!isset($_POST["name"]) || !strlen($_POST["name"])):
		$errors["name"]="ID名が入力されていません";
		elseif(strlen($_POST["name"])>20):
		$errors["name"]="ID名は２０字以内で入力してください";
		else:
		$name=$_POST["name"];
	endif;
	//パスワード
	$pass=null;
	$pass_2=null;
	if(!isset($_POST["pass"]) || !strlen($_POST["pass"])):
		$errors["pass"]="パスワードが入力されていません";
	elseif(strlen($_POST["pass"])<6 || strlen($_POST["pass"])>12):
		$errors["pass"]="パスワードは６文字以上１２字以内で入力してください";
	else:
		if(!isset($_POST["pass_2"]) || !strlen($_POST["pass_2"])):
			$errors["pass_2"]="設定したパスワードを再度入力してください";
		elseif(!($_POST["pass_2"]===$_POST["pass"])):
			$errors["pass_2"]="設定したパスワードと一致しません";
		else:
			$pass=$_POST["pass"];
			
		endif;
	endif;
?>
<DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>登録</title>
	<link rel="stylesheet" href="kaiintouroku.css">
</head>
<body>
<?php if (count($errors)): ?>
		<div>
	<h2>会員登録</h2>
	<form action="staff_kaiintouroku.php" method="post">
		<table>
			<tr>
				<th><label for="name">ID名</label></th>
				<td>ID名を入力してください<br>
				<input type="text" name="name" size="20"><br>
				<?php 
				if($errors["name"]>=1):
				echo $errors["name"]; 
				endif; ?><br>
				</td>
			</tr>
			<tr>
				<th><label for="pass">パスワード</label></th>
				<td>パスワードを入力してください<br>
				<p><input type="password" name="pass" size="20"><br>
				<?php 
				if($errors["pass"]>=1):
				echo $errors["pass"]; 
				 ?><br>
				<p>パスワードを再度入力してください</p><br>
				
				<?php 
				else:
				if($errors["pass_2"]>=1):
				echo $errors["pass_2"]; 
				endif;
				endif; ?><br>
				<input type="password" name="pass_2" size="20"><br>
				</td>
			</tr>
			
			<tr>
				<th colspan="2"><input type="submit" value="登録情報のチェック"></th>
			</tr>
		</table>
		
	</form>
	<p><a href="top.htm">TOPへ</a></p>
	</div>
	</ul>
	
<?php else: ?>
	<div>
		<form action="staff_kaiintourokukanryou.php" method="post">
			<h3>こちらの内容で登録します。よろしければ登録ボタンを押してください</h3>
				<table>
					<tr>
						<th>ID名</th>
						<td><?php echo htmlspecialchars($name,ENT_QUOTES,"UTF-8") ?></td><br>
					</tr>
					<tr>
						<p><th>パスワード</th>
						<td><?php echo htmlspecialchars($pass,ENT_QUOTES,"UTF-8") ?></td></p><br>
					</tr>
				</table>
<?php
	session_start();
	session_regenerate_id(true);
	$_SESSION['name']=$_POST["name"];
	$_SESSION['pass']=$_POST["pass"];
?>
			<input type="submit" value="会員登録">
			<input type="button" value="戻る" onclick="history.go(-1)">
		</form>
	<div>
<?php endif; ?>
</body>
</html>