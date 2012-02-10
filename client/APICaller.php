<?php

class ApiCaller{
    
    private $_app_id;
    private $_app_key;
    private $_api_url;

    public function __construct($app_id,$app_key,$api_url){
        $this->_app_id = $app_id;
        $this->_app_key = $app_key;
        $this->_api_url = $api_url;
    }

    public function sendRequest($request_params){
        $enc_request = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$this->_app_key,json_encode($request_params),MCRYPT_MODE_ECB));
    
        $params = array();
        $params['enc_request'] = $enc_request;
        $params['app_id'] = $this->_app_id;

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$this->_api_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,count($params));
        curl_setopt($ch,CURLOPT_POSTFIELDS,$params);
        
        $result = curl_exec($ch);
        
        $result = @json_decode($result);
        
		if( $result == false || isset($result->success) == false ) {
			throw new Exception('Request was not correct');
		}
        
        if($result->success == false){
			throw new Exception($result->errormsg);
        }
        
		return $result->data;
    }
}