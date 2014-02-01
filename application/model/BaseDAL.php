<?php
require_once WEBROOT.'/application/database/MySql.php';
class BaseDAL {
	private static $db;
	public static function lock(){
		self::$db=new MySql();
        self::$db->getConnect();
	}
	public static function uplock(){
		self::$db->replay();
		self::$db=null;
	}
}

?>