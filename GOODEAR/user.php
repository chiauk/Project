<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GoodEaR 開口學發音</title>
	<link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
	<link rel="stylesheet" href="css/all.css">
</head>
<body>
	<?php
		//連結資料庫
		$conn = mysqli_connect("localhost", "root", "a1033304", "GoodEar")
			or die("<p>連接失敗</p>");
		mysqli_select_db($conn, "GoodEar");
		mysqli_set_charset($conn, "UTF8");

		$id=$_COOKIE["id"];

		//若有讀取到使用者資訊則更新
		if($_GET['us_sex'] != NULL ){
			$us_sex=$_GET['us_sex'];
			$sql="UPDATE `User` SET `User_sex`= '$us_sex' WHERE `User_id`='$id'";
			mysqli_query($conn,$sql);
		}
		if($_GET['us_birthday'] != NULL ){
			$us_birthday=$_GET['us_birthday'];
			$sql="UPDATE `User` SET `User_bd`= '$us_birthday' WHERE `User_id`='$id'";
			mysqli_query($conn,$sql);
		}
		if($_GET['us_email'] != NULL ){
			$us_email=$_GET['us_email'];
			$sql="UPDATE `User` SET `User_email`= '$us_email' WHERE `User_id`='$id'";
			mysqli_query($conn,$sql);
		}
	?>
	<div class="wrap">
		<div class="header">
			<a href="index.php">
				<img src="\images\logo2.png" alt="logo2"></a>
			<div class="bar">
				<a href="factory.php">
					<img src="\images\magnifier.png" alt="" class="button"></a>
				<a href="collection.php">
					<img src="\images\book.png" style="margin-top: 25px;" class="button"></a>
				<a href="learn_class.php">
					<img src="\images\bear.png" alt="" class="button"></a>
				<a href="user.php">
					<img src="\images\us_info.png" style="margin-top: 15px;" class="button"></a>
			</div>
		</div>
		<div class="content">
			<div class="progress">
			<?php 
				$us_id=$_COOKIE["id"];

				//計算使用者已學習字彙數
				$sql="SELECT COUNT(*) FROM info_know WHERE `User_id`='$us_id'";
				$result=mysqli_query($conn,$sql);
				for($j=1;$j<=mysqli_num_rows($result);$j++){
					$num_know=mysqli_fetch_row($result);
				}

				//計算資料庫所有字彙數
				$sql="SELECT COUNT(*) FROM info";
				$result=mysqli_query($conn,$sql);
				for($j=1;$j<=mysqli_num_rows($result);$j++){
					$num_all=mysqli_fetch_row($result);
				}

				//計算使用者學習進度
				$sum = ($num_know[0]/$num_all[0])*100;
				echo "<h1>".floor($sum)."%</h1>";
			?>
			</div>
			<div class="us_info">
			<?php
				if ($_COOKIE["id"]!=null) {
                	$id=$_COOKIE["id"];
                }else{
                	$id="管理員是你yo";
                }

				$conn = mysqli_connect("localhost", "root", "a1033304", "GoodEar")
					or die("<p>連接失敗</p>");
				mysqli_select_db($conn, "GoodEar");
				mysqli_set_charset($conn, "UTF8");

				$sql="SELECT * FROM `User` WHERE User_id='$id'";
				$result=mysqli_query($conn,$sql);

				for($i=1;$i<=mysqli_num_rows($result);$i++)
					$rs=mysqli_fetch_row($result);

				if($rs[0]==NULL)
					$rs[0]='管理者大大安安';
				if($rs[2]==NULL)
					$rs[2]='管理者大大安安';	
				if($rs[3]==NULL)
					$rs[3]='快點擊【我要修改】編輯唷';
				if($rs[4]==NULL)
					$rs[4]='快點擊【我要修改】編輯唷';

//印出使用者資料
print <<< us_info
				<form action="user.php" method="post">
					<div class="info_det">
					<img src="images/us_name.png">
					<input type='text' name='us_name' value={$rs[0]} 
						readonly="readonly"><br/><br/></div>
					<div class="info_det">
					<img src='images/us_sex.png'>
					<input type='text' name='us_sex' value={$rs[3]} 
						readonly="readonly"><br/><br/></div>
					<div class="info_det">
					<img src='images/us_birthday.png'>
					<input type='text' name='us_birthday' value={$rs[4]} 
						readonly="readonly"><br/><br/></div>
					<div class="info_det">
					<img src="images/us_email.png">
					<input type='text' name='us_email' value={$rs[2]}
						readonly="readonly"><br/><br/></div>

					<input type="button" onclick="javascript:location.href='user_edit.php'" value="我要修改" style="width: 20%; margin-left: 50%;" />
				
				</form>
us_info;
			?>
			</div>
			
		</div>
		<div class="footer">
			
		</div>
	</div>
</body>
</html>