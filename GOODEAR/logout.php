<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

	setcookie("id", "", time()-3600);
	$usrMsg.='已經成功登出<br>';
//將session清空
/*unset($_SESSION['id']);
echo '登出中......';*/
//跳轉回首頁
echo '<meta http-equiv=REFRESH CONTENT=1;url=index.php>';
?>
