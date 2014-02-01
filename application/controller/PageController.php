<?php
require_once WEBROOT.'/application/controller/PageBLL.php';
require_once WEBROOT.'/application/controller/TagBLL.php';
require_once WEBROOT.'/application/controller/DenLuBLL.php';
require_once WEBROOT.'/application/controller/DiscussBLL.php';
require_once WEBROOT.'/application/controller/BDFunction.php';
class PageController {
	public $view;
	public function indexAction(){
		$pageBLL=new  PageBLL();
		$this->view->topTable=$pageBLL->getPages(0, 5);
		require_once WEBROOT.'/application/views/index.phtml';
	}
	public function diaryAction(){
		$pageBLL=new  PageBLL();
		$tagBLL= new TagBLL();
		$discussBLL=new DiscussBLL();
		
		$art=$_GET["art"];
		if(!is_null($_GET["art"])){
			if($_GET["art"]=="1") $selectPage="pages";
			if($_GET["art"]=="2") $selectPage="page"; 
			if($_GET["art"]=="3") $selectPage="pageTag";
		}
		else{
			$art=1;
			$selectPage="pages";
		}
		$this->view->selectPage=$selectPage;
		/***
		 * 文章列表
		 */
		if($art==1){
			$page=1;
			if(!is_null($_GET["page"])){
				$page=$_GET["page"];
			}
			$page=$page-1;
			$pageCount=5;
			
			$table=$pageBLL->getPages($page*$pageCount, $pageCount);
			
			for($con=0;$con<$table->count;$con++){
				$table->Rows[$con]['PageTag']=$tagBLL->getCName($table->Rows[$con]['PageTag']);
			}
			$this->view->pageTable=$table;
			$this->view->PageCount=ceil($pageBLL->getCount()->Rows[0]['PageCount']/$pageCount);
			$this->view->Page=$page+1;
			$this->view->title="BreezeDust-Diary";
		}
		/***
		 * 文章内容
		 */
		if($art==2){
			$pageID=0;
			if(!is_null($_GET["pageID"])){
				$pageID=$_GET["pageID"];
			}
			$table=$pageBLL->get($pageID);;
			for($con=0;$con<$table->count;$con++){
				$table->Rows[$con]['PageTag']=$tagBLL->getCName($table->Rows[$con]['PageTag']);
			}
			$this->view->pageTable=$table;
			$this->view->disTable=$discussBLL->getByPage($pageID);
			$this->view->title=$table->Rows[0]['PageName']." | BreezeDust";
			
		}
		/***
		 * 分类文章列表
		*/
		if($art==3){
			$page=1;
			if(!is_null($_GET["page"])){
				$page=$_GET["page"];
			}
			$page=$page-1;
			$pageCount=5;

			$tag=1;
			if(!is_null($_GET["tag"])){
				$tag=$_GET["tag"];
			}
			$this->view->tag=$tag;
			$table=$pageBLL->getPagesByTag($page*$pageCount, $pageCount,$tag);
			
			for($con=0;$con<$table->count;$con++){
				$table->Rows[$con]['PageTag']=$tagBLL->getCName($table->Rows[$con]['PageTag']);
			}
			$this->view->pageTable=$table;
			$this->view->PageCount=ceil($pageBLL->getCount()->Rows[0]['PageCount']/$pageCount);
			$this->view->Page=$page+1;
			$this->view->title= $table->Rows[0]['PageTag']." | BreezeDust-Diary";
			
		}
		
		require_once WEBROOT.'/application/views/diary.phtml';
	}
	
	public function aboutAction(){
		require_once WEBROOT.'/application/views/about.phtml';
	}
	public function projectAction(){
		$art=$_GET["art"];
		if(!is_null($_GET["art"])){
			if($_GET["art"]=="1") $selectPage="mySelf";
			if($_GET["art"]=="2") $selectPage="sheji";
			if($_GET["art"]=="3") $selectPage="cfc";
			if($_GET["art"]=="4") $selectPage="other";
		}
		else{
			$art=1;
			$selectPage="mySelf";
		}
		$this->view->selectPage=$selectPage;
				
		require_once WEBROOT.'/application/views/project.phtml';
	}
	public function loginAction(){
		$denluBLL=new DenLuBLL();
		$userName=$_POST["name"];
		$userPasswd=$_POST["password"];
		if(!is_null($userName) && !is_null($userPasswd)){
			if($denluBLL->login($userName, md5($userPasswd))){
				setcookie("userName",$userName);
				setcookie("userPasswd",md5($userPasswd));
				header('Location: index.php?controller=admin');
			}
		}
		require_once WEBROOT.'/application/views/login.phtml';
	}
	public function adminAction(){
		$pageBLL=new  PageBLL();
		$discussBLL=new DiscussBLL();
		$art=$_GET["art"];
		if(!is_null($_GET["art"])){
			if($_GET["art"]=="0") $selectPage="star";
			if($_GET["art"]=="1") $selectPage="fdiary";
			if($_GET["art"]=="2") $selectPage="apage";
			if($_GET["art"]=="3") $selectPage="adiscuss";
		}
		else{
			$art=0;
			$selectPage="star";
		}
		$this->view->selectPage=$selectPage;
		
		if($art==2){
			$page=1;
			if(!is_null($_GET["page"])){
				$page=$_GET["page"];
			}
			$page=$page-1;
			$pageCount=10;
			
			$cmd=0;
			if(!is_null($_GET["cmd"])){
				$cmd=$_GET["cmd"];
			}			
			/***
			 * delete
			 */
			if($cmd==1){
				$pageID=0;
				if(!is_null($_GET["pageID"])){
					$pageID=$_GET["pageID"];
				}				
				if($pageBLL->delete($pageID)){
					$this->view->msg=true;
				}
				else {
					$this->view->msg=false;
				}
			}
			/***
			 * update
			 */
			if($cmd==2){
				$pageID=0;
				if(!is_null($_GET["pageID"])){
					$pageID=$_GET["pageID"];
				}
				$this->view->pageTable=$pageBLL->get($pageID);
				
				$this->view->selectPage="updatePage";
			}	
			/***
			 * views
			*/
			if($cmd==0 || $cmd==1){
				$table=$pageBLL->getPages($page*$pageCount, $pageCount);
				$this->view->pageTable=$table;
				$this->view->PageCount=ceil($pageBLL->getCount()->Rows[0]['PageCount']/$pageCount);
				$this->view->Page=$page+1;				
			}	
		}
		/***
		 * 评论管理
		 */
		if($art==3){
			$page=1;
			if(!is_null($_GET["page"])){
				$page=$_GET["page"];
			}
			$page=$page-1;
			$pageCount=10;

			$cmd=0;
			if(!is_null($_GET["cmd"])){
				$cmd=$_GET["cmd"];
			}
			/***
			 * delete
			*/
			if($cmd==1){
				$DSID=0;
				if(!is_null($_GET["DSID"])){
					$DSID=$_GET["DSID"];
				}
				if($discussBLL->delete($DSID)){
					$this->view->msg=true;
				}
				else {
					$this->view->msg=false;
				}
			}
			
			$table=$discussBLL->getDiscuss($page*$pageCount, $pageCount);
			$this->view->pageTable=$table;
			$this->view->PageCount=ceil($discussBLL->getCount()->Rows[0]['DSCount']/$pageCount);
			$this->view->Page=$page+1;			
		}
		require_once WEBROOT.'/application/views/admin.phtml';		
	}
	
}

?>