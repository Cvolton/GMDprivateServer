<html><head><title>MOD</title></head><body><h1>ADMIN: SET MOD</h1>

<form action="mod.php" method="post">
Username: <input type="text" name="u"><br>
Password: <input type="password" name="p"><br>
AccountID: <input type="text" name="id"> <a href="../stats/getUserInfo.php" target="_blank">Get AccountID</a><br>
Set Mod: <input type="text" name="mod" value="1"> 0 = Remove Mod, 1 = Give Mod<br>
<input type="submit" value="Go">
</form>

<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require "../../incl/lib/webhooks/webhook.php";

if (!empty($_POST['u']) AND !empty($_POST['p']) AND !empty($_POST['id']))
{
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($_POST['u'], $_POST['p']);
	
	$q = $db->prepare("SELECT isHeadAdmin FROM accounts WHERE userName = :un");
	$q->execute([':un' => $_POST['u']]);
	$result = $q->fetch()[0];
	
	if ($pass)
	{
		if ($result == "1")
		{
			$query = $db->prepare("UPDATE accounts SET isAdmin = :mod WHERE accountID = :accid");
			$query->execute([':mod' => $_POST['mod'], ':accid' => $_POST['id']]);
		
			PostToHook("Mod Update", "Account ".$_POST['id']."'s mod status updated to: ".$_POST['mod']);
		
			echo "SUCCESS.";
		}
		else
		{
			echo "USER NOT ADMIN.";
		}
	}
	else
	{
		echo "INVALID USERNAME/PASSWORD.";
	}
}
else
{
	echo "MISSING FIELDS.";
}

?></body></html>