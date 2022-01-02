<?php
error_reporting(0);
session_start();
if(!isset($_SESSION['email_admin'])) {
    header("location: login.php");
}
unlink("../db/url/".$_GET['code'].".ini");
unlink("../logs/".$_GET['code']."-visitor.txt");
unlink("../logs/".$_GET['code']."-bots.txt");
unlink("../logs/".$_GET['code']."-real.txt");
echo "<script type='text/javascript'>window.top.location='index.php';</script>";