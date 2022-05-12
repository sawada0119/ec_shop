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
	$id_name=null;
	if(!isset($_POST["id_name"]) || !strlen($_POST["id_name"])):
		$errors["id_name"]="ID名が入力されていません";
		elseif(strlen($_POST["id_name"])>20):
		$errors["id_name"]="ID名は２０字以内で入力してください";
		else:
		$name=$_POST["id_name"];
		
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
	//メールアドレス
	$mail=null;
	$mailmatch="/^[a-zA-Z0-9]+[a-zA-Z0-9\._-]*@[a-zA-Z0-9_-]+.[a-zA-Z0-9\._-]+$/";
	if(!isset($_POST["mail"]) || !strlen($_POST["mail"])):
		$errors["mail"]="アドレスを入力してください";
	elseif(strlen($_POST["mail"])>50):
		$errors["mail"]="アドレスは５０字以内で入力してください";
	elseif(!(preg_match($mailmatch,$_POST["mail"]))):
		$errors["mail"]="メールアドレスの形式が正しくありません";
	else:
		$mail=$_POST["mail"];
	endif;
	//郵便番号
	$postal_code=null;
	if(!isset($_POST["postal_code"]) || !strlen($_POST["postal_code"])):
		$errors["postal_code"]="郵便番号が入力されていません";
		elseif(strlen($_POST["postal_code"])>20):
		$errors["postal_code"]="郵便番号が入力上限に達しています";
		else:
		$postal_code=$_POST["postal_code"];
		
	endif;
	//住所
	$address=null;
	if(!isset($_POST["address"]) || !strlen($_POST["address"])):
		$errors["address"]="住所が入力されていません";
		elseif(strlen($_POST["address"])>20):
		$errors["address"]="住所は１００字以内で入力してください";
		else:
		$address=$_POST["address"];
		
	endif;
	//TEL
	$tel=null;
	if(!isset($_POST["tel"]) || !strlen($_POST["tel"])):
		$errors["tel"]="TELを入力してください";
	elseif(!(strlen($_POST["tel"])==10 || strlen($_POST["tel"])==11 )):
		$errors["tel"]="TELは１０字または１１字で入力してください";
	else:
		$tel=$_POST["tel"];
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
		<div>
	<h2>会員登録</h2>
	
<?php if (count($errors)): ?>
		<ul>
<?php foreach($errors as $error): ?>
			<li>
<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
			</li>
<?php endforeach; ?>
		</ul>
	<input type="button" value="戻る" onclick="history.go(-1)">
	<p class="header"><a href="TOP.php">TOPへ</a></p>
	</div>
	
<?php else: ?>
	<div>
		<form action="kaiintourokukanryou.php" method="post">
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
					<tr>
						<p><th>メールアドレス</th>
						<td><?php echo htmlspecialchars($mail,ENT_QUOTES,"UTF-8") ?></td></p><br>
					</tr>
					<tr>
						<p><th>郵便番号</th>
						<td><?php echo htmlspecialchars($postal_code,ENT_QUOTES,"UTF-8") ?></td></p><br>
					</tr>
					<tr>
						<p><th>住所</th>
						<td><?php echo htmlspecialchars($address,ENT_QUOTES,"UTF-8") ?></td></p><br>
					</tr>
					<tr>
						<p><th>TEL</th>
						<td><?php echo htmlspecialchars($tel,ENT_QUOTES,"UTF-8") ?></td></p>
					</tr>
				</table>
<?php
	session_start();
	session_regenerate_id(true);
	$_SESSION['id_name']=$_POST["id_name"];
	$_SESSION['pass']=$_POST["pass"];
	$_SESSION['mail']=$_POST["mail"];
	$_SESSION['postal_code']=$_POST["postal_code"];
	$_SESSION['address']=$_POST["address"];
	$_SESSION['tel']=$_POST["tel"];
?>
			<input type="submit" value="会員登録">
			<input type="button" value="戻る" onclick="history.go(-1)">
		</form>
	<div>
<?php endif; ?>
</body>
</html>