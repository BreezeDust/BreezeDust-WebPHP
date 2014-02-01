<?php
require_once WEBROOT.'/application/controller/PageBLL.php';
require_once WEBROOT.'/application/controller/DenLuBLL.php';
require_once WEBROOT.'/application/controller/DiscussBLL.php';
require_once WEBROOT.'/application/Entity/DiscussInfo.php';
require_once WEBROOT.'/application/Entity/PageInfo.php';
class ApiController {
	public $view;
	public function addDiaryAction(){
		$denluBLL=new DenLuBLL();
		if(!(!is_null($_COOKIE["userName"]) && !is_null($_COOKIE["userPasswd"]) && $denluBLL->login($_COOKIE["userName"], $_COOKIE["userPasswd"]))){
			echo "{msg:'no'}";
			return false;
		}
		$pageBLL=new PageBLL();
		$page=new PageInfo();
		$page->PageName=$_POST['PageName'];
		$page->PageYulan=$_POST['PageYulan'];
		$page->PageContent=$_POST['PageContent'];
		$page->PageTag=$_POST['PageTag'];
		if($pageBLL->add($page)){
			echo "{msg:'ok'}";
		}
		else{
			echo "{msg:'no'}";
		}
	}
	public function updatePageAction(){
		$denluBLL=new DenLuBLL();
		if(!(!is_null($_COOKIE["userName"]) && !is_null($_COOKIE["userPasswd"]) && $denluBLL->login($_COOKIE["userName"], $_COOKIE["userPasswd"]))){
			echo "{msg:'no'}";
			return false;
		}
		$pageBLL=new PageBLL();
		$page=new PageInfo();
		$page->PageID=$_POST['PageID'];
		$page->PageName=$_POST['PageName'];
		$page->PageYulan=$_POST['PageYulan'];
		$page->PageContent=$_POST['PageContent'];
		$page->PageTag=$_POST['PageTag'];
		if($pageBLL->update($page)){
			echo "{msg:'ok'}";
		}
		else{
			echo "{msg:'no'}";
		}		
	}
	public function yanzhengAction(){
		session_start();
		$_SESSION['YZ_a']=rand(100,999);
		$_SESSION['YZ_b']=rand(1,10);
		$_SESSION['YZ_c']=$_SESSION['YZ_a']+$_SESSION['YZ_b'];
		echo "{a:".$_SESSION['YZ_a'].",b:".$_SESSION['YZ_b'].",c:".$_SESSION['YZ_c']."}";
	}
	public function addDiscussRAction(){
		$denluBLL=new DenLuBLL();
		if(!(!is_null($_COOKIE["userName"]) && !is_null($_COOKIE["userPasswd"]) && $denluBLL->login($_COOKIE["userName"], $_COOKIE["userPasswd"]))){
			echo "{msg:'no'}";
			return false;
		}
		$discussBLL=new DiscussBLL();
		$discuss=new DiscussInfo();
		$discuss->DSPageID=$_POST['DSPageID'];
		$discuss->DSname="BreezeDust";
		$discuss->DScontent=$_POST['DScontent'];
		$discuss->ParentID=$_POST['ParentID'];
		if($discussBLL->addR($discuss)){
			echo "{msg:'ok'}";
		}
		else {
			echo "{msg:'no'}";
		}
	}
	public function addDiscussAction(){
		session_start();
		$discussBLL=new DiscussBLL();
		$discuss=new DiscussInfo();
		if($_SESSION['YZ_c']!=$_POST['LYKEY']){
			echo "{msg:'no'}";
			return false;
		}
		$discuss->DSPageID=$_POST['DSPageID'];
		$discuss->DSname=$_POST['DSname'];
		$discuss->DScontent=$_POST['DScontent'];
		if($discussBLL->add($discuss)){
			echo "{msg:'ok'}";
		}
		else {
			echo "{msg:'no'}";
		}
		
	}
}

?>