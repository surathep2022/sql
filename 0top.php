<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1);
ini_set('max_execution_time', 600);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set('Asia/Bangkok');

$hospitalname = 'โรงพยาบาลเกษมราษฎร์ รามคําแหง';
$hosname = 'เกษมราษฎร์ ราม';

include("connect/localhost/PDO.php");
include("connect/SSB100/PDO-DNHOSPITAL.php");

include 'function/getOnlyDay.php';
include 'function/getOnlyTime.php';
include 'function/convertDate.php';