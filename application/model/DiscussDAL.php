<?php
require_once WEBROOT.'/application/database/MySql.php';
require_once WEBROOT.'/application/Entity/DiscussInfo.php';
class DiscussDAL {
	private $db;
	public function __construct(){
		$this->db=new MySql();
	}
	public function add(DiscussInfo $dis){
		$sql="INSERT INTO Discuss (DSPageID,ParentID,DSname,DSDate,DScontent)VALUES
			(".$dis->DSPageID.",".$dis->ParentID.",'".$dis->DSname."','".$dis->DSDate."','".$dis->DScontent."'".")";
		return $this->db->executeNonQuery($sql);
	}
	public function getALL(){
		$sql="SELECT * FROM Discuss";
		return $this->db->executeDataTable($sql);
		
	}
	public function getByID($id){
		$sql="SELECT * FROM Discuss WHERE DSID=".$id;
		return $this->db->executeDataTable($sql);		
	}
	public function getChild($parentID){
		$sql="SELECT * FROM Discuss WHERE ParentID=".$parentID;
		return $this->db->executeDataTable($sql);
	}
	public function deleteByPageID($id){
		$sql="DELETE FROM Discuss WHERE DSPageID=".$id;
		return $this->db->executeNonQuery($sql);		
	}
	public function delete($DSID){
		$sql="DELETE FROM Discuss WHERE DSID=".$DSID;
		return $this->db->executeNonQuery($sql);
	}
	public function update(DiscussInfo $dis){
		$sql="UPDATE Discuss SET DSname='".$dis->DSname."',DScontent='".$dis->DScontent."'";
		return $this->db->executeNonQuery($sql);
	}
	public function getDiscuss($start,$rows){
		$sql="SELECT * FROM Discuss ORDER BY DSID DESC  LIMIT ".$start.",".$rows;
		return $this->db->executeDataTable($sql);
	}
	public function getCount(){
		$sql="SELECT COUNT(DISTINCT(DSID)) AS DSCount From Discuss";
		return $this->db->executeDataTable($sql);
	}
	public function getByPage($PageId){
		$sql="SELECT * FROM Discuss WHERE DSPageID=".$PageId." AND ParentID=0";
		return $this->db->executeDataTable($sql);		
	}
	public function getRBYdisID($id){
		$sql="SELECT * FROM Discuss WHERE ParentID=".$id;
		return $this->db->executeDataTable($sql);
	}
	public function updateDATE($DSID,$timeNum){
		$sql="UPDATE Discuss SET DSDate='".$timeNum."'  WHERE DSID=".$DSID;
		return $this->db->executeNonQuery($sql);		
	}
}

?>