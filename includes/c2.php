<?php
include_once 'curl_res.php';

class c2 {
    private $_c2;
    
        
    public function __construct() {
    
       // Selecting c2
		if(filter_has_var(INPUT_POST, 'c2f')) { // Selection by form
			$this->_c2 = filter_input(INPUT_POST, 'c2f'); 
			} 
		else { // Selection by IP */
            //Obtaining ip
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = @$_SERVER['REMOTE_ADDR'];
                if(filter_var($client, FILTER_VALIDATE_IP)){
                $ip = $client;
                }elseif(filter_var($forward, FILTER_VALIDATE_IP)){
                $ip = $forward;
                }else{ 
                $ip = $remote;                
                 }
            
            //Obtaining country from geoplugin
           $url = "http://api.ipstack.com/".$ip."?access_key=8c5501598df9076e1df4a58f30373fe5";
           $ip_dc = new curl_res($url);
           $ip_dc2 = $ip_dc->get_res();
           $this ->_c2 = isset($ip_dc2->country_code) ? $ip_dc2->country_code : "US"; 
                    
        } 
    }
     
    public function getc2() {
    return $this->_c2; }
    
    public function getip() {
    return $this->_ip; }
}
