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
	$name=null;
	if(!isset($_POST["name"]) || !strlen($_POST["name"])):
		$errors["name"]="商品名を入力してください";
		elseif(strlen($_POST["name"])>50):
		$errors["name"]="商品名は５０字以内で入力してください";
		else:
		$name=$_POST["name"];
	endif;
	//作者名
	$author=null;
	if(!isset($_POST["author"]) || !strlen($_POST["author"])):
		$errors["author"]="作者名を入力してください";
		elseif(strlen($_POST["author"])>50):
		$errors["author"]="作者名は５０字以内で入力してください";
		else:
		$author=$_POST["author"];
	endif;
	//カテゴリー
	$category=null;
	if(!isset($_POST["category"])):
		$errors["category"]="カテゴリーを選択してください";
	else:
		$category=$_POST["category"];
	endif;
	//ジャンル
	$genre=null;
	if(!isset($_POST["genre"])):
		$errors["genre"]="ジャンルを選択してください";
	else:
		$genre=$_POST["genre"];
		$genre_csv=implode(',',$genre);
	endif;
	//数量
	$suuryou=null;
	if(!isset($_POST["suuryou"]) || !strlen($_POST["suuryou"])):
		$errors["suuryou"]="数量を入力してください";
	else:
		$suuryou=$_POST["suuryou"];
	endif;
	//値段
	$money=null;
	if(!isset($_POST["money"]) || !strlen($_POST["money"])):
		$errors["money"]="値段を入力してください";
	else:
		$money=$_POST["money"];
	endif;
	//紹介文
	$text=null;
	if(!isset($_POST["text"]) || !strlen($_POST["text"])):
		$errors["text"]="紹介文を入力してください";
	elseif(strlen($_POST["text"])>500):
		$errors["text"]="紹介文は５００文字以内で入力してください";
	else:
		$text=$_POST["text"];
	endif;
	//画像
	if($_FILES["file"]["error"]):
		exit("ファイル送信エラー");
	endif;

	$images_name=$_FILES["file"]["name"];
	$images_tmp=$_FILES["file"]["tmp_name"];
	$filename="images/".$images_name;
	
	if(!(@move_uploaded_file($images_tmp,$filename))):
	exit("ファイル保存エラー");
	else:
	copy($filename,"/xampp/htdocs/制作 ec_shop/ユーザー/images/".$images_name);
	endif;
	
	if(count($errors)===0):
	$stmt = $pdo -> prepare('INSERT INTO `syouhin` (`name`,`author`,`category`,`genre`,`suuryou`,`money`,`text`,`img`) VALUES (:name,:author,:category,:genre,:suuryou,:money,:text,:img)');
		$stmt -> bindParam(':name',$name);
		$stmt -> bindParam(':author',$author);
		$stmt -> bindParam(':category',$category);
		$stmt -> bindParam(':genre',$genre_csv);
		$stmt -> bindParam(':suuryou',$suuryou);
		$stmt -> bindParam(':money',$money);
		$stmt -> bindParam(':text',$text);
		$stmt -> bindParam(':img',$filename);
		$stmt->execute();
		$stmt=null;
	$pdo=null;
	endif;
?>
<DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>商品登録</title>
	<link rel="stylesheet" href="">
</head>
<body>
<?php if (count($errors)): ?>
	<ul class="error_list">
		<?php foreach($errors as $error): ?>
		<li>
			<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?>
		</li>
		<?php endforeach; ?>
		<li><input type="button" onclick="history.back()" value="戻る"></li>
	</ul>
<?php else: ?>
	<p>こちらの内容で登録しました。</p>
	<p>商品名:<?php echo htmlspecialchars($name,ENT_QUOTES,"UTF-8") ?></p>
	<p>作者名:<?php echo htmlspecialchars($author,ENT_QUOTES,"UTF-8") ?></p>
	<p>カテゴリー:<?php echo htmlspecialchars($category,ENT_QUOTES,"UTF-8") ?></p>
	<p>ジャンル:<?php echo htmlspecialchars($genre_csv,ENT_QUOTES,"UTF-8") ?></p>
	<p>数量:<?php echo htmlspecialchars($suuryou,ENT_QUOTES,"UTF-8") ?>冊</p>
	<p>値段:<?php echo htmlspecialchars($money,ENT_QUOTES,"UTF-8") ?>円</p>
	<p>紹介文:<?php echo htmlspecialchars($text,ENT_QUOTES,"UTF-8") ?></p>
	<p>画像:<img width="100" src="<?php echo $filename; ?>" alt=""></p>
	<p><a href="kanri_page.php">管理ページへ</a></p>
	<input type="button" onclick="history.back()" value="戻る">
<?php endif; ?>
</body>
</html>