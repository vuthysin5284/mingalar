<?php

class user {
	
	/*
	*user id variable
	*/
	public $id 				  = 0;
	
	/*
	*user_name
	*/
	public $user_name 			= '';
	
	public $service_name 			= '';
	
	/*
	*password
	*/
	private $password			= '';
	
	/*
	*full name
	*/
	public $name				 = '';
	
	/*
	*e-mail address
	*/
	public $email				= '';
	
	/*
	*phone number 
	*/
	public $phone				= '';
	
	/*
	*role
	*/
	public $role				= '';
	
	/*
	*store user privileges
	*/
	public $pris				= array();
	
	/*
	*hef
	*/
	public $hefs				= array();
	
	/*
	*register date
	*/
	public $register_date		= '';
	
	/*
	*register by
	*/
	public $register_by		  = '';
	
	/*
	*is user logged
	*/
	public $is_logged			 = false;
	
	/*
	*entry date
	*/
	public $entry_date			= array(); 
	
	/*
	*session for user
	*/
	private $session			   = ''; 
	
	
	/*
	*constructor
	*/
	public function __constructor() {  
				
	}
	
	/*
	*login method
	*return true if success
	*param : 
	* - $user_name : user_name
	* - $password : password
	*/
	public function login($id, $password) {
		global $db, $_date, $_crypt;
		$sql = 'SELECT 
					password
				FROM m_account 
				WHERE 
					active = 1 AND ';

		
		if(strpos($id, '@')) 		$sql .= 'email = '.$db->Quote($id);
		else 						$sql .= 'user_name = '.$db->quote($id);
		
		$result = $db->Execute($sql);
		$_pwd='';
		while($row = $result->FetchRow()){
			$_pwd = $row["password"];
		} 
		if($pwd = $_pwd) {
			if($pwd == md5($password)) {
				if(user::get_user($id)){ 
					$newObj=user::get_user($id);
					$_SESSION['u'] = $newObj->user_name;
					return true;
				}
			}
		}
		
		return false;
	}
	
	/*
	*get user data
	*return user true if success
	*param : 
	* - $id : user id or user_name or email
	*/
	public static function get_user($id) { 
		global $db; 
		$sql = 'SELECT 
					account_id, 
					user_name, 
					password, 
					name, 
					email 
				FROM m_account
				WHERE 
					active 		= 1 AND ';
		$sql .= 'user_name = '.$db->quote($id);
		$result=$db->Execute($sql);
		$obj = new user();
		while($row = $result->FetchRow()) { 
			$obj->id				= $row["account_id"];
			$obj->user_name		 = $row["user_name"];
			$obj->password		  = $row["password"];
			$obj->name 			  = $row["name"];
			$obj->email 			 = $row["email"];  
		}  
		return $obj;
	}

	/*
	*get all privileges
	*return array of privilage
	*/
	private function get_pris($role = '') {
		global $db;
	
		if(empty($role) || $this->user_name == 'administrator') 
			$sql = 'SELECT
						privilege
					FROM privileges';
		else
			$sql = 'SELECT 
						privilege
					FROM role_details
					WHERE role = '.$db->quote($role);
		return $db->get_col($sql, 0, ARRAY_N);
	}
	
	
	
	
	/*
	*check privilege
	*return true if user can do action
	*param : 
	* $pri : privilege name
	*/
	public function can($pri) {
		if(empty($this->pris)) 				return false;
		if (in_array($pri, $this->pris)) 	return true;
		else								return false;
	}
	
	/*
	*logout
	*return true on success
	*/
	public static function logout() { 
		if(isset($_SESSION['u'])) {
			unset($_SESSION['u']);
			return true;
		} else return false;
	}
	  
	
	/*
	*check if usernae exist
	*@return true if exist
	*@param : 
	* - $id : user_name or email
	*/
	public static function id_exist($id) {
		global $db;
		
		if(strpos($id, '@')) 	$sql = 'SELECT COUNT(*) FROM user_name WHERE email = '.$db->quote($id);
		else 					$sql = 'SELECT COUNT(*) FROM user_name WHERE user_name = '.$db->quote($id);
		return (int)$db->get_var($sql);
	}
	
