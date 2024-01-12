<?php
//credits to pavlukivan for decoding and to IAD for most of genSolo
if(!function_exists("intdiv")) {
	function intdiv($a, $b){
		return ($a - $a % $b) / $b;
	}
}
class GenerateHash {
	public static function genMulti($lvlsmultistring) {
		include dirname(__FILE__)."/connection.php";
		$hash = "";
		foreach($lvlsmultistring as $result) {
			$id = strval($result['levelID']);
			$hash = $hash . $id[0].$id[strlen($id)-1].$result["stars"].$result["coins"];
		}
		return sha1($hash . "xI25fpAapCQg");
	}
	public static function genSolo($levelstring) {
		$len = strlen($levelstring);
		if($len < 41)return sha1("{$levelstring}xI25fpAapCQg");
		$hash = '????????????????????????????????????????xI25fpAapCQg';
		$m = intdiv($len, 40);
		$i = 40;
		while($i)$hash[--$i] = $levelstring[$i*$m];
		return sha1($hash);
	}
	public static function genSolo2($lvlsmultistring) {
		return sha1($lvlsmultistring . "xI25fpAapCQg");
	}
	public static function genSolo3($lvlsmultistring) {
		return sha1($lvlsmultistring . "oC36fpYaPtdg");
	}
	public static function genSolo4($lvlsmultistring){
		return sha1($lvlsmultistring . "pC26fpYaQCtg");
	}
	public static function genPack($lvlsmultistring) {
		$lvlsarray = explode(",", $lvlsmultistring);
		include dirname(__FILE__)."/connection.php";
		$hash = "";
		foreach($lvlsarray as $id){
			$query=$db->prepare("SELECT ID,stars,coins FROM mappacks WHERE ID = :id");
			$query->execute([':id' => $id]);
			$result2 = $query->fetchAll();
			$result = $result2[0];
			$idstring = strval($result["ID"]);
			$hash = $hash . $idstring[0].$idstring[strlen($idstring)-1].$result["stars"].$result["coins"];
		}
		return sha1($hash . "xI25fpAapCQg");
	}
	public static function genSeed2noXor($levelstring) {
		$hash = "aaaaa";
		$len = strlen($levelstring);
		$divided = intval($len/50);
		$p = 0;
		for($k = 0; $k < $len ; $k= $k+$divided){
			if($p > 49) break;
			$hash[$p] = $levelstring[$k]; 
			$p++;
		}
		$hash = sha1($hash."xI25fpAapCQg");
		return $hash;
	}
}
?>
