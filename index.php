<?php 
define('DATA_PATH', realpath(dirname(__FILE__).'/data'));

$applications = array('APP001' => '28e336ac6c9423d946ba02d19c6a2632');
include_once 'models/Laboratorio.php';

try{
    $params = $_REQUEST;
    $controller = ucfirst(strtolower($params['controller']));
    $action = strtolower($params['action']).'Action';

    if(file_exists("controllers/{$controller}.php")){
        include_once "controllers/{$controller}.php";
    } else {
        throw new Exception('controller is invalid');
    }

    $controller = new $controller($params);

    if(method_exists($controller,$action) === false){
        throw new Exception('Action is invalid');
    }

    $result['data'] = $controller->$action();
    $result['success'] = true;

} catch(Exception $e){
    $result = array();
    $result['success'] = false;
    $result['errormsg'] = $e->getMessage();
}

echo json_encode($result);
exit();
