<?php 

class CakeAPI {
    
  private $apikey;
  private $apiurl = 'https://api.wbsrvc.com';

  function __construct($apikey){
    $this->apikey = $apikey;
  }

  function call($url, $params) {
    try {

      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $this->apiurl . $url); 
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('apikey:'.$this->apikey));
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

      $result = curl_exec($ch);

      if ($result === false) {

        throw new Exception('Curl error: ' . curl_error($ch));

      } else {

        if (!$result = json_decode($result)) {
          throw new Exception('API Key Validation Error for ' . $this->apikey . '. Contact your administrator!');
        } 

        if ($result->status != 'success') {
          throw new Exception($result->data);
        }

      }
      
      curl_close($ch);
      return $result->data;

    } catch (Exception $e) {
      curl_close($ch);
      return $e->getMessage();
    }
  }
}