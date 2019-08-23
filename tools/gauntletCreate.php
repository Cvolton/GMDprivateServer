<font face="verdana"><?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
require "../incl/lib/mainLib.php";
$gs = new mainLib();
$userName = $ep->remove($_POST["userName"]);
$password = $ep->remove($_POST["password"]);
	$ID = $ep->remove($_POST["gauntletID"]);
	$level1 = $ep->remove($_POST["level1"]);
	$level2 = $ep->remove($_POST["level2"]);
	$level3 = $ep->remove($_POST["level3"]);
	$level4 = $ep->remove($_POST["level4"]);
	$level5 = $ep->remove($level5);
if(!empty($userName) AND !empty($password) AND !empty($ID)){
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolPackcreate") == false){
			echo "This account doesn't have the permissions to access this tool. <a href='gauntletCreate.php'>Try again</a>";
		}else{
			if (!empty($level1) AND !empty($level2) AND !empty($level3) AND !empty($level4) AND !empty($level5)) {
			if(!is_numeric($level1) OR !is_numeric($level2) OR !is_numeric($level3) OR !is_numeric($level4) OR !is_numeric($level5)){
				exit("Invalid level id's");
			}
				$query = $db->prepare("INSERT INTO gauntlets (ID, level1, level2, level3, level4, level5) VALUES (?, ?, ?, ?, ?, ?)");
				$query->execute(array($ID, $level1, $level2, $level3, $level4, $level5));
				echo "Success!";
			} else {
				// CAN ANYONE OPTIMIZE THIS PLEASE
				$query = $db->prepare("DELETE FROM `gauntlets` WHERE `ID` = ?");
				$query->execute(array($ID));
				exit('Woosh, the gauntlet is GONE (Already).<center><iframe width="560" height="315" src="https://www.youtube.com/embed/LDU_Txk06tM?start=75" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></center>');
			}
		}
	}else{
		echo "Invalid password or nonexistant account. <a href='gauntletCreate.php'>Try again</a>";
	}
}else{
	echo '<form action="gauntletCreate.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password">
		<br>Gauntlet ID: <input type="text" name="gauntletID"> List of Gauntlet ID\'s can be found <a href="https://cdn.discordapp.com/attachments/277466888223850497/278235859583500290/unknown.png">here.</a> (Current Window will close.)
		<br><b>Insert only Level ID\'s, one for each box in order.</b> If you wish to delete a Gauntlet, leave the Boxes below empty.
		<br>Level 1: <input type="text" name="level1" size="2"> 
		Level 2: <input type="text" name="level2" size="2"> 
		Level 3: <input type="text" name="level3" size="2"> 
		Level 4: <input type="text" name="level4" size="2"> 
		Level 5: <input type="text" name="level5" size="2">
		<br><br><input type="submit" value="Create / UPDATE Gauntlet."></form>';
}
?>