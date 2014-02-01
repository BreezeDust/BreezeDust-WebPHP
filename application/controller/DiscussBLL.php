<?php
require_once WEBROOT.'/application/model/DiscussDAL.php';
require_once WEBROOT.'/application/model/BaseDAL.php';
require_once WEBROOT.'/application/controller/PageBLL.php';
class DiscussBLL {
	private $DAL;
	public function __construct(){
		$this->DAL=new DiscussDAL();
	}
	public function getCount(){
		return $this->DAL->getCount();
	}
	public function getDiscuss($start,$rows){
		return $this->DAL->getDiscuss($start, $rows);
	}
	public function getByID($id){
		return $this->DAL->getByID($id);
	}
	public function deleteByPageID($id){
		return $this->DAL->deleteByPageID($id);
	}
	public function delete($DSID){
		$pageBLL=new PageBLL();
		$table=$this->getByID($DSID);
		if($table->Rows[0]['ParentID']!=0){
			return $this->DAL->delete($DSID);
		}
		if($this->DAL->delete($DSID) && $pageBLL->removeDis($table->Rows[0]['DSPageID'])) return true;
		return false;
	}
	public function add(DiscussInfo $dis){
		$pageBLL=new PageBLL();
		if($dis->DSname=="" || $dis->DScontent=="") return false;
		BaseDAL::lock();
		$dis->DSname=mysql_real_escape_string($dis->DSname);
		$dis->DScontent=mysql_real_escape_string($dis->DScontent);
		$dis->DSDate=date('Y-m-d H:i:s',time());
		$dis->ParentID=0;
		BaseDAL::uplock();
		if($this->DAL->add($dis) && $pageBLL->addDis($dis->DSPageID)) return true;
		return false;
	}
	public function addR(DiscussInfo $dis){
		if($dis->DSname=="" || $dis->DScontent=="") return false;
		BaseDAL::lock();
		$dis->DSname=mysql_real_escape_string($dis->DSname);
		$dis->DScontent=mysql_real_escape_string($dis->DScontent);
		$dis->DSDate=date('Y-m-d H:i:s',time());
		BaseDAL::uplock();
		return $this->DAL->add($dis);
	}
	public function getByPage($PageId){
		return $this->DAL->getByPage($PageId);
	}
	public function getRBYdisID($id){
		return $this->DAL->getRBYdisID($id);
	}
}

?>