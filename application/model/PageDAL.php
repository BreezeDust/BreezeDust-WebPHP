<?php
require_once WEBROOT.'/application/Entity/PageInfo.php';
require_once WEBROOT.'/application/database/MySql.php';
class PageDAL {
	private $db;
	public function __construct(){
		$this->db=new MySql();
	}
	public function add(PageInfo $page){
		$sql="INSERT INTO Page (PageName,PageYulan,PageContent,PageDate,PageTag,PageDiscuss)VALUES
			 ('".$page->PageName."','".$page->PageYulan."','".$page->PageContent."','".$page->PageDate."',".$page->PageTag.",0)";
		return $this->db->executeNonQuery($sql);
	}
	public function get($id){
		$sql="SELECT * FROM Page WHERE PageID=".$id;
		return $this->db->executeDataTable($sql);
	}
	public function delete($id){
		$sql="DELETE FROM Page WHERE PageID=".$id;
		return $this->db->executeNonQuery($sql);
	}	
	public function update(PageInfo $page){
		$sql="UPDATE Page SET PageName='".$page->PageName."',PageYulan='".$page->PageYulan."',PageContent='".$page->PageContent."',PageTag=".$page->PageTag." WHERE PageID=".$page->PageID;
		return $this->db->executeNonQuery($sql);
	}
	public function getPages($start,$rows){
		$sql="SELECT * FROM Page ORDER BY PageID DESC  LIMIT ".$start.",".$rows;
		return $this->db->executeDataTable($sql);
	}
	public function getPagesByTag($start,$rows,$tag){
		$sql="SELECT * FROM Page WHERE PageTag=".$tag." ORDER BY PageID DESC  LIMIT ".$start.",".$rows;
		return $this->db->executeDataTable($sql);
	}
	public function getCount(){
		$sql="SELECT COUNT(DISTINCT(PageID)) AS PageCount From Page";
		return $this->db->executeDataTable($sql);
	}
	public function addDis($pageID,$count){
		$sql="UPDATE Page SET PageDiscuss=".$count." WHERE PageID=".$pageID;
		return $this->db->executeNonQuery($sql);
	}
	public function updateDATE($pageID,$timeNum){
		$sql="UPDATE Page SET PageDate='".$timeNum."' WHERE PageID=".$pageID;
		return $this->db->executeNonQuery($sql);
	}
}

?>