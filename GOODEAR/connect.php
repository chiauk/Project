<!--連接資料庫-->

<?php


$s=mysqli_connect("localhost","root","a1033304")
	or die("連接失敗");

//選資料庫
mysqli_select_db($s,"GoodEar");
mysqli_query($s,"set character set'utf8'");
mysqli_query($s,"set names 'utf8'");

?>