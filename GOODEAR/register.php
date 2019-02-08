<!--學員註冊-資料庫連接-->
<html>
    <head>
        <meta charset="utf-8">
        <title>GoodEaR註冊</title>
        <link rel="stylesheet" href="css/index.css" type="text/css">
    </head>
    <body>
        <body style="background-image: url(img/registor.jpg);">
    </body>
</html>

<?php

include('connect.php'); 

if(isset($_POST['id']) and isset($_POST['pw']) and isset($_POST['email']))
{
        $id=$_POST['id'];$pw=$_POST['pw'];$email=$_POST['email'];
       //如果輸入不為空值或預設值就寫入資料庫，並顯示註冊成功
        if(mysqli_query($s,"SELECT * FROM User WHERE User_id='$id'")->num_rows==0 && $id!=NULL && $id!=帳號 && $pw!=NULL && $pw!=密碼 && $email!=NULL && $email!=Email)
        {
                //$pw=hash('sha512',$pw);

                mysqli_query($s,"INSERT INTO User(User_id,User_pwd,User_email)VALUES ('$id','$pw','$email')");
                echo "<a href='login.html'><img src='img/relogin.png' width='300' height='250' style='margin-top:120px; margin-left:450px;'></img></a>";
               /* echo "<div><img src='han.png' width='150' height='150' style='margin-left:100px;'></img></div>";*/
        }else if(mysqli_query($s,"SELECT * FROM User WHERE User_id='$id'")->num_rows>0){
                                //如果輸入的帳號已註冊，顯示已註冊提醒
                                echo "<a href='register.html'><img src='img/account.png' width='300' height='250' style='margin-top:120px; margin-left:450px;'></img></a>";
                                /*echo "<div><img src='lu.png' width='150' height='150' style='margin-left:100px;'></img></div>";*/
                        }else{
                                 //如果輸入的值以上皆非，顯示重新註冊提醒
                                echo "<a href='register.html'><img src='img/reregister.png' width='300' height='250' style='margin-top:120px; margin-left:450px;'></img></a>";
                               /* echo "<div><img src='lu.png' width='150' height='150' style='margin-left:100px;'></img></div>";*/
                        }
}




?>
