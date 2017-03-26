<?php
//credits to pavlukivan for decoding and to IAD for most of genSolo
class songReup {
	public function reup($result) {
		include dirname(__FILE__)."/connection.php";
		$resultfixed = str_replace("~", "", $result);
		$resultarray = explode('|', $resultfixed);
		//var_dump($resultarray);
		$uploadDate = time();
		$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download)
		VALUES (:id, :name, :authorID, :authorName, :size, :download)");
		$query->execute([':id'=>$resultarray[1], ':name' => $resultarray[3], ':authorID' => $resultarray[5], ':authorName' => $resultarray[7], ':size' => $resultarray[9], ':download' => $resultarray[13]]);
		return $db->lastInsertId();
	}
}
?>