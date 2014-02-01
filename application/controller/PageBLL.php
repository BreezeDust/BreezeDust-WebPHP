<?php
require_once WEBROOT.'/application/model/PageDAL.php';
require_once WEBROOT.'/application/model/BaseDAL.php';
require_once WEBROOT.'/application/controller/DiscussBLL.php';
class PageBLL {
	private $DAL;
	public function __construct(){
		$this->DAL=new PageDAL();
	}
	public function add(PageInfo $page){
		if($page->PageName=="" || $page->PageContent=="") return false;
		BaseDAL::lock();
		$page->PageContent=mysql_real_escape_string($page->PageContent);
		$page->PageYulan=mysql_real_escape_string($page->PageYulan);
		$page->PageName=mysql_real_escape_string($page->PageName);
		$page->PageDate=date('Y-m-d H:i:s',time());
		BaseDAL::uplock();
		return $this->DAL->add($page);
	}
	public  function delete($id){
		$discussBLL=new DiscussBLL();
		if($this->DAL->delete($id) && $discussBLL->deleteByPageID($id)) return true;
		return  false;;
	}
	public function update(PageInfo $page){
		if($page->PageName=="" || $page->PageContent=="") return false;
		BaseDAL::lock();
		$page->PageContent=mysql_real_escape_string($page->PageContent);
		$page->PageYulan=mysql_real_escape_string($page->PageYulan);
		$page->PageName=mysql_real_escape_string($page->PageName);
		BaseDAL::uplock();
		return $this->DAL->update($page);
	}
	public function get($id){
		return $this->DAL->get($id);
	}
	public function getPages($start,$rows){
		return $this->DAL->getPages($start, $rows);
	}
	public function getPagesByTag($start,$rows,$tag){
		return $this->DAL->getPagesByTag($start, $rows, $tag);
	}
	public function getCount(){
		return $this->DAL->getCount();
	}
	public function addDis($pageID){
		$table=$this->get($pageID);
		$count=$table->Rows[0]['PageDiscuss']+1;
		return $this->DAL->addDis($pageID, $count);
	}
	public function removeDis($pageID){
		$table=$this->get($pageID);
		$count=$table->Rows[0]['PageDiscuss']-1;
		return $this->DAL->addDis($pageID, $count);
	}	
}

?>