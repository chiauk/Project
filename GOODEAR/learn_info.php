<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="Content-Script-Type" content="text/javascript" />
	<title>GoodEaR 開口學發音</title>
	<link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
	<link rel="stylesheet" href="css/all.css">
	<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('.border_in').hover(function(){
				$(this).addClass('i_know');
			}, function(){
				$(this).removeClass('i_know');
			}).click(function(){
				// 當點到標題時，若答案是隱藏時則顯示它；反之則隱藏
				$(this).next('.border_out').slideToggle();
			}).siblings('.border_out').hide();

			$('.border_in').show();


			$('.play').hover(function(){
				$(this).addClass('music');
			}, function(){
				$(this).removeClass('music');
			}).click(function(){
				// 當點到標題時，若答案是隱藏時則顯示它；反之則隱藏
				$(this).next('.hide').slideToggle();
			}).siblings('.hide').hide();

			$('.play').show();
		});
	</script>
	<script type="text/javascript">
		function disp_alert()
		{
		alert("收藏成功")
		}
	</script>
</head>
<body>
	<?php
		//連結伺服器
		$conn = mysqli_connect("localhost", "root", "a1033304", "GoodEar")
			or die("<p>連接失敗</p>");
		mysqli_select_db($conn, "GoodEar");//選擇資料庫
		mysqli_set_charset($conn, "UTF8");//以utf8讀取資料，讓資料可以讀取中文

		//接收字彙類別
		if($_GET['class']!=NULL){
			$class=$_GET['class'];
		}

		//執行收藏指令
		if($_GET['col']!=NULL){
			$col=$_GET['col'];
			$i="INSERT INTO `collect` (`col_id`, `info_id`, `class_id`, `col_note`) 
						VALUES (NULL, $col, $class, NULL)";
			mysqli_query($conn,$i);	
		}

		//執行更改學習進度紀錄指令(學習完成)
		if($_GET['i_know'] != NULL ){
			$us_id=$_GET['us_id'];
			$info_id=$_GET['info_id'];

			$sql="INSERT INTO `info_know` (`info_know_id`, `User_id`, `info_id`) VALUES (NULL, '$us_id', '$info_id')";

			mysqli_query($conn,$sql);
			header("Location: learn_info.php?class=$class");
		}

		//執行更改學習進度紀錄指令(尚須練習)
		if($_GET['dont_know'] != NULL ){
			$us_id=$_GET['us_id'];
			$info_id=$_GET['info_id'];

			$sql="DELETE FROM `info_know` 
				WHERE `info_id`='$info_id' && `User_id` = '$us_id'";

			mysqli_query($conn,$sql);
			header("Location: learn_info.php?class=$class");
		}
	?>
	<div class="wrap">
		<div class="header">
			<a href="index.php">
				<img src="\images\logo2.png" alt="logo2"></a>
			<div class="bar">
				<a href="factory.php">
					<img src="\images\magnifier.png" alt=""  class="button"></a>
				<a href="collection.php">
					<img src="\images\book.png" style="margin-top: 25px;"  class="button"></a>
				<a href="learn_class.php">
					<img src="\images\bear.png" alt=""  class="button"></a>
				<a href="user.php">
					<img src="\images\us_info.png" style="margin-top: 15px;"  class="button"></a>
			</div>
		</div>
		<div class="content">
			<div class="list">
				<?php
					//列出所有字彙類別
					$sql="SELECT * FROM `class`";
					$result=mysqli_query($conn,$sql);
						
					echo "<ul>";
					for($i=1;$i<=mysqli_num_rows($result);$i++){
						$rs=mysqli_fetch_row($result);
						echo "<a href='learn_info.php?class={$i}'><li>$rs[1]</li></a>";

					}
					echo "</ul>";
				?>
			</div>
			<div class="info">
				<table width="800" border="1">
					<?php
						//抓取該字彙類別內的所有資訊
						$sql="SELECT * FROM `info` WHERE `class_id`= $class";
						$result=mysqli_query($conn,$sql);

						for($i=1;$i<=mysqli_num_rows($result);$i++){
							$rs=mysqli_fetch_row($result);
					?>
				  <tbody><tr class="border_in">
					<td width="200px"><?php echo $i?></td>
					<td width="300px"><?php echo $rs[1]?></td>
					<td width="300px">
						<?php
							//點擊後傳遞執行收藏功能所需資訊
							echo "<a href='learn_info.php?col={$rs[0]}&&class={$class}'>";
						?>
							<img src="/images/collect.png" onclick="disp_alert()">
						</a>
						<img src="/images/record.png" onclick="window.open('record.php', 'record', config='height=500,width=500');" >
						<img class="play" src="/images/play.png" alt="" >

						<div class="hide">
							<?php
								//字彙範例音檔撥放
								echo "<embed src='/sound/o{$class}_{$rs[0]}.mp3' 
									volume='100' width='0' height='0' />"
							?>
						</div>
					</td>
				  </tr>
				  <tr class="border_out">
					<td width="200px"></td>
					<td width="300px"><?php echo $rs[2]?></td>	
					<td width="280px">
						<?php
							//抓取使用者該字彙學習是否完成
							$id=$_COOKIE["id"];
							$sql="SELECT * FROM `info_know` 
								WHERE `User_id` = '$id' && `info_id` = '$rs[0]'";
							$result_know2=mysqli_query($conn,$sql);

							for($k=1;$k<=mysqli_num_rows($result_know2);$k++)
								$rs_know2=mysqli_fetch_row($result_know2);

							//若學習已完成則印出
							if($rs_know2[0] != NUll){
						?>
								<form method="get" action="learn_info.php">
									<?php 
										echo "<input type='hidden' name='class' 
											value= {$class} >"; 
										echo "<input type='hidden' name='us_id' 
											value= {$id} >";
										echo "<input type='hidden' name='info_id' 
											value= {$rs[0]} >"; 
									?>
									<input type="checkbox" name="dont_know" value="dont_know" onClick="submit()">&nbsp;需要再練習</p>
								</form>
						<?php
							//若學習尚未完成則印出
							}else{
						?>
								<form method="get" action="learn_info.php">
									<?php 
										echo "<input type='hidden' name='class' 
											value= {$class} >"; 
										echo "<input type='hidden' name='us_id' 
											value= {$id} >";
										echo "<input type='hidden' name='info_id' 
											value= {$rs[0]} >";
									?>
									<input type="checkbox" name="i_know" value="i_know"	onClick="submit()">&nbsp;學習完成</p>
								</form>
						<?php
							} 
						?>
						
					</td>	
				  </tr>
				  </tbody>
					<?php
						}
					?>
				</table>
				<p>&nbsp;</p>
			</div>
		</div>
		<div class="footer">
			
		</div>
	</div>
    <div class="fixlogout">
        <a href="logout.php">
        	<img src="img/logout.png" width="200px" ></img></a>
    </div>
</body>
</html>

