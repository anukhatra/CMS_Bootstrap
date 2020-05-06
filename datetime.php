<?php
function dateTime(){
//date_default_timezone_set("Asia/hongkong");
$currentTime = time();
$today = strftime("%d/%B/%Y %H:%M:%S",$currentTime);
//echo $today;
}
?>