	/*
	*track user
	*@return true when success
	*/
	public function track() {
		global $db, $_date, $_webinfo;
		
		$data = new stdClass;
		$data->now 			= $_date->now();
		$data->id 			= $this->id;
		$data->ip			= Util::ip();
		$data->url			= $_webinfo->current_url();
		$data->referrer		= $_webinfo->referrer();
		$data->user_agent	= $_webinfo->user_agent();
		
		$sql = 'INSERT INTO user_tracks (
					`date`, 
					uid, 
					ip,
					url, 
					referrer, 
					user_agent )
				VALUES ('.
					$db->quote($data->now).', '.
					$data->id.', '.
					$db->quote($data->ip).', '.
					$db->quote($data->url).', '.
					(empty($data->referrer) ? 'NULL' : $db->quote($data->referrer)).', '.
					$db->quote($data->user_agent).')';
		return $db->query($sql);
	}
	
	
	
	/*
	*check if user have been verify
	*@return true if verify
	*@param :
	* - $id : this can be id or user_name
	*/
	public static function is_verify($id) {
		global $db;
		$where = '';
		if(is_numeric($id)) 		$where = 'id = '.$id;
		elseif(strpos($id, '@')) 	$where = 'email = '.$db->quote($id);
		else 						$where = 'user_name = '.$db->quote($id);
		
		$sql = 'SELECT COUNT(*) FROM users WHERE state = 0 AND '.$where; 
		if((int)$db->get_var($sql)) return false;
		else return true;
	}
	
	/*
	*verify user
	*@return true on success
	*@param :
	* - $id : id or user_name
	*/
	public static function verify($id) {
		global $db;
		
		if(empty($id)) return false;
		
		$where = '';
		if(is_numeric($id)) 		$where = 'id = '.$id;
		elseif(strpos($id, '@')) 	$where = 'email = '.$db->quote($id);
		else 						$where = 'user_name = '.$db->quote($id);
		
		$revision = user::get_revision($id);
		
		$sql = 'UPDATE users SET state = 1 WHERE '.$where;
		$val = $db->query($sql);
		if($val) user::set_revision($revision);
		return $val;
	}
	
	/*
	*get user code
	*@return user code, string blank if fail
	*@param : 
	* - $id : id, user_name or email
	*/
	public static function code($id) {
		global $db;
		
		$where = '';
		if(is_numeric($id)) 		$where = 'id = '.$id;
		elseif(strpos($id, '@')) 	$where = 'email = '.$db->quote($id);
		else 						$where = 'user_name = '.$db->quote($id);
		
		$sql = 'SELECT code FROM users WHERE '.$where;
		$code = $db->get_var($sql);
		if(!$code) $code = '';
		return $code;
	}
	
	/*
	*set default role (this function will not create revision
	*@return true on success
	*@param:
	* + $role : role to set
	* + $id : id, user_name or email
	*/
	public static function set_default_role($role, $id) {
		global $db;
		$where = '';
		if(is_numeric($id)) 		$where = 'id = '.$id;
		elseif(strpos($id, '@')) 	$where = 'email = '.$db->quote($id);
		else 						$where = 'user_name = '.$db->quote($id);
		$sql = 'UPDATE users SET role = '.$db->quote($role).' WHERE '.$where;
		return $db->query($sql);
	} 
	
	/*
	 *
	*/
	public static function service($obj){
		global $db;
		$sql = "
				select 
					ms.service_name
				from m_service ms 
				inner join account_service ase on ase.service_id = ms.service_id
				right join m_account ma on ase.account_id = ma.account_id
				where ma.user_name = ? ;
		";  
		$result=$db->Execute($sql,array($obj->user_name));
		$obj = new user();
		while($row = $result->FetchRow()){
			$obj->service_name = $row["service_name"];
		}
		return $obj;
	} 
}





