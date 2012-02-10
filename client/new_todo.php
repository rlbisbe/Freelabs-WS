<?php

session_start();
include_once 'APICaller.php';

$apicaller = new ApiCaller('APP001','28e336ac6c9423d946ba02d19c6a2632','http://localhost:61148/index.php');

$todo_items = $apicaller->sendRequest(array(
    'controller' => 'todo',
    'action' => 'create',
    'title' => $_POST['title'],
    'due_date' => $_POST['due_date'],
    'description' => $_POST['description'],
    'username' => $_SESSION['username'],
    'userpass' => $_SESSION['userpass']
));

header('Location: todo.php');
exit();
?>