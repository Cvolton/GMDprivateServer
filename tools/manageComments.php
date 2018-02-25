<html><head><title>Comment Manager</title></head><body><h1>MANAGE COMMENTS</h1>

<form action="manageComments.php" method="get">
LevelID: <input type="text" name="id">
<input type="submit" value="Go">
</form>

<?php

include "../incl/lib/connection.php";
require "../incl/lib/generatePass.php";

if (!empty($_GET['id']))
{
	$query = $db->prepare("SELECT userName, userID, comment, commentID, isSpam FROM comments WHERE levelID = :levelid ORDER BY timestamp DESC");
	$query->execute([':levelid' => (int)($_GET['id'])]);
	
	
	echo "<form action=\"manageComments.php\" method=\"post\"><table border=\"1\"><tr><th>Hidden</th><th>Username</th><th>UserID</th><th>Comment</th><th>CommentID</th></tr>";
	
	$results = $query->fetchAll();
	
	for ($i = 0; $i < count($results); $i++)
	{
		$username = $results[$i]['userName'];
		$userid = $results[$i]['userID'];
		$comment = htmlspecialchars(base64_decode($results[$i]['comment']));
		$commentid = $results[$i]['commentID'];
		$checked = $results[$i]['isSpam'] != 0 ? "checked" : "";
		
		echo "<tr><td><center><input type=\"hidden\" name=\"$commentid\" value=\"0\"><input type=\"checkbox\" value=\"1\"$checked name=\"$commentid\"></center></td><td>$username</td><td>$userid</td><td>$comment</td><td>$commentid</td></tr>";
	}
	
	echo "</table><br>Username: <input type=\"text\" name=\"u\"><br>Password: <input type=\"password\" name=\"p\"><br><input type=\"submit\" value=\"Go\"></form>";
}
else if (!empty($_POST['u']) and !empty($_POST['p']))
{	
	$generatePass = new generatePass();
	$pass = $generatePass->isValidUsrname($_POST["u"], $_POST["p"]);
	if ($pass == 1)
	{
		$query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName AND isAdmin = 1");	
		$query->execute([':userName' => $_POST["u"]]);
		if($query->rowCount()==0)
		{
			echo "<p>Account isn't mod.</p>";
		}
		else
		{
			$on = array();
			$off = array();
			foreach ($_POST as $key => $value)
			{
				if (is_numeric($key))
				{
					if ($value == 0)
					{
						array_push($off, $key);
					}
					else
					{
						array_push($on, $key);
					}
				}
			}
			
			//$query1 = $db->prepare("UPDATE comments SET isSpam = '0' WHERE commentID IN (:ids)");
			//$query1->execute([':ids' => implode(", ", $off)]);
			//echo var_dump($off).'<br>'.$query1->rowCount().'<br>';
			//$query2 = $db->prepare("UPDATE comments SET isSpam = '1' WHERE commentID IN (:ids)");
			//$query2->execute([':ids' => implode(", ", $on)]);
			//echo var_dump($on).'<br>'.$query2->rowCount().'<br>';
			
			echo '<p>Probably worked.</p>';
		}
	}
	else
	{
		echo '<p>Invalid credentials.</p>';
	}
}


?></body></html>