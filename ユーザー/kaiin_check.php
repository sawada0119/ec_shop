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
	

?>
<DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>登録</title>
	<link rel="stylesheet" href="kaiintouroku.css">
</head>
<body>
<form action="kaiintourokukanryou.php" method="post">
	<p>こちらの内容で登録します。よろしければ登録ボタンを押してください</p>
	<p>ID名:<?php echo htmlspecialchars($name,ENT_QUOTES,"UTF-8") ?></p>
	<p>パスワード:<?php echo htmlspecialchars($pass,ENT_QUOTES,"UTF-8") ?></p>
	<p>メールアドレス:<?php echo htmlspecialchars($mail,ENT_QUOTES,"UTF-8") ?></p>
	<p>TEL:<?php echo htmlspecialchars($tel,ENT_QUOTES,"UTF-8") ?></p>
	
<?php
	session_start();
	session_regenerate_id(true);
	$_SESSION['name']=$_POST["name"];
	$_SESSION['pass']=$_POST["pass"];
	$_SESSION['mail']=$_POST["mail"];
	$_SESSION['tel']=$_POST["tel"];
?>

	<input type="submit" value="登録する">
	<input type="button" value="戻る" onclick="history.go(-1)">
	</form>
</body>
</html>