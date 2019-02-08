 <!--首頁-->
  <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>GoodEaR首頁</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
 	<link rel="stylesheet" href="css/index.css" type="text/css">
               <link rel="Shortcut Icon" type="image/x-icon" href="img/GERlogo.png" />
 	 
 </head>
 <body style="background-image: url(img/home.jpg);">
 	 <div class="wrap">
        <div class="header">
            <!--<a href="login.html"><div class="logbutton" style="float: right;">登入</div></a>
            <a href="register.html" ><div class="logbutton" style="float: right;">註冊</div></a>-->
            
          <?php

                echo "<meta charset='UTF-8' />";
                include('connect.php');
                if ($_COOKIE["id"]!=null) {
                //若為登入狀態，右上角按鈕顯示登出
                $id=$_COOKIE["id"];
                $re=mysqli_query($s,"SELECT * FROM User where User_id='$id'");
                $kekka=mysqli_fetch_array($re);
                
print <<<eot2
                <link href="css/index.css" rel="stylesheet" type="text/css">
    
        
                <a href="logout.php"><div class="logbutton" style="float: right;cursor: pointer;">登出</div></a>
eot2;

                }else{
print <<<eot1
                  <!--若為登出狀態，右上角按鈕顯示登入及註冊-->
                <link href="css/index.css" rel="stylesheet" type="text/css">
                <a href="login.html"><div class="logbutton" style="float: right;">登入</div></a>
                <a href="register.html" ><div class="logbutton" style="float: right;">註冊</div></a>
eot1;
}
            ?>
        </div>
       <div class="content">
            <div class="logo">
                <img src="img/logo1.png"  width="600"/>
            </div>
            
            <?php

                echo "<meta charset='UTF-8' />";
                include('connect.php');
                if ($_COOKIE["id"]!=null) {
                $id=$_COOKIE["id"];
                $re=mysqli_query($s,"SELECT * FROM User where User_id='$id'");
                $kekka=mysqli_fetch_array($re);
                
print <<<eot2
                 <!--若為登入狀態，中間兩個按鈕分別跳轉learn_class.php(學習頁)和factory.php(資源地圖頁)-->
                <link href="css/index.css" rel="stylesheet" type="text/css">
    
                <div class="block" style="text-align:center;margin: 50px 0px;">
                <a href="learn_class.php"><img src="img/learn.png"  width="150" style="margin: 0px 100px" class="button"  / ></a>
                <a href="factory.php" ><img src="img/search.png"  width="150" style="margin: 0px 100px;" class="button"/></a>
               </div>
               <div class="block" style="text-align:center;margin: 50px 0px;">
                <a href="learn_class.php"><img src="img/learnbutton.png"  width="200" style="margin: 0px 100px"  class="button" / ></a>
                <a href="factory.php" ><img src="img/searchbutton.png"  width="200" style="margin: 0px 80px"  class="button" /></a>
                </div>
eot2;

                }else{
print <<<eot1
                <!--若為登出狀態，中間兩個按鈕皆會跳轉至登入頁-->
                <link href="css/index.css" rel="stylesheet" type="text/css">

                <div class="block" style="text-align:center;margin: 50px 0px;">
                <a href="login.html"><img src="img/learn.png"  width="150" style="margin: 0px 100px" class="button"  / ></a>
                <a href="login.html"><img src="img/search.png"  width="150" style="margin: 0px 100px;" class="button"/></a>
               </div>
               <div class="block" style="text-align:center;margin: 50px 0px;">
                <a href="login.html"><img src="img/learnbutton.png"  width="200" style="margin: 0px 100px"  class="button" / ></a>
                <a href="login.html" ><img src="img/searchbutton.png"  width="200" style="margin: 0px 80px"  class="button" /></a>
                </div>
                
eot1;
}
            ?>
                
            
            
        </div>        
        <div class="footer">

        </div>
 </body>
 </html>

 