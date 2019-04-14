<!DOCTYPE HTML>
<html>
	<head>
		<title>Unlisted Levels</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>
	
	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain">
<?php
include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
if(!empty($_POST["userName"]) AND !empty($_POST["password"])){
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($userName, $password);
	if ($pass == 1) {
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");	
		$query->execute([':userName' => $userName]);
		if($query->rowCount()==0){
			echo "<p>Invalid password or nonexistant account</p><a href=''>Try again</a>";
		}else{
			$accountID = $query->fetchColumn();
			$query = $db->prepare("SELECT levelID, levelName FROM levels WHERE extID=:extID AND unlisted=1");	
			$query->execute([':extID' => $accountID]);
			$result = $query->fetchAll();
			echo '<table><tr><th>ID</th><th>Name</th></tr>';
			foreach($result as &$level){
				echo "<tr><td>".$level["levelID"]."</td><td>".$level["levelName"]."</td></tr>";
			}
			echo "</table>";
		}
	}else{
		echo "<p>Invalid password or nonexistant account</p><a href=''>Try again</a>";
	}
}else{
	echo '<form action="" method="post">
			<input class="smain" type="text" placeholder="Username" name="userName"><br>
			<input class="smain" type="password" placeholder="Password" name="password"><br>
			<input class="smain" type="submit" value="Show Levels">
		</form>';
}
?>
		</div>
	</body>
</html>