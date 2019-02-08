<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/search.css">
		<link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
		<title>GoodEaR 動手找幫助</title>
	</head>
	<body>
		<div class="wrapper">
			<div class="header">
				<a href="index.php">
					<img src="images/logo.png" alt="">
				</a>
			</div>
			<div class="content">
				<a href="factory.php">
					<div class="grave">
						<img src="css/images/factory2.png" alt="">
					</div>
				</a>
				<a href="medical.php">
					<div class="grave">
						<img src="css/images/medical2.png" alt="">
					</div>
				</a>
				<a href="school.php">
					<div class="grave">
						<img src="css/images/school2.png" alt="">
					</div>
				</a>
				<a href="welfare.php">
					<div class="grave">
						<img src="css/images/welfare2.png" alt="">
					</div>
				</a>
				<a href="grants.php">
					<div class="bone">
						<img src="css/images/grants.png" alt="">
					</div>
				</a>
				<div class="clear"></div>
				<div class="main-content">
					<div class="grants_info">
						<?php
							//連結伺服器
							$conn = mysqli_connect("localhost", "root", "a1033304", "GoodEar")
								or die("<p>連接失敗</p>");
							mysqli_select_db($conn, "GoodEar");
							mysqli_set_charset($conn, "UTF8");
						?>
						<table width="800px" border="1">
						  <tbody>
						  	<tr class="grants_info_title">
								<td width='100px'>縣市</td>
								<td width='210px'>機關</td>
								<td width='210px'>單位</td>
								<td width='210px'>電話</td>
								<td width='70px'>網頁</td>
							</tr>
							<?php
								//抓取資料庫內該公家機關資料 	
								$sql="SELECT * FROM `grants`";
								$grants=mysqli_query($conn,$sql);

								for($k=1;$k<=mysqli_num_rows($grants);$k++){
									$grants_array=mysqli_fetch_row($grants);
								  	echo "<tr>";
									echo "<td width='100px'>{$grants_array[1]}</td>";
									echo "<td width='210px'>{$grants_array[2]}</td>";
									echo "<td width='210px'>{$grants_array[3]}</td>";
									echo "<td width='210px'>{$grants_array[4]}</td>";
									echo "<td width='70px'><a href='{$grants_array[5]}'>連結</a></td>";
								  	echo "</tr>";
								} 
							?>
						  </tbody>
						</table>
					</div>
				</div>
				<footer>
					&#169;GoodEaR 動手找幫助 2017<br/>
				</footer>
			</div>
		</div>
        <div class="back" style="float: right;">
            <a href="learn_class.php"><img src="img/backlearn.png" alt="" width="150" class="button"></a> 
        </div>
		<div class="fixlogout">
            <a href="logout.php"><img src="img/logout.png" width="200px" ></img></a>
        </div>
	</body>
</html>
