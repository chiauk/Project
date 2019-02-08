<!--學員登入-資料庫連接-->
<?php

session_start();
$_SESSION['flag']='0';

?>

<html>
	<head>
		<meta charset="utf-8">
		<title>GoodEaR登入</title>
		<link rel="stylesheet" href="css/index.css" type="text/css">
	</head>
	<body>
		<body style="background-image: url(img/login.jpg);">
	</body>
</html>

<?php

	include('connect.php');
    
	if(isset($_POST['id']) and isset($_POST['pw']))
	{
		$id=$_POST['id'];$pw=$_POST['pw'];//$pw=hash('sha512',$pw);
		
		if(mysqli_query($s,"SELECT User_id,User_pwd FROM User WHERE User_id='$id' and User_pwd='$pw'")->num_rows==0)
		{             //檢查資料庫是否有此筆資料，無則顯示登入失敗並於三秒後跳轉回登入頁面
			echo "<img src='img/loginloss.png' width='300'  style='margin-top:120px; margin-left:450px;'></img>";
			header("Refresh:3;URL=login.html");
			/*echo "<div><img src='img/G.png' width='150' height='150' style='margin-left:100px;'></img></div>";*/
			die();
		}
		else{
			date_default_timezone_set("Asia/Taipei");
			$res = mysqli_fetch_assoc(mysqli_query($s,"SELECT User_id,User_pwd,User_email FROM User WHERE User_id='$id' and User_pwd='$pw'"));
			
			/*echo "<img src='img/loginok.png' width='500'  style='margin-top:120px; margin-left:450px;' />";
			header("Refresh:3;URL=index.php");*/
			$lt = $res['lt'];$lc = $res['lc'];
		}if (date('Y-m-d', strtotime($lt))==date('Y-m-d', strtotime('now')) and $lc>0){//記住登入狀態，設定cookie
				mysqli_query($conn,"UPDATE test SET lt=now() WHERE id='$id'");
			}
			else{
				if($lc==0)
				{
					setcookie("new",1,time()+3600);//一小時後自動登出
				}
				$lc = $res['lc']+1;
				mysqli_query($conn,"UPDATE test SET lt=now(),lc='$lc' WHERE id='$id'");
			}
			setcookie("id",$id,time()+3600);
			setcookie("lc",$lc,time()+3600);
			setcookie("lt",$lt,time()+3600);
                                                //於三秒後跳轉回首頁
			echo "<script>document.location.href='index.php';</script>";
		}
	
    
?>