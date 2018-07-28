<?php
/**
 * Created by PhpStorm.
 * User: e_duc
 * Date: 26/07/2018
 * Time: 6:55 PM
 */
$from = $_GET["from"];
$to = $_GET["to"];
$eventName = $_GET["eventName"];
$time = $_GET["time"];
$location = $_GET["location"];

echo $from. '  '. $to. ' '. $time, ' '. $location. ' '.$eventName;