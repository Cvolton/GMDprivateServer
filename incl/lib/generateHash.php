<?php
//credits to pavlukivan for decoding and to IAD for most of genSolo
class generateHash {
	public function genMulti($lvlsmultistring) {
		$lvlsarray = explode(",", $lvlsmultistring);
		include dirname(__FILE__)."/connection.php";
		$hash = "";
		foreach($lvlsarray as $id){
			//moving levels into the new system
			if(!is_numeric($id)){
				exit("-1");
			}
			$query=$db->prepare("SELECT levelString, levelID, starStars, starCoins FROM levels WHERE levelID = :id");
			$query->execute([':id' => $id]);
			$result2 = $query->fetchAll();
			$result = $result2[0];
			$levelString = $result["levelString"];
			if(!file_exists(dirname(__FILE__)."/../../data/levels/$id")){
				file_put_contents(dirname(__FILE__)."/../../data/levels/$id",$levelString);
				$query = $db->prepare("UPDATE levels SET levelString = '' WHERE levelID = :levelID");
				$query->execute([':levelID' => $id]);
			}
			//generating the hash
			$hash = $hash . $result["levelID"][0].$result["levelID"][strlen($result["levelID"])-1].$result["starStars"].$result["starCoins"];
		}
		return sha1($hash . "xI25fpAapCQg");
	}
	public function genSolo($levelstring) {
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
	public function genSolo2($lvlsmultistring) {
		return sha1($lvlsmultistring . "xI25fpAapCQg");
	}
	public function genSolo3($lvlsmultistring) {
		return sha1($lvlsmultistring . "oC36fpYaPtdg");
	}
	public function genSolo4($lvlsmultistring){
		return sha1($lvlsmultistring . "pC26fpYaQCtg");
	}
	public function genPack($lvlsmultistring) {
		$lvlsarray = explode(",", $lvlsmultistring);
		include dirname(__FILE__)."/connection.php";
		$hash = "";
		foreach($lvlsarray as $id){
			$query=$db->prepare("SELECT ID,stars,coins FROM mappacks WHERE ID = :id");
			$query->execute([':id' => $id]);
			$result2 = $query->fetchAll();
			$result = $result2[0];
			$hash = $hash . $result["ID"][0].$result["ID"][strlen($result["ID"])-1].$result["stars"].$result["coins"];
		}
		return sha1($hash . "xI25fpAapCQg");
	}
	public function genSeed2noXor($levelstring) {
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