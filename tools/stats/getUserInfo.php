<html><body><h1>USERINFO</h1>
<form action="getUserInfo.php" method="get">Target Username: <input type="text" name="u"><input type="submit" value="Go"></form>
<?php
error_reporting(1);
include "../../incl/lib/connection.php";

if (!empty($_GET['u']))
{
	$query = $db->prepare("SELECT * FROM users WHERE userName LIKE CONCAT('%', :uName, '%')");
	$query->execute([':uName' => $_GET['u']]);
	$users = $query->fetchAll();

	$c = count($users);
	echo "<p>Count: $c</p>";	
	echo '<table border=1><tr><th>UserName</th><th>UserID</th><th>Stars</th><th>Is Banned</th><th>Ban Reason</th><th>AccountID</th><th>Register Date</th></tr>';
	foreach ($users as &$user)
	{
		$un = $user['userName'];
		$id = $user['userID'];
		$st = $user['stars'];
		$ib = $user['isBanned'];
		$reason = $user['banReason'];
		$time = "";//date("d/m/y H:i:s", $user['registerDate']);

		if (empty($reason) AND $ib == 1)
		{
			$reason = "<b>None.</b>";
		}
		$ac = $user['extID'];
		if (!is_numeric($ac))
		{
			$ac = "";
		}
		else
		{
			$q = $db->prepare("SELECT registerDate FROM accounts WHERE accountID = :accid");
			$q->execute([':accid' => $ac]);
			$time = date("d/m/y H:i:s", $q->fetch()[0]);
		}
		
		$col = $ac == "" ? "FFFF00" : "00FF00";
		$col = $ib != 0 ? "FF0000" : $col;
		
		echo "<tr bgcolor=\"$col\"><td>$un</td><td>$id</td><td>$st</td><td>$ib</td><td>$reason</td><td>$ac</td><td>$time</td></tr>";
	}
	echo '</table>';
}

?>
</body></html>