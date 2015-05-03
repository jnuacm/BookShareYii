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
                    	$avatar = '../../bookshareyii/upload/avatar'.$_COOKIE['username'];
                    	if($_COOKIE['avatar'] == '0')
                    		$avatar = '../../bookshareyii/upload/default';
                        echo '
                        <ul class="nav navbar-nav">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            用户中心
                                   <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu  navbar-inverse">
                                        <li><img src="'.$avatar.'" width="180" height="180" ></img></li>
                                        <li><a style="color:white" href="#">用户信息</a></li>
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
       
          <?php
          	$own_books = unserialize($_POST['own_books']);
          	$bookslength = count($own_books);
          	echo '
					<div class="panel-body">
					<h3 class="text-center"> 借出图书 </h3>
					</div></br>';
				for($i = 0; $i < $bookslength; $i = $i + 1){
					$own_books[$i]['owner'] = base64_decode($own_books[$i]['owner']);
					$own_books[$i]['id'] = base64_decode($own_books[$i]['id']);
					$own_books[$i]['name'] = base64_decode($own_books[$i]['name']);
					$own_books[$i]['isbn'] = base64_decode($own_books[$i]['isbn']);
					$own_books[$i]['author'] = base64_decode($own_books[$i]['author']);
					$own_books[$i]['description'] = base64_decode($own_books[$i]['description']);
					$own_books[$i]['publisher'] = base64_decode($own_books[$i]['publisher']);
					$own_books[$i]['holder'] = base64_decode($own_books[$i]['holder']);
					$own_books[$i]['visibility'] = base64_decode($own_books[$i]['visibility']);
					$own_books[$i]['large_img'] = base64_decode($own_books[$i]['large_img']);
					$own_books[$i]['medium_img'] = base64_decode($own_books[$i]['medium_img']);
					$own_books[$i]['small_img'] = base64_decode($own_books[$i]['small_img']);
					$own_books[$i]['tags'] = base64_decode($own_books[$i]['tags']);
					if($own_books[$i]['owner'] == $own_books[$i]['holder'])
						$status = "在库";
					else
						$status = "借出";
					echo '
					<div class="panel-body">
					<img src = "'.$own_books[$i]['large_img'].'"  height="280" class="col-md-3 col-sm-3">
					<h4 class = "col-md-9 col-sm-9">
					书名: <small>'.$own_books[$i]['name'].'</small></br>
					作者: <small>'.$own_books[$i]['author'].'</small></br>
					出版社: <small>'.$own_books[$i]['publisher'].'</small></br>
					ISBN: <small>'.$own_books[$i]['isbn'].'</small></br>
					状态： <small>'.$status.'</small></br>
					当前持有者： <small>'.$own_books[$i]['holder'].'</small></br>
					简介： <small>'.$own_books[$i]['description'].'</small></br>
					</h4>
					</div></br></br></br>';
				}
            ?>
       
   </div>

   
   
   <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 text-center" >
        </br></br></br>
            <p style="color:#ffffff"><?php echo "CopyRight 2014-".date("Y")." JNU ZHACM All Rights Reserved."."</br>"."暨南大学珠海校区ACM团队 版权所有";?></p>
   </div>
</body>
