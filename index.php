<?php
date_default_timezone_set('PRC');
define("WEBROOT",dirname(__FILE__));
require_once WEBROOT.'/application/controller/PageController.php';
require_once WEBROOT.'/application/controller/ApiController.php';
$controller="index";
if(!is_null($_GET["controller"])){
	$controller=$_GET["controller"];
}
if($controller=="api"){
	$ALLontroller=new ApiController();
	$controller=$_GET["action"];
}
else{
	$ALLontroller=new PageController();
}
$controller=$controller."Action";
$ALLontroller->$controller();
?>