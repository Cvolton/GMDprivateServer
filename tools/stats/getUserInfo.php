<!DOCTYPE html>
<html>
	<head>
		<title>Get User Info</title>
		<?php include "../../../../incl/style.php"; ?>
	</head>

	<body>
		<?php include "../../../../incl/navigation.php"; ?>
		
		<div class="smain nofooter">
	
			<h1>Get User Info</h1>
			<form action="" method="get">
				<input class="smain" type="text" placeholder="Username" name="u"><br>
				<input class="smain" type="submit" value="Go">
			</form>
<?php
error_reporting(1);
include "../../incl/lib/connection.php";

if (!empty($_GET['u']))
{
	if (strlen($_GET['u']) < 2)
	{
		exit("<p>Username must be at least 2 characters</p>");
	}
	
	$query = $db->prepare("SELECT * FROM users WHERE userName LIKE CONCAT('%', :uName, '%')");
	$query->execute([':uName' => $_GET['u']]);
	$users = $query->fetchAll();

	$c = count($users);
	echo "<p>Count: $c</p>";
	echo '<table><tr><th>UserName</th><th>UserID</th><th>Stars</th><th>Is Banned</th><th>Ban Reason</th><th>AccountID</th><th>Register Date</th></tr>';
	$idx = 0;
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
		

		$col = $ac == "" ? "505000" : 0 /*"005000"*/;
		$col = $ib != 0 ? "500000" : $col;
		
		echo $col ? "\t\t\t\t<tr style=\"background-color: #$col\">" : "\t\t\t\t<tr>";
		
		echo "<td>$un</td><td>$id</td><td>$st</td><td>$ib</td><td>$reason</td><td>$ac</td><td>$time</td></tr>\n";
		
		$idx++;
	}
	echo '</table>';
}

?>
		</div>
	</body>
</html>