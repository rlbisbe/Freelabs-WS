<?php 
define('DATA_PATH', realpath(dirname(__FILE__).'/data'));

$applications = array('APP001' => '28e336ac6c9423d946ba02d19c6a2632');

include_once 'models/TodoItem.php';
include_once 'models/Laboratorio.php';

try{
    $enc_request = $_REQUEST['enc_request'];

    $app_id = $_REQUEST['app_id'];

    if(!isset($applications[$app_id])){
        throw new Exception('Application does not exist!');
    }

    $params = json_decode(trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$applications[$app_id],base64_decode($enc_request),MCRYPT_MODE_ECB)));
    $params = (array) $params;
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
