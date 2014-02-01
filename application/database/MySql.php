<?php
require_once WEBROOT.'/application/Entity/DataTable.php';

class MySql {
	private $con;
	public function  __construct(){

	}
	public function initConnect(){
		$host = getenv('HTTP_BAE_ENV_ADDR_SQL_IP');
		$port = getenv('HTTP_BAE_ENV_ADDR_SQL_PORT');
		$user = getenv('HTTP_BAE_ENV_AK');
		$pwd = getenv('HTTP_BAE_ENV_SK');
		$dbname = 'kkstioMIfEIQPISgdOPr';
		$this->con = @mysql_connect("{$host}:{$port}",$user,$pwd,true);
		if(!$this->con) {
			die("Connect Server Failed: " . mysql_error());
		}
		mysql_select_db($dbname, $this->con);	
		mysql_query("set names utf8");
	}
	public function getConnect(){
		$this->initConnect();
	}
	public function replay(){
		mysql_close($this->con);
	}
	/**
	 * execute : update,delete,insert
	 * @param String $sql
	 * @return boolean
	 */
	public function executeNonQuery($sql){
		$this->initConnect();
		$result=mysql_query($sql);
		mysql_close($this->con);
		return $result;
	}
	public function executeDataTable($sql){
		$this->initConnect();
		$result=mysql_query($sql);
		
		$table=new DataTable();
		$cons=0;
		while($row = mysql_fetch_array($result))
		{
			$table->Rows[$cons++]=$row;
		}
		$table->count=$cons;
		mysql_close($this->con);
		return $table;
	}
	public function ExecuteScalar($sql){
		
	}
}

?>