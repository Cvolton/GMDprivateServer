<?php
include "../connection.php";
require "../incl/generatePass.php";
require_once "../incl/exploitPatch.php";
$ep = new exploitPatch();
//here im getting all the data
$userName = $ep->remove($_POST["userName"]);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
if($userName != "" AND $password != ""){
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT * FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		if($query->rowCount()==0){
			echo "Invalid password or nonexistant account. <a href='unlisted.php'>Try again</a>";
		}else{
			$result = $query->fetchAll();
			$query = $db->prepare("SELECT levelID, levelName FROM levels WHERE extID=:extID AND unlisted=1");	
			$query->execute([':extID' => $result[0]["accountID"]]);
			$result = $query->fetchAll();
			echo '<table border="1"><tr><th>ID</th><th>Name</th></tr>';
			foreach($result as &$level){
				echo "<tr><td>".$level["levelID"]."</td><td>".$level["levelName"]."</td></tr>";
			}
			echo "</table>";
		}
	}else{
		echo "Invalid password or nonexistant account. <a href='unlisted.php'>Try again</a>";
	}
}else{
	echo '<form action="unlisted.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password"><br><input type="submit" value="Change"></form>';
}
?>