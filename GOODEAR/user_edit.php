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
		//連接資料庫
		$conn = mysqli_connect("localhost", "root", "a1033304", "GoodEar")
			or die("<p>連接失敗</p>");
		mysqli_select_db($conn, "GoodEar");
		mysqli_set_charset($conn, "UTF8");

		$id=$_COOKIE["id"];
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
				$sql="SELECT * FROM `User` WHERE User_id='$id'";
				$result=mysqli_query($conn,$sql);

				for($i=1;$i<=mysqli_num_rows($result);$i++)
					$rs=mysqli_fetch_row($result);

//印出使用者資料
print <<< us_info
				<form action="user.php" method="get">
					<div class="info_det">
					<img src="images/us_name.png">
					<input type='text' name='us_name' value={$rs[0]}(不能修改唷)  
						readonly="readonly"><br/><br/></div>
					<div class="info_det">
					<img src='images/us_sex.png'>
					<input type="radio" name="us_sex" value="帥氣氣男孩"
						style="width:5%; height=25px";>
						<div class="sex">男孩</div>
					<input type="radio" name="us_sex" value="水噹噹女孩"
						style="width:5%; height=25px";>
						<div class="sex">女孩</div><br/><br/></div>
					<div class="info_det">
					<img src='images/us_birthday.png'>
					<input class='input' type='text' name="us_birthday" 
						value='範例格式: 1996/01/01' style='margin-top: 0;'
						onmouseover="this.style.borderColor='#FF6600'"
						onmouseout="this.style.borderColor=''" 
						onFocus="if (value =='範例格式: 1996/01/01'){value =''}"
						onBlur="if (placeholder ==''){placeholder='範例格式: 1996/01/01'}"><br/><br/></div>
					<div class="info_det">
					<img src="images/us_email.png">
					<input class='input' type='text' name="us_email" value='{$rs[2]}'
						style='margin-top: 0;'
						onmouseover="this.style.borderColor='#FF6600'"
						onmouseout="this.style.borderColor=''" 
						onFocus="if (value =='{$rs[2]}'){value =''}"
						onBlur="if (placeholder ==''){placeholder='$rs[2]'}"><br/><br/></div>
					
					<input type="submit" value="送出" style="width: 20%; margin: 0 10% 0 20%;" />
					<input type="button" onclick="javascript:location.href='user.php'" 	value="取消" style="width: 20%;" />
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