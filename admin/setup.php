<?php
error_reporting(0);
session_start();
function login($key) {
    $get = curl_init();
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $server = parse_ini_file("../server.ini", true);
    curl_setopt($get, CURLOPT_URL,"http://".$server['server_1']."/api/shortlink_key.php");
    curl_setopt($get, CURLOPT_POST, 1);
    curl_setopt($get, CURLOPT_POSTFIELDS, "appkey=$key");
    curl_setopt($get, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec ($get);
    curl_close($get);
    return $server_output;
}
if(isset($_POST['appkey'])) {
    if($_POST['appkey'] == 'CNC13') {
        $click = fopen("../key.ini","a");
        fwrite($click,$_POST['appkey']);
        fclose($click);
        unlink("../.htaccess");
        $click = fopen("../.htaccess","a");
        fwrite($click,'RewriteEngine on
RewriteRule ^([^\.]+)$ index.php?p=$1

<FilesMatch "\.(?:ini)$">
Order allow,deny
Deny from all
</FilesMatch>

<FilesMatch "\.(?:txt)$">
Order allow,deny
Deny from all
</FilesMatch>');
        fclose($click);
        echo "<script type='text/javascript'>window.top.location='index.php';</script>";
        exit();
    }else{
        echo "<script type='text/javascript'>window.top.location='?p=fail';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>16SHOP - Cracked by CNC13</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <h1>16SHOP - Cracked by CNC13</h1>
                        </div>
                        <div class="login-form">
                            <form action="" method="post">
                                <?php
                                if($_GET['p'] == "fail") {
                                    echo ' <center><span style="color:red">Please check your App Key</span><br><br></center>';
                                }
                               ?>
                                <div class="form-group">
                                    <label>16Short Key : CNC13</label>
                                    <input class="au-input au-input--full" type="text" name="appkey" required="required">
                                </div>
                                
                               <br>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Continue</button>
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>

    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->