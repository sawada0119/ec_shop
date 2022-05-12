<?php
	session_start();
	if(!isset($_SESSION['id_name'])):
		exit("直接アクセス禁止");
	endif;
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])):
		setcookie(session_name(), '', time()-1000);
	endif;
	session_destroy();
		header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/TOP.php");
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>TOP</title>
	<link rel="stylesheet" href="TOP.css">
</head>
<body>
	
</body>
</html>
