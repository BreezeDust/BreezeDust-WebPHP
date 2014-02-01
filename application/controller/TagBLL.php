<?php
require_once WEBROOT.'/application/model/TagDAL.php';
class TagBLL {
	private $DAL;
	public function __construct(){
		$this->DAL=new TagDAL();
	}
	public function getCName($number){
		$table=$this->DAL->get($number);
		if($table->count>0) return $table->Rows[0]['TagCname'];
		return "";
	}
}

?>