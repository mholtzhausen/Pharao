<?php
class Pharao{
	private static $instance=NULL;
	private static $baseFolder='';
	private $archives=array();
	private static $develop=false;
	
	private function __construct(){}
	
	public static function getSingleton(){
		if(self::$instance==NULL)self::$instance=new Pharao();
		return self::$instance;
	}
	
	public static function getInstance(){
		return self::getSingleton();
	}
	
	public static function setDevelop($status=true){
		self::$develop=!!$status;
	}
	
	
	public static function addPhar($archive=NULL,$folder=NULL,$targz=true){
		self::getInstance()->archives[$archive]=array(
			'folder' => $folder,
			'compressed' => !!$targz,
			'archive' => $archive.'.phar',
			'file' => $archive.'.phar'.(!!$targz?'.tar.gz':''),
			'alias'=> basename($archive.'.phar'.(!!$targz?'.tar.gz':''))
		);
		if(self::$develop)self::compile($archive,false);
	}
	
	public static function getArchives(){
		return self::getInstance()->archives;
	}
	
	public static function getArchive($archive=NULL){
		$archives=self::getArchives();
		return (array_key_exists($archive,$archives)?$archives[$archive]:NULL);
	}
	
	public static function getRoot($archive=NULL){
		$collection=self::getInstance()->archives;
		return array_key_exists($archive,$collection)?'phar://'.self::$baseFolder.$collection[$archive]['file'].'/':NULL;
	}
	
	public static function getUri($archive=NULL,$path=NULL){
		return self::getRoot($archive).($path?$path:'');
	}
	
	public static function setBaseFolder($folder=NULL){
		$folder=(string)$folder;
		self::$baseFolder=$folder;
	}
	
	public static function listFiles($archive=NULL,$root=NULL){
		$list=array();
		if(!$root && $archive)$root=self::getRoot($archive);
		$dh=opendir($root);
		while(false !== ($entry=readdir($dh))){
			if(is_dir($entry)){
				$list=array_merge($list,self::listFiles(NULL,$root.$entry.'/'));
			}else{
				$list[$root.$entry]=$entry;
			}
		}
		return $list;
	}
	
	public static function compile($archive=NULL,$verbose=true){
		$archivelist=$archive?array($archive=>self::getArchive($archive)):self::getArchives();
		foreach($archivelist as $archive =>$data){
			$file=self::$baseFolder.$data['file'];
			if($verbose)self::prt("\n",'Compiling '.$file,str_repeat('=',50));
			
			if(is_file($file)){
				@unlink($file);
				if($verbose)self::prt('... unlinking existing archive.');
			}
			
			if($verbose)self::prt('... adding files from folder: '.$data['folder']);
			self::getInstance()->create($archive);
			if($verbose)self::prt('... done.');
			
			
		}
	}
	
	private function create($archive=NULL){
		$a=self::getArchive($archive);
		if($a){
			$p=new Phar(self::$baseFolder.$a['archive'],0,$a['alias']);
			if($a['compressed'])$p=$p->convertToExecutable(Phar::TAR, Phar::GZ);
			$p->startBuffering();
			$p->buildFromDirectory($a['folder']);
			$p->stopBuffering();
		}
	}
	
	private static function out(){
		$args=func_get_args();
		echo '<pre>';
		foreach($args as $arg){
			print_r($arg);
		}
		echo '</pre>';
	}
	
	private static function prt(){
		$args=func_get_args();
		foreach($args as $arg){
			echo nl2br($arg).'<br />';
		}
	}	
}


?>