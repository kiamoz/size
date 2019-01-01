<?php

class newXML{
	
	var $data,$datatype;
	
	function newXML(){
		$this->data = array();
		$this->datatype = array();
	}
	
	function adddata($name,$data){
		$this->data[$name] = $data;
		$this->datatype[$name] = 'string';
	}
	
	function addtablebyarray($name,$array){
		$this->data[$name] = $array;
		$this->datatype[$name] = 'table';
	}
	
	function addtablebysql($name,$result){
		if($result){
			$this->data[$name] = array();
			$this->datatype[$name] = 'table';
			while($row = mysql_fetch_assoc($result)){
				$rowdata = array();
				foreach($row as $value){
					$rowdata[] = $value;
				}
				$this->data[$name][] = $rowdata;
			}
		}else{
			$this->adddata($name,'');
		}
	}
	
	function send($name,$data){
		$this->adddata($name,$data);
		$this->run();
	}
	
	function runjs($script){
		$script = str_replace('#','<<!TAGS!>>',$script);
		$this->data['js'] .= "$script;";
		$this->datatype['js'] = 'string';
	}
	
	function runjsnow($script){
		$script = str_replace('#','<<!TAGS!>>',$script);
		die("<#js#>$script</#js#>");
	}
	
	function alert($msg){
		$msg = str_replace('#','<<!TAGS!>>',$msg);
		$msg = addslashes($msg);
		$msg = str_replace("\r",'\r',$msg);
		$msg = str_replace("\n",'\n',$msg);
		$this->runjs("alert('$msg')");
	}
	
	function alertnow($msg){
		$msg = str_replace('#','<<!TAGS!>>',$msg);
		$msg = addslashes($msg);
		$msg = str_replace("\r",'\r',$msg);
		$msg = str_replace("\n",'\n',$msg);
		$this->runjsnow("alert('$msg')");
	}
	
	function removedata($name){
		unset($this->data[$name]);
		unset($this->datatype[$name]);
	}
	
	function run(){
		$output = '';
		
		foreach($this->data as $name => $data){
			
			$output .= "<#$name#>";
			
			switch($this->datatype[$name]){
				case 'string':
					$data = $this->encode($data);
					$output .= $data;
					break;
					
				case 'table':
					
					$datalen = count($data) - 1;
					if($datalen<0) break;
					
					$rowlen = count($data[0]) - 1;
					
					for($i = 0;$i <= $datalen;$i++){
						for($j = 0;$j <= $rowlen;$j++){
							$output .= $this->encode($data[$i][$j]) . ($j == $rowlen ? '' : '~');
						}
						if($i != $datalen) $output .= "\r";
					}
					break;
			}
			
			$output .= "</#$name#>";
		}
		
		die($output);
	}
	
	function decodetable($string){
		$data = explode("\r",$string);	
		$datalen = count($data);
		
		for($i = 0;$i < $datalen; $i++){
			$data[$i] = explode("~",$data[$i]);
			for($j = 0;$j < count($data[$i]); $j++){
				$data[$i][$j] = $this->decode($data[$i][$j]);
			}
		}
		
		return $data;
	}
	
	function encode($data){
		return str_replace('#','<<!TAGS!>>',str_replace("\r",'<<!LINES!>>',str_replace('~','<<!OBJS!>>',$data)));	
	}
	
	function decode($data){
		return str_replace('<<!TAGS!>>','#',str_replace('<<!LINES!>>',"\r",str_replace('<<!OBJS!>>','~',$data)));	
	}

	
}

$nxml = new newXML();

?>