<?php
	session_start();
	session_regenerate_id(true);

	$dbname='mysql:host=localhost;dbname=ec_shop;charset=utf8';
	$id='root';
	$pw='';
	try{
		$pdo= new PDO($dbname,$id,$pw,array(PDO::ATTR_EMULATE_PREPARES =>false));
	}
	catch(PDOException $e){
		exit('データベース接続失敗。'.$e->getMessage());
	}
	
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `id`=:id");
	
	$stmt->execute(array(':id'=>$_GET["id"]));
	$result=0;
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?php echo $result["name"]; ?>の商品追加</title>
</head>
<body>
	
	<p>番号:<?php echo $result["id"]; ?></p>
	<p><img width="100" src="<?php echo $result['img']; ?>" alt="商品画像"></p>
	<p>商品名:<?php echo $result["name"]; ?></p>
	<p>作者名:<?php echo $result["author"]; ?></p>
	<p>カテゴリー:<?php echo $result["category"]; ?></p>
	<p>ジャンル:<?php echo $result["genre"]; ?></p>
	<p>値段:<?php echo $result["money"]; ?>円</p>
	<p>紹介文<?php echo nl2br($result["text"]); ?></p>
	
	<form action="syouhin_henkou_update.php" method="post" enctype="multipart/form-data">
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
		値段<br>
		<input type="text" name="money" size="20">円<br>
		紹介文<br>
		<textarea name="text" cols="70" rows="10"></textarea><br>
		画像<br>
		<input type="file" name="file" accept="image/*"><br>
	<?php
		$_SESSION['id']=$result["id"];
	?>
	<input type="submit" value="編集">
	<input type="button" onclick="history.back()" value="戻る">
	</form>
</body>
</html>