<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BookShare</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.min.js"></script>
    
    
</head>
<body>
    <div class="jumbotron">
        <h1>错误信息</h1>
        <p><?php
            session_start();
            echo $_SESSION['errInfo'];
         ?>
        <small><?php
            echo $_SESSION['errInfoDetail'];
         ?>
         <small>
         </p>
        <p>
        <?php
            echo'<a class="btn btn-lg btn-primary" href="'.$_SESSION['goBack'].'" role="button">&laquo;  返回</a>';
        ?>
        </p>
      </div>
</body>
