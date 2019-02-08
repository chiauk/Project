<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>GoodEaR 開口學發音</title>
	<link rel="stylesheet" href="css/all.css">
	<link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
	<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript">
		//點擊play區塊時顯現hide區塊，若hide區塊已顯現則隱藏
		$(function(){
			$('.play').hover(function(){
				$(this).addClass('music');
			}, function(){
				$(this).removeClass('music');
			}).click(function(){
				$(this).next('.hide').slideToggle();
			}).siblings('.hide').hide();

			$('.play').show();
		});
	</script>
	<script type="text/javascript">
		//點擊border_in區塊時顯現border_out區塊，若border_out區塊已顯現則隱藏
		$(function(){
			$('.border_in').hover(function(){
				$(this).addClass('i_know');
			}, function(){
				$(this).removeClass('i_know');
			}).click(function(){
				$(this).next('.border_out').slideToggle();
			}).siblings('.border_out').hide();

			$('.border_in').show();
		});
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

		//執行刪除收藏指令
		if($_GET['col']!=NULL){
			$col=$_GET['col'];
			$sql="DELETE FROM `collect` WHERE `col_id` = $col";
			$result_delete = mysqli_query($conn,$sql);	
		}
		if ($result_delete==TRUE){
			for($count=1; $count<2; $count++)
				echo "<script>alert ('收藏已經被移除囉'); </script> ";
		}

		//執行更改學習進度紀錄指令(學習完成)
		if($_GET['i_know'] != NULL ){
			$us_id=$_GET['us_id'];
			$info_id=$_GET['info_id'];

			$sql="INSERT INTO `info_know` (`info_know_id`, `User_id`, `info_id`) VALUES (NULL, '$us_id', '$info_id')";

			mysqli_query($conn,$sql);
		}

		//執行更改學習進度紀錄指令(尚須練習)
		if($_GET['dont_know'] != NULL ){
			$us_id=$_GET['us_id'];
			$info_id=$_GET['info_id'];

			$sql="DELETE FROM `info_know` 
				WHERE `info_id`='$info_id' && `User_id` = '$us_id'";

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
				<a href="learn_info.php?class=1">
					<img src="\images\bear.png" alt="" class="button"></a>
				<a href="user.php">
					<img src="\images\us_info.png" style="margin-top: 15px;" class="button"></a>
			</div>
		</div>
		<div class="content">
			<div class="collect">
				<table width="800" border="1">
					<?php
						//列出所有被收藏的字彙
						$sql="SELECT * FROM `collect`
								ORDER BY `col_id` DESC";
						$result=mysqli_query($conn,$sql);

						for($i=1;$i<=mysqli_num_rows($result);$i++){
							$rs=mysqli_fetch_row($result);
					?>
				  <tbody><tr>
					<td width="180px"><?php echo $i?></td>
					<td width="280px">
						<div class="col_inf" style="text-align:right; ">
						<?php
							//列出該收藏字彙資訊
							$sql_inf="SELECT `info_content` FROM `info` 
								WHERE `class_id`=$rs[2] && `info_id`=$rs[1]";
							$result_inf=mysqli_query($conn,$sql_inf);
							for($j=1;$j<=mysqli_num_rows($result_inf);$j++){
								$rs_inf=mysqli_fetch_row($result_inf);
								echo $rs_inf[0];
							}
						?></div>
						<div class="col_cla">
						<?php
							//列出該收藏字彙類別
							$sql_cla="SELECT `class_name` FROM `class` 
								WHERE `class_id`=$rs[2] "; 
							$result_cla=mysqli_query($conn,$sql_cla);
							for($j=1;$j<=mysqli_num_rows($result_cla);$j++){
								$rs_cla=mysqli_fetch_row($result_cla);
								echo $rs_cla[0];
							}									
						?></div>			
					</td>
					<td width="280px">
						<?php
							echo "<a href='collection.php?col={$rs[0]}'>";
						?>
							<img src="/images/collect.png" alt="" >
						</a>
						<img src="/images/record.png" onclick="window.open('record.php', 'record', config='height=500,width=500');" >
						<img class="play" src="/images/play.png" alt="" >

						<div class="hide">
							<?php
								//字彙範例音檔撥放
								echo "<embed src='/sound/o{$rs[2]}_{$rs[1]}.mp3' 
									volume='100' width='0' height='0' />"
							?>
						</div>
					</td>
				  </tr>
				  <tr>
					<td width="180px"></td>
					<td width="280px">
						<?php
							//列出該收藏字彙注音
							$sql_inf="SELECT `info_spell` FROM `info` 
								WHERE `class_id`=$rs[2] && `info_id`=$rs[1]";
							$result_inf=mysqli_query($conn,$sql_inf);
							for($j=1;$j<=mysqli_num_rows($result_inf);$j++){
								$rs_inf=mysqli_fetch_row($result_inf);
								echo $rs_inf[0];
							}
						?>
					</td>	
					<td width="280px">
						<?php
							//抓取使用者該字彙學習是否完成
							$id=$_COOKIE["id"];
							$sql="SELECT * FROM `info_know` 
								WHERE `User_id` = '$id' && `info_id` = '$rs[0]'";
							$result_know2=mysqli_query($conn,$sql);

							for($k=1;$k<=mysqli_num_rows($result_know2);$k++)
								$rs_know2=mysqli_fetch_row($result_know2);

							//若學習尚未完成則印出
							if($rs_know2[0] == NUll){
						?>
								<form method="get" action="collection.php">
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
							//若學習已完成則印出
							}else{
						?>
								<form method="get" action="collection.php">
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
							} 
						?>
						
					</td>	
				  </tr>
				  <tr class="border_in" style="color: #737373; font-size: 15px;">
					<td width="180px">小備註：</td>
					<td width="280px">
						<?php
							//抓取該收藏字彙備註內容
							$sql_note="SELECT `col_note` FROM `collect` 
								WHERE `class_id`=$rs[2] && `info_id`=$rs[1]";
							$result_note=mysqli_query($conn,$sql_note);
							for($k=1;$k<=mysqli_num_rows($result_note);$k++)
								$rs_note=mysqli_fetch_row($result_note);
							if($rs_note[0]!=NULL){
								echo $rs_note[0];
							}else{
								echo "無";
							}
						?>		
					</td>	
					<td width="280px">點我添加備註</td>	
				  </tr>
				  <tr class="border_out">
					<td width="180px">
						<img src="/images/write.png" 
							style="width: 40px; height: 40px; padding-top: 0; ">
					</td>
					<form action="collection.php" method="get">
						<td width="280px">
							<?php
								//若收藏字彙內已有備註內容
								if($rs_note[0]!=NULL){
									echo "<textarea name='note' id='' cols='40' rows='3'>".$rs_note[0]."</textarea>";
									echo "<input type='hidden' name='col_id' value='".$i."'>";
									echo "<input type='hidden' name='info_id' value='".$rs[1]."'>";
									echo "<input type='hidden' name='class_id' value='".$rs[2]."'>";

								//若收藏字彙內無備註內容
								}else{
									echo "<textarea name='note' id='' cols='40' rows='3'>還有甚麼要補充的呢</textarea>";
									echo "<input type='hidden' name='col_id' value='".$i."'>";
									echo "<input type='hidden' name='info_id' value='".$rs[1]."'>";
									echo "<input type='hidden' name='class_id' value='".$rs[2]."'>";
								}
							?>								
						</td>	
						<td width="280px">
							<input type="submit" value="更新" name="send"
								style="width: 80px; height: 50px; font-style: 微軟正黑體;">
						</td>
						<?php
							//若使用者有新增或更改備註內容
							if($_GET['note'] != NULL ){
								$note = $_GET['note'];
								$col_id = $_GET['col_id'];
								$info_id = $_GET['info_id'];
								$class_id = $_GET['class_id'];
								$count = $_GET['count'];

								$sql="UPDATE `collect` SET `col_note`= '$note' WHERE `info_id`='$info_id' && `class_id`='$class_id'";

								$result_update=mysqli_query($conn,$sql);
								header("Location: collection.php");
							}

						?>
					</form>	
				  </tr>
				  <tr>
					<td width="180px"></td>
					<td width="280px"></td>	
					<td width="280px"></td>	
				  </tr>
				  </tbody>
					<?php
						}
						//若使用者新增或更新備註成功
						if ($result_update==TRUE){
							for($count=1; $count<2; $count++){
								echo "<script>alert ('備註更新成功囉');</script> ";
							}
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

                   <a href="logout.php"><img src="img/logout.png" width="200px"  ></img></a>
               </div>
</body>
</html>