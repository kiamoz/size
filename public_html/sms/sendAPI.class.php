<?php

class sendAPI{
	
    public $user;
    public $pass;

    public function __construct($user,$pass)
    {
        $this->user  = $user;
        $this->pass = $pass;
    }
	
	
    public function send($mobiles, $body) {
        
        $data = array(
            'username' => $this->user ,
            'password' => $this->pass ,
            'mobiles' => $mobiles,
            'body' => $body,
        );
		
		$data = http_build_query($data);
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://ws3584.isms.ir/sendWS');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($ch);
		
	return json_decode($result, true);
        
    }
}
