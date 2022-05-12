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
	
	$errors=array();
	
	
	//パスワード
	if(isset($_POST["pass_henkou"])):
		$pass=null;
		if(!isset($_POST["pass_henkou"]) || !strlen($_POST["pass_henkou"])):
			$errors["pass_henkou"]="変更するパスワードを入力してください";
		else:
			$pass=$_POST["pass_henkou"];
		endif;
	
		if(count($errors)===0):
			$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
			$stmt->bindParam(':id_name',$_SESSION["id_name"]);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$stmt=null;
	//UPDATE
			$passhash=password_hash($pass,PASSWORD_DEFAULT);
			$sql = 'UPDATE `kaiin` SET `pass`=:pass WHERE `id_name`=:id_name';
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':pass',$passhash);
			$stmt->bindParam(':id_name',$_SESSION['id_name']);
			$stmt->execute();
			$stmt=null;
		endif;
		
	//メールアドレス
	elseif(isset($_POST["mail_henkou"])):
		$mail=null;
		$mailmatch="/^[a-zA-Z0-9]+[a-zA-Z0-9\._-]*@[a-zA-Z0-9_-]+.[a-zA-Z0-9\._-]+$/";
		if(!isset($_POST["mail_henkou"]) || !strlen($_POST["mail_henkou"])):
			$errors["mail_henkou"]="アドレスを入力してください";
		elseif(strlen($_POST["mail_henkou"])>50):
			$errors["mail_henkou"]="アドレスは５０字以内で入力してください";
		elseif(!(preg_match($mailmatch,$_POST["mail_henkou"]))):
			$errors["mail_henkou"]="メールアドレスの形式が正しくありません";
		else:
			$mail=$_POST["mail_henkou"];
		endif;
		
		if(count($errors)===0):
			$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
			$stmt->bindParam(':id_name',$_SESSION["id_name"]);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$stmt=null;
	//UPDATE
			$sql = 'UPDATE `kaiin` SET `mail`=:mail WHERE `id_name`=:id_name';
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':mail',$mail);
			$stmt->bindParam(':id_name',$_SESSION['id_name']);
			$stmt->execute();
			$stmt=null;
		endif;
		
	//郵便番号・住所
	elseif(isset($_POST["postal_code_henkou"]) && ($_POST["address_henkou"])):
		$postal_code=null;
		if(!isset($_POST["postal_code_henkou"]) || !strlen($_POST["postal_code_henkou"])):
			$errors["postal_code_henkou"]="変更する郵便番号を入力してください";
		else:
			$postal_code=$_POST["postal_code_henkou"];
		endif;
		$address=null;
		if(!isset($_POST["address_henkou"]) || !strlen($_POST["address_henkou"])):
			$errors["address_henkou"]="変更する住所を入力してください";
		else:
			$address=$_POST["address_henkou"];
		endif;
		
		if(count($errors)===0):
			$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
			$stmt->bindParam(':id_name',$_SESSION["id_name"]);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$stmt=null;
	//UPDATE
			$sql = 'UPDATE `kaiin` SET `postal_code`=:postal_code,`address`=:address WHERE `id_name`=:id_name';
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':postal_code',$postal_code);
			$stmt->bindParam(':address',$address);
			$stmt->bindParam(':id_name',$_SESSION['id_name']);
			$stmt->execute();
			$stmt=null;
		endif;
		
	//電話番号
	elseif(isset($_POST["tel_henkou"])):
		$pass=null;
		if(!isset($_POST["tel_henkou"]) || !strlen($_POST["tel_henkou"])):
			$errors["tel_henkou"]="変更する電話番号を入力してください";
		else:
			$tel=$_POST["tel_henkou"];
		endif;
	
		if(count($errors)===0):
			$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
			$stmt->bindParam(':id_name',$_SESSION["id_name"]);
			$stmt->execute();
			$result=$stmt->fetch(PDO::FETCH_ASSOC);
			$stmt=null;
	//UPDATE
			$sql = 'UPDATE `kaiin` SET `tel`=:tel WHERE `id_name`=:id_name';
			$stmt = $pdo -> prepare($sql);
			$stmt->bindParam(':tel',$tel);
			$stmt->bindParam(':id_name',$_SESSION['id_name']);
			$stmt->execute();
			$stmt=null;
		endif;
	endif;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品追加登録</title>
</head>
<body>
	<?php if (count($errors)): ?>
	<ul class="error_list">
		<?php foreach($errors as $error): ?>
		<li>
			<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
		</li>
		<?php endforeach; ?>
		<p><a href="kaiin_henkou.php">各種変更項目</a></p>
		<p><a href="TOP.php">TOP</a></p>
	</ul>
	<?php elseif(isset($pass)): ?>
		<p>こちらの内容で変更しました。</p>
		<p>パスワード:<?php echo htmlspecialchars($_POST["pass_henkou"],ENT_QUOTES,"UTF-8") ?></p>
		<p><a href="kaiin_henkou.php">会員情報変更ページへ</a></p>
		<p><a href="TOP.php">TOP</a></p>
	<?php elseif(isset($mail)): ?>
		<p>こちらの内容で変更しました。</p>
		<p>メールアドレス:<?php echo htmlspecialchars($mail,ENT_QUOTES,"UTF-8") ?></p>
		<p><a href="kaiin_henkou.php">会員情報変更ページへ</a></p>
		<p><a href="TOP.php">TOP</a></p>
	<?php elseif(isset($postal_code) && ($address)): ?>
		<p>こちらの内容で変更しました。</p>
		<p>郵便番号:<?php echo htmlspecialchars($postal_code,ENT_QUOTES,"UTF-8") ?></p><br>
		<p>住所:<?php echo htmlspecialchars($address,ENT_QUOTES,"UTF-8") ?></p>
		<p><a href="kaiin_henkou.php">会員情報変更ページへ</a></p>
		<p><a href="TOP.php">TOP</a></p>
	<?php elseif(isset($tel)): ?>
		<p>こちらの内容で変更しました。</p>
		<p>電話番号:<?php echo htmlspecialchars($tel,ENT_QUOTES,"UTF-8") ?></p>
		<p><a href="kaiin_henkou.php">会員情報変更ページへ</a></p>
		<p><a href="TOP.php">TOP</a></p>
	<?php endif; ?>
</body>
</html>