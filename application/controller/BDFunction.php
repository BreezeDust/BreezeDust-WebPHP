<?php
class BDFunction {
	/****
	 * $max 为3的倍数
	 */
	public static function getShortStr($str,$max){
		$length=strlen($str);
		if($length<=$max) return $str."...";
		
		$start=$max/3;
		$con=0;
		$newLength=0;
		while (true){
			if($newLength>$max-1) return  $newStr."...";
			$newStr=self::utf8_substr($str,0,$start+$con);
			$newLength=strlen($newStr);
			$con++;
		}
	}
	public function utf8_substr($str, $from, $len, $suffix = '') {
		$str     = trim($str);
		$str     = strip_tags($str);
		$pre_len = strlen($str);
		$str     = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $from .'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'. $len .'}).*#s', '$1', $str);
		if ($pre_len != strlen($str)) {
			$str .= $suffix;
		}
		return $str;
	}
}

?>