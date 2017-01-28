<?php
//credits to pavlukivan for decoding and to IAD for most of genSolo
class songReup {
	public function reup($result) {
		include dirname(__FILE__)."/../connection.php";
		$resultfixed = str_replace("~", "", $result);
		$resultarray = explode('|', $resultfixed);
		//var_dump($resultarray);
		$uploadDate = time();
		$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download)
		VALUES ('$resultarray[1]','$resultarray[3]', '$resultarray[5]', '$resultarray[7]', '$resultarray[9]', '$resultarray[13]')");
		$query->execute();
		return $db->lastInsertId();
	}
}
?>