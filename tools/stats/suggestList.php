<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
require_once "../../incl/lib/mainLib.php";
$gs = new mainLib();
if(!empty($_POST["userName"]) AND !empty($_POST["password"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($query->rowCount()==0){
			echo "Invalid account/password. <a href='suggestList.php'>Try again.</a>";
		}else if($gs->checkPermission($accountID, "toolSuggestlist")){
			$accountID = $query->fetchColumn();
			$query = $db->prepare("SELECT suggestBy,suggestLevelId,suggestDifficulty,suggestStars,suggestFeatured,suggestAuto,suggestDemon,timestamp FROM suggest ORDER BY timestamp DESC");
			$query->execute();
			$result = $query->fetchAll();
			echo '<table border="1"><tr><th>Time</th><th>Suggested by</th><th>Level ID</th><th>Difficulty</th><th>Stars</th><th>Featured</th></tr>';
		foreach($result as &$sugg){
			echo "<tr><td>".date("d/m/Y G:i", $sugg["timestamp"])."</td><td>".$gs->getAccountName($sugg["suggestBy"])."(".$sugg["suggestBy"].")</td><td>".htmlspecialchars($sugg["suggestLevelId"],ENT_QUOTES)."</td><td>".htmlspecialchars($gs->getDifficulty($sugg["suggestDifficulty"],$sugg["suggestAuto"],$sugg["suggestDemon"]), ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestStars"],ENT_QUOTES)."</td><td>".htmlspecialchars($sugg["suggestFeatured"],ENT_QUOTES)."</td></tr>";
		}
			echo "</table>";
		}else{
			echo "You don't have permissions to view content on this page. <a href='suggestList.php'>Try again.</a>\n";
		}
	}else{
		echo "Invalid account/password. <a href='suggestList.php'>Try again.</a>";
	}
}else{
	echo '<form action="suggestList.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password"><br><input type="submit" value="Show suggested levels"></form>';
}
?>
