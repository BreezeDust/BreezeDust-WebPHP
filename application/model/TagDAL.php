<?php
require_once WEBROOT.'/application/database/MySql.php';
class TagDAL {
	private $db;
	public function __construct(){
		$this->db=new MySql();
	}
	public function getAll(){
		$sql="SELECT * FROM Tag";
		return $this->db->executeDataTable($sql);
	}
	public function get($number){
		$sql="SELECT * FROM Tag WHERE TagNumber=".$number;
		return $this->db->executeDataTable($sql);
	}
}

?>