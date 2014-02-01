<?php
require_once WEBROOT.'/application/database/MySql.php';
class DenLuDAL {
	private $db;
	public function __construct(){
		$this->db=new MySql();
	}
	public function get($name){
		$sql="SELECT * FROM DenLu WHERE DenLuName='".$name."'";
		return $this->db->executeDataTable($sql);
		
	}
}

?>