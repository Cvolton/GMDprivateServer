<?php
//credits to pavlukivan for decoding and to IAD for most of genSolo
class GenerateHash {
	public static function genMulti($lvlsarray) {
		include dirname(__FILE__)."/connection.php";
		$hash = "";
		foreach($lvlsarray as $id){
			$query=$db->prepare("SELECT levelID, starStars, starCoins FROM levels WHERE levelID = :id");
			$query->execute([':id' => $id]);
			$result2 = $query->fetchAll();
			$result = $result2[0];
			$idstring = strval($result["levelID"]);
			$hash = $hash . $idstring[0].$idstring[strlen($idstring)-1].$result["starStars"].$result["starCoins"];
		}
		return sha1($hash . "xI25fpAapCQg");
	}
	public static function genSolo($levelstring) {
		$hash = "aaaaa";
		$len = strlen($levelstring);
		$divided = intval($len/40);
		$p = 0;
		for($k = 0; $k < $len ; $k= $k+$divided){
			if($p > 39) break;
			$hash[$p] = $levelstring[$k]; 
			$p++;
		}
		return sha1($hash . "xI25fpAapCQg");
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