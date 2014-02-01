<?php
require_once WEBROOT.'/application/model/DenLuDAL.php';
class DenLuBLL {
	private $DAL;
	public function __construct(){
		$this->DAL=new DenLuDAL();
	}
	public function login($name,$passwd){
		if($name=="") return false;
		if($passwd=="") return false;
		$table=$this->DAL->get($name);
		if($table->count>0){
			if($table->Rows[0]["DenLuName"]==$name && $table->Rows[0]["DenLuPassWord"]==$passwd) return true;
		}
		return false;
	}
}

?>