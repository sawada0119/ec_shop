<?php
	session_start();
	if(!isset($_SESSION['name'])):
		exit("直接アクセス禁止");
	endif;
	$_SESSION=array();
	if(isset($_COOKIE[session_name()])):
		setcookie(session_name(),'',time()-1000);
	endif;
	session_destroy();
?>
<!DOCTYPE html>
<head>
	<meta charset="UTF-8">
	<title>ログアウト</title>
</head>
<body>
	<p>ログアウトしました</p>
	<p><a href="staff_login.htm">ログイン画面へ</a></p>
</body>
</html>