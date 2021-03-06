<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BookShare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="js/jquery.min.js"></script>
    <!-- Loading Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
    <script src="js/cookie.js"></script>
    <script>
        function loginOut(){
            delCookie('username');
            delCookie('password');
            delCookie('avatar');
            window.location.href="vmain.php"; 
        }
    </script>
    
</head>
<body style="background-color:#666666">
    
    <div class="navbar navbar-inverse navbar-embossed navbar-static-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a class="navbar-brand" href="vmain.php">BOOKSHARE</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a  href="vmain.php">首页</a></li>
                    
                        
                        <?php
                            require "../controlers/check_cookie.php";
                            $logined = false;
                            if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])&&check_cookie($_COOKIE['username'],$_COOKIE['password'])){
                            $logined = true;
                            echo '<li class="dropdown">
                                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                    我的书单
                                          <b class="caret"></b>
                                     </a>
                                     <ul class="dropdown-menu  navbar-inverse">
                                        <li><a style="color:white" href="../controlers/cown_book.php">拥有图书</a></li>
                                        <li><a style="color:white" href="../controlers/clend_book.php">借出图书</a></li>
                                        <li><a style="color:white" href="../controlers/cborrow_book.php">借入图书</a></li>
                                    </ul>
                                </li>';
                            
                                   }
                            ?>
                    
                </ul>
                <div class="navbar-right" id="signature">
                <?php
                    if($logined){
                    	$avatar = 'default';
                    	if($_COOKIE['avatar'] == '0')
                    		$avatar = 'default';
                    	echo '
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            欢迎您来到Bookshare！！！
                                   <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu  navbar-inverse">
                                        <li><img src="'.$avatar.'" width="180" height="180" ></img></li>
                                        <li><a style="color:white" onclick=\'loginOut()\'>注销</a></li>
                                </ul>
                            </li>
                        </ul>';
                        }
                   else
                        echo '
                        <button type="submit" class="btn btn-primary navbar-btn" onclick="javascript:window.location.href=\'vlogin.php\'">登录</button>
                        <button type="button" class="btn navbar-btn btn-info">注册</button>';
                        
                    ?>
                </div>
           </div>
       </div>
   </div>
   
   <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 panel panel-default">
       <div class="panel-body">
       	<h1>欢迎使用BookShare！</h1>
       	<a href="../app/bookshare.apk">点击下载，开始分享之旅！</a>
          <div id="myCarousel" class="carousel slide">
			   <!-- 轮播（Carousel）指标 -->
			   <ol class="carousel-indicators">
				  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				  <li data-target="#myCarousel" data-slide-to="1"></li>
				  <li data-target="#myCarousel" data-slide-to="2"></li>
			   </ol>   
			   <!-- 轮播（Carousel）项目 -->
			   <div class="carousel-inner">
			   		<div class="item active">
			   			<img class="col-md-12  col-sm-12 " src="image/main_1.jpg" alt="First slide">
				   </div>
				   <div class="item">
					   <img class="col-md-12  col-sm-12 " src="image/main_2.jpg" alt="Second slide">
				   </div>
				   <div class="item">
					   <img class="col-md-12  col-sm-12 " src="image/main_3.jpg" alt="Third slide">
				   </div>
			   </div>
			   <!-- 轮播（Carousel）导航 -->
			   <a class="carousel-control left" href="#myCarousel" 
				  data-slide="prev"></a>
			   <a class="carousel-control right" href="#myCarousel" 
				  data-slide="next"></a>
		   </div>
		   
       </div>
    </div>

   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   </br></br></br>
   <div class="text-center" >
        </br></br></br>
            <p style="color:#ffffff"><?php echo "CopyRight 2014-".date("Y")." JNU ZHACM All Rights Reserved."."</br>"."暨南大学珠海校区ACM团队 版权所有";?></p>
   </div>
</body>
