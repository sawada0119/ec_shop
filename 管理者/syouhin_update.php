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
	
	//数量
	$suuryou=null;
	if(!isset($_POST["suuryou"]) || !strlen($_POST["suuryou"])):
		$errors["suuryou"]="数量を入力してください";
	else:
		$suuryou=$_POST["suuryou"];
	endif;
	
	if(count($errors)===0):
	$stmt=$pdo->prepare("SELECT * FROM `syouhin` WHERE `id`=:id");
	$stmt->bindParam(':id',$_SESSION["id"]);
	$stmt->execute();
	$result=$stmt->fetch(PDO::FETCH_ASSOC);
	$stmt=null;
	//UPDATE
	$sql = 'UPDATE `syouhin` SET `suuryou`=:suuryou WHERE `id`=:id';
	$stmt = $pdo -> prepare($sql);
	$stmt->bindParam(':suuryou',$_POST['suuryou']);
	$stmt->bindParam(':id',$_SESSION['id']);
	$stmt->execute();
	$stmt=null;
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
		<li><input type="button" onclick="history.back()" value="戻る"></li>
	</ul>
<?php else: ?>
	<p>商品を追加しました。</p>
	
	<p>数量:<?php echo htmlspecialchars($suuryou,ENT_QUOTES,"UTF-8") ?>冊</p>
	<?php
		unset($_SESSION['id']);
	?>
	<p><a href="kanri_page.php">管理ページへ</a></p>
	<input type="button" onclick="history.back()" value="戻る">
<?php endif; ?>
</body>
</html>