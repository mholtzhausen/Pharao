<?php
    
class std{
	public function out(){
		$args=func_get_args();
		echo '<pre>';
		foreach($args as $arg){
			print_r($arg);
		}
		echo '</pre>';
	}
	
	public function prt(){
		$args=func_get_args();
		foreach($args as $arg){
			echo $arg.'<br />';
		}
	}
}
    
    
?>