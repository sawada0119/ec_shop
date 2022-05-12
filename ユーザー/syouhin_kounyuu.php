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
	
	$errors=array();
	
	//購入数量
	$kouynuusuu=null;
	if(!isset($_POST["kounyuusuu"]) || !strlen($_POST["kounyuusuu"])):
		$errors["kounyuusuu"]="購入する数量を入力してください";
	elseif($_POST["kounyuusuu"] > $_SESSION["suuryou"]):
		$errors["kounyuusuu"]="購入数量が在庫を超えています";
	else:
		$suuryou=$_POST["kounyuusuu"];
	endif;
	
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `id`=:id");
	$stmt->bindParam(':id',$_SESSION["id"]);
	$stmt->execute();
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt=null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>購入画面</title>
	<link rel="stylesheet" href="kounyuu_syouhin.css">
</head>
<body>
	<?php if (count($errors)): ?>
	<ul class="error_list">
		<?php foreach($errors as $error): ?>
		<li>
			<?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?>
		</li>
		<?php endforeach; ?>
		<li><input type="button" onclick="history.back()" value="戻る"></li>
	</ul>
<?php 
	elseif($_SESSION["id_name"]):
		$stmt=$pdo->prepare("SELECT * FROM `kaiin` WHERE `id_name`=:id_name");
		$stmt->bindParam(':id_name',$_SESSION["id_name"]);
		$stmt->execute();
		$result_2=$stmt->fetch(PDO::FETCH_ASSOC);
		$stmt=null;
?>
	<h2>購入画面</h2>
	<p class="kakunin">下記内容でお間違いないでしょうか？</p>
	<div class="okyakusama">
		<div class="jouhou">
			<p>お客様情報</p>
			<p><?php echo $result_2["id_name"]; ?>様</p>
			<p>メールアドレス:<?php echo $result_2["mail"]; ?></p>
			<p>郵便番号:<?php echo $result_2["postal_code"]; ?></p>
			<p>住所:<?php echo $result_2["address"]; ?></p>
			<p>電話番号:<?php echo $result_2["tel"]; ?></p>
		</div>
		<div class="okurisaki">
			<p>お届け先</p>
			<p><?php echo $result_2["id_name"]; ?></p>
			<p>郵便番号:<?php echo $result_2["postal_code"]; ?></p>
			<p>住所:<?php echo $result_2["address"]; ?></p>
			<p>電話番号:<?php echo $result_2["tel"]; ?></p>
			<a href="kaiin_henkou.php">情報の変更</a>
		</div>
	</div>
	<div class="kakunin">
		<form action="kounyuukanryou.php" method="post">
			<div class="syouhin">
				<p>ご注文内容</p>
				<p><img width="100" src="<?php echo $result['img']; ?>" alt="商品画像"></p>
				<p>商品名:<?php echo $result["name"]; ?></p>
				<p>購入数:<?php echo $_POST["kounyuusuu"]; ?>個</p>
				<p>金額:<?php echo $result["money"] * $_POST["kounyuusuu"]; ?>円</p>
			</div>
			<p>こちらの商品を購入しますか？よろしければ購入ボタンを押してください</p>
			<input type="submit" value="購入">
			<input type="button" onclick="history.back()" value="戻る">
		</form>
	</div>
	<header>
	<a href="TOP.php">TOP</a>
	</header>
	<?php 
		$i=$result["suuryou"] - $_POST["kounyuusuu"];
		$_SESSION["i"]=$i;
	else:
		header("Location: http://".$_SERVER['HTTP_HOST']."/制作 ec_shop/ユーザー/login.php");
	endif; ?>
</body>
</html>