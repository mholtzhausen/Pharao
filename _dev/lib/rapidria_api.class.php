<?php

class rapidria_api{
	protected $repo=array();
	protected $currentLibrary=NULL;
	
	public function __construct(){
		
	}
	
	public function addFunction($name=NULL,$description=NULL,$funct=NULL,$params){
		
	}
	
	public function setLibrary($library=NULL){
		$this->currentLibrary=$library;
	}
	
	public function getLibrary(){return $this->currentLibrary;}
	
}

?>