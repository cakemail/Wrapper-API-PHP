<?php 

class CakeAPI {
    
    private $apikey;
    private $apiurl = 'https://api.wbsrvc.com';
    
    function __construct($apikey){
        $this->apikey = $apikey;
    }
    
    function call($url, $params) {
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $this->apiurl . $url); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('apikey:'.$this->apikey));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $result = curl_exec($ch);
        
        if ($result === false) {
            curl_close($ch);
            throw new Exception('Curl error: ' . curl_error($ch));
        } else {
            
            if(json_decode($result)){
                $result = json_decode($result);
            } else {
                curl_close($ch);
                throw new Exception('API Key Validation Error for ' . $this->apikey . '. Contact your administrator!');
            }
            curl_close($ch);
            if($result->status != 'success')
                throw new Exception($result->data);
        }
        
        return $result->data;
    }
}