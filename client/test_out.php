<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'APICaller.php';

$apicaller = new ApiCaller('APP001','28e336ac6c9423d946ba02d19c6a2632','http://gentle-mist-3984.herokuapp.com/index.php');

$todo_items = $apicaller->sendRequest(array(
    'controller' => 'Lab',
    'action' => 'getLab',
    'id' => 18
));

print_r($todo_items);
?>