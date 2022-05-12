<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品登録</title>
	<link rel="stylesheet" href="kaiintouroku.css">
</head>
<body>
	<div>
	<h2>登録</h2>
	<form action="syouhintouroku_kanryou.php" method="post" enctype="multipart/form-data">
		商品名<br>
		<input type="text" name="name" size="20"><br>
		作者<br>
		<input type="text" name="author" size="20"><br>
		文庫カテゴリー<br>
		<input type="radio" name="category" value="角川文庫">角川文庫
		<input type="radio" name="category" value="岩波文庫">岩波文庫
		<input type="radio" name="category" value="ハヤカワ文庫">ハヤカワ文庫<br>
		ジャンル<br>
		<input type="checkbox" name="genre[]" value="哲学">哲学
		<input type="checkbox" name="genre[]" value="SF">SF
		<input type="checkbox" name="genre[]" value="ミステリー">ミステリー
		<input type="checkbox" name="genre[]" value="サスペンス">サスペンス
		<input type="checkbox" name="genre[]" value="アクション">アクション
		<input type="checkbox" name="genre[]" value="ホラー">ホラー<br>
		数量<br>
		<input type="text" name="suuryou" size="20">冊<br>
		値段<br>
		<input type="text" name="money" size="20">円<br>
		紹介文<br>
		<textarea name="text" cols="70" rows="10"></textarea><br>
		画像<br>
		<input type="file" name="file" accept="image/*"><br>
		<input type="submit" value="確認"><br>
	</form>
	</div>
</body>
</html>