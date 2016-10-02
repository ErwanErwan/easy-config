<?php

class Config {


	private  $vars;
	private static $instance;

	private function __construct(){
		$this->vars = require CONFIG_FILE;
	}

	public static function instance(){

		if(!isset(self::$instance))
			self::$instance = new Config;
		return self::$instance;
	}

	private  function get_item_rec($arr, $path){

		if(!isset($arr) || empty($arr))
			return NULL;	

		if(strpos($path, '.') === FALSE)
		{
			if(isset($arr[$path]))
				return ($arr[$path]);
			return NULL;
		}

		$curr_key = substr($path, 0, strpos($path, '.'));
		$next_path = substr($path, strpos($path, '.') + 1);

		return $this->get_item_rec($arr[$curr_key], $next_path);

	}
 	
	private function set_item_rec(&$arr, $path, $value){

		if(!isset($arr) || empty($arr))	return FALSE;

		if(!isset($value)) return FALSE;

		if(strpos($path, '.') === FALSE)
		{
			if(isset($arr[$path]))
				{
					$arr[$path] = $value;
					return TRUE;
				}
			return FALSE;
		}

		$curr_key = substr($path, 0, strpos($path, '.'));
		$next_path = substr($path, strpos($path, '.') + 1);

		return $this->set_item_rec($arr[$curr_key], $next_path, $value);

	}

	public function get($name){

		$item = $this->get_item_rec($this->vars, $name);
		return ($item);
	}

	public  function set($name, $value){
		return $this->set_item_rec($this->vars, $name);
	}


	public  function dump(){
		print_r($this);
	}
	// Config
}
