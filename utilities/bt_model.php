<?php
	
	abstract class ExtensionBridge
	{
		// array containing all the extended classes
		private $_exts = array();
		public $_this;
			
		function __construct(){$_this = $this;}
		
		public function addExt($object)
		{
			$this->_exts[]=$object;
		}
		
		public function __get($varname)
		{
			foreach($this->_exts as $ext)
			{
				if(property_exists($ext,$varname))
				return $ext->$varname;
			}
		}
		
		public function __call($method,$args)
		{
			foreach($this->_exts as $ext)
			{
				if(method_exists($ext,$method))
				return call_user_method_array($method,$ext,$args);
			}
			throw new Exception("This Method {$method} doesn't exists");
		}
		
		
	}
	
	class bt{
	
		public function bt_json_encode($obj){
			$obj->action = "success";
			echo str_replace('null','""',json_encode($obj));
		}
		
		public function array_to_object($array){
			$object = object;
			foreach($array as $key=>$value){
				$object->{$key} = $value;	
			}
			return $object;
		}
		
		public function merge_object(){}
		
	}
	
?>