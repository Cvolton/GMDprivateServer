<?php
include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";
require "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
$gs = new mainLib();
if(!empty($_POST["userName"]) AND !empty($_POST["password"]) AND !empty($_POST["type"]) AND !empty($_POST["amount"]) AND !empty($_POST["reward"]) AND !empty($_POST["names"])){
	$userName = ExploitPatch::remove($_POST["userName"]);
	$password = ExploitPatch::remove($_POST["password"]);
	$type = ExploitPatch::number($_POST["type"]);
	$amount = ExploitPatch::number($_POST["amount"]);
    $reward = ExploitPatch::number($_POST["reward"]);
    $name = ExploitPatch::remove($_POST["names"]);
	$pass = GeneratePass::isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		$accountID = $query->fetchColumn();
		if($gs->checkPermission($accountID, "toolQuestsCreate") == false){
			echo "This account doesn't have the permissions to access this tool. <a href='addQuests.php'>Try again</a>";
		}else{
			if(!is_numeric($type) OR !is_numeric($amount) OR !is_numeric($reward) OR $type > 3){
				exit("Type/Amount/Reward invalid");
			}
			
			$query = $db->prepare("INSERT INTO quests (type, amount, reward, name) VALUES (:type,:amount,:reward,:name)");
			$query->execute([':type' => $type, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
			$query = $db->prepare("INSERT INTO modactions (type, value, timestamp, account, value2, value3, value4) VALUES ('25',:value,:timestamp,:account,:amount,:reward,:name)");
			$query->execute([':value' => $type, ':timestamp' => time(), ':account' => $accountID, ':amount' => $amount, ':reward' => $reward, ':name' => $name]);
			if($db->lastInsertId() < 3) {
				exit("Successfully added Quest! It's recommended that you should add a few more.");
			} else {
			exit("Successfully added Quest!");
			}
		}
	}else{
        echo "Invalid password or nonexistant account. <a href='addQuest.php'>Try again</a>";
    }
}else{
	echo '<form action="addQuests.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password">
		<br>Quest Type: <select name="type">
			<option value="1">Orbs</option>
			<option value="2">Coins</option>
			<option value="3">Star</option>
		</select>
		<br>Amount: <input type="number" name="amount"> (How many orbs/coins/stars you need to collect)
		<br>Reward: <input type="number" name="reward"> (How many Diamonds you get as a reward)
		<br>Quest Name: <input type="text" name="names">
		<input type="submit" value="Create"></form>';
}
?>
