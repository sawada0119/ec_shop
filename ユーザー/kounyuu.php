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
	$stmt=null;
	
	$errors=array();
	if($_SERVER["REQUEST_METHOD"]==="POST"):
	//ID名
	$name=null;
	if(!isset($_POST["user_name"]) || !strlen($_POST["user_name"])):
		$errors["user_name"]="名前が入力されていません";
		elseif(strlen($_POST["user_name"])>20):
		$errors["user_name"]="名前は２０字以内で入力してください";
		else:
		$user_name=$_POST["user_name"];
	endif;
	//件名
	$name=null;
	if(!isset($_POST["title"]) || !strlen($_POST["title"])):
		$errors["title"]="件名が入力されていません";
		elseif(strlen($_POST["title"])>50):
		$errors["title"]="件名は５０字以内で入力してください";
		else:
		$title=$_POST["title"];
	endif;
	//コメント
	$name=null;
	if(!isset($_POST["comment"]) || !strlen($_POST["comment"])):
		$errors["comment"]="コメントが入力されていません";
		elseif(strlen($_POST["comment"])>300):
		$errors["comment"]="コメントは３００字以内で入力してください";
		else:
		$comment=$_POST["comment"];
	endif;
	
	if(count($errors)===0):
		$date=date('Y-m-d H:i:s');
		$stmt = $pdo -> prepare("INSERT INTO `comment` (`name`,`user_name`,`title`,`comment`,`created_at`) VALUES (:name,:user_name,:title,:comment,:created_at)");
		$stmt->bindParam(':name',$result["name"]);
		$stmt->bindParam(':user_name',$user_name);
		$stmt->bindParam(':title',$title);
		$stmt->bindParam(':comment',$comment);
		$stmt->bindParam(':created_at',$date);
		$stmt->execute();
		$stmt=null;
	endif;
	endif;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title><?php echo $result["name"]; ?>の検索結果</title>
	<link rel="stylesheet" href="kounyuu.css">
</head>
<body>
	<header>
		<ul>
			<li><a href="kadokawa_category.php">角川文庫</a></li>
			<li><a href="iwanami_category.php">岩波文庫</a></li>
			<li><a href="hayakawa_category.php">ハヤカワ文庫</a></li>
		</ul>
	</header>
	<form class="kensaku" action="kensaku.php" method="post">
		<input type="text" name="keyword" size="50">
		<input type="submit" value="検索">
		</form>
	<?php if(isset($_SESSION["id_name"])): ?>
		<div class="kaiin">
		<?php echo $_SESSION["id_name"]; ?>様
		<form action="logout.php" method="post">
			<input type="submit" value="ログアウト">
		</form>
		</div>
	<?php else: ?>
		<div class="gest">
		ゲスト様
		<form action="login.htm" method="post">
			<input type="submit" value="ログイン">
		</form>
		</div>
	<?php endif; ?>
		<form class="syouhin" action="syouhin_kounyuu.php" method="post">
			<div class="img">
				<p><img width="250" src="<?php echo $result['img']; ?>" alt="商品画像"></p>
			</div>
			<input type="hidden" value=<?php echo $result["id"]; ?> >
			<div class="koumoku">
				<p>商品名:<?php echo $result["name"]; ?></p>
				<p>値段:<?php echo $result["money"]; ?>円</p>
				<p>在庫:<?php echo $result["suuryou"]; ?>個</p>
				<p>紹介文:<br><?php echo nl2br($result["text"]); ?></p>
				<p>購入数量:<input type="text" name="kounyuusuu" style="width:25px;">個</p>
			
<?php
				$_SESSION['id']=$result["id"];
				$_SESSION["suuryou"]=$result["suuryou"];
?>
				<input type="submit" value="購入確認画面へ">
				<input type="button" onclick="history.back()" value="商品一覧へ戻る">
			</div>
		</form>
	
	
	<div class="comment">
		<h3 class="kansou_title"><?php echo $result["name"]; ?>のレビュー</h3>
		
		<?php if (count($errors)): ?>
		<ul class="error">
	<?php foreach($errors as $error): ?>
			<li>
				<font color="red"><?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8") ?></font>
			</li>
	<?php endforeach; ?>
		</ul>
		
	<?php endif; ?>
		
		<form action="#" method="post">
			名　前　：<input type="text" name="user_name"><br>
			件　名　：<input type="text" name="title"><br>
			コメント：<textarea type="text" name="comment" cols="30" rows="6"></textarea><br>
			<input type="submit" value="レビューの投稿">
			
		</form>
<?php
		$stmt=$pdo->prepare("SELECT * FROM `comment` WHERE `name`=:name");
		$stmt->bindParam(':name',$result["name"]);
		$stmt->execute();
		$result_2=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>
		<div class="kansou">
<?php foreach($result_2 as $post){ ?>
				<?php echo htmlspecialchars($post["user_name"],ENT_QUOTES,"UTF-8"); ?>さん<br>
				<b><?php echo htmlspecialchars($post["title"],ENT_QUOTES,"UTF-8"); ?></b><br>
				<?php echo nl2br(htmlspecialchars($post["comment"],ENT_QUOTES,"UTF-8")); ?><br>
				<?php echo htmlspecialchars($post["created_at"],ENT_QUOTES,"UTF-8"); ?><br>
				--------------------------------------------------------<br>
<?php
 }
$_SESSION["name"]=$result["name"];
 ?>
 		</div>
 	</div>
 	<p class="header"><a href="TOP.php">TOP</a></p>
</body>
</html>