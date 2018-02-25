<html><head><title>Search Comments</title></head><body><h1>COMMENT SEARCH</h1><hr><p>Seperate UserIDs and words by spaces, put phrases in quotes</p><p>If you want to exclude a userid/word/phrase, put a `-` before it.</p><p>Words & phrases need to be at least 2 characters and less than 32.</p><p>Maximum of 32 total words and phrases.</p><p>e.g. <b><i>thing "my phrase" -no "-dios mio"</i></b> will search for comments:</p><ul><li><b>With</b> the word "thing"</li><li><b>With</b> the phrase "my phrase"</li><li><b>Without</b> the word "no"</li><li><b>Without</b> the phrase "dios mio"</li></ul><hr>

<?php

include "../../incl/lib/connection.php";

$ss = array();
$ss[$_GET['s']] = " selected";

$so = array();
$so[$_GET['o']] = " selected";

echo '<form action="comments.php" method="get">
Query: <input type="text" name="q" value="'.htmlspecialchars($_GET['q']).'">
UserIDs: <input type="text" name="u" value="'.$_GET['u'].'">
Search By: <select name="s"><option value="0"'.$ss[0].'>Time</option><option value="1"'.$ss[1].'>Comment</option><option value="2"'.$ss[2].'>UserID</option><option value="3"'.$ss[3].'>Username</option><option value="4"'.$ss[4].'>LevelID</option><option value="5"'.$ss[5].'>Likes</option></select>
Order: <select name="o"><option value="0"'.$so[0].'>Ascending</option><option value="1"'.$so[1].'>Descending</option></select><br>
<input type="submit" value="Go"></form><hr>';

if (!empty($_GET['q']))
{
	$start = microtime(true);

	$searchquery = $_GET['q'];
	$uids = $_GET['u'];
	$searchby = (int)($_GET['s']);
	$order = (int)($_GET['o']);
	
	while (strpos($searchquery, '  ') !== false)
	{
		$searchquery = str_replace('  ', ' ', $searchquery);
	}
	
	while (strpos($uids, '  ') !== false)
	{
		$uids = str_replace('  ', ' ', $uids);
	}
	
	$incluids = array();
	$excluids = array();
	$inclstr = array();
	$exclstr = array();
	
	foreach (explode(' ', $uids) as $uid)
	{
		if (strlen($uid))
		{
			if (substr($uid, 0, 1) === "-")
			{
				array_push($excluids, (int)(str_replace('-', '', $uid)));
			}
			else
			{
				array_push($incluids, (int)$uid);
			}
		}
	}
	
	
	preg_match_all('/"([^"]+)"/', $searchquery, $phrases, PREG_PATTERN_ORDER);
	$phrases = array_slice($phrases, count($phrases)/2);
	$s = preg_replace('/"([^"]+)"/', ' ', $searchquery);
	
	while (strpos($s, '  ') !== false)
	{
		$s = str_replace('  ', ' ', $s);
	}
	
	array_push($phrases, explode(' ', $s));
	$phrases = array_reduce($phrases, 'array_merge', array());
	
	foreach ($phrases as $phrase)
	{
		if (strlen($phrase))
		{
			$phrase = str_replace('(', '', $phrase);
			$phrase = str_replace(')', '', $phrase);
			$phrase = str_replace(',', '', $phrase);

			if (substr($phrase, 0, 1) === "-" AND strlen($phrase) >= 3 AND strlen($phrase) < 32)
			{
				array_push($exclstr, htmlspecialchars(str_replace('-', '', $phrase)));
			}
			else if (substr($phrase, 0, 1) !== "-" AND strlen($phrase) >= 2 AND strlen($phrase) < 32)
			{
				array_push($inclstr, htmlspecialchars($phrase));
			}
		}
	}
	
	if (count($exclstr) + count($inclstr) <= 32)
	{
		if (count($incluids) == 0)
		{
			$incluids = array("0 OR 1");
		}
	
		$query = "SELECT comment, userID, userName, levelID, likes, timestamp FROM comments WHERE ((";
		
		foreach ($inclstr as $str)
		{
			$query .= "FROM_BASE64(`comment`) LIKE '%".$str."%' OR ";
		}
		$query .= "0) AND (";
		foreach ($exclstr as $str)
		{
			$query .= "FROM_BASE64(`comment`) NOT LIKE '%$str%' AND ";
		}

		$query .= "1)) AND ((";
		
		foreach ($incluids as $id)
		{
			$query .= "userID = $id OR ";
		}
		$query .= "0) AND (";
		foreach ($excluids as $id)
		{
			$query .= "userID <> $id AND ";
		}
		
		$query .= "1)) ORDER BY ";
		$orderbystr = "";
		
		switch ($searchby)
		{
		case 1:
			$orderbystr = "comment";
			break;
		case 2:
			$orderbystr = "userID";
			break;
		case 3:
			$orderbystr = "userName";
			break;
		case 4:
			$orderbystr = "levelID";
			break;
		case 5:
			$orderbystr = "likes";
			break;
		default:
			$orderbystr = "timestamp";
			break;
		}
		
		$query .= $orderbystr;
		$orderstr = "";
		
		switch ($order)
		{
		case 1:
			$query .= " DESC";
			$orderstr = "descending";
			break;
		default:
			$query .= " ASC";
			$orderstr = "ascending";
			break;
		}
		
		$q = $db->prepare($query);
		$q->execute();

		$result = $q->fetchAll();

		$end = microtime(true);
		$taken = $end - $start;

		echo "<p>Count: ".count($result).". Time taken: ".round($taken, 4)."s</p><p>Search Filters:</p><ul>";
		
		if (count($inclstr))
		{
		echo "<li>Comments <i>with one or more</i> of the words/phrases: ".implode(", ", $inclstr).".</li>";
		}
		if (count($exclstr))
		{
		echo "<li>Comments <i>without none</i> of the words/phrases: ".implode(", ", $exclstr).".</li>";
		}
		if ($incluids[0] != "0 OR 1")
		{
		echo "<li>Comments <i>uploaded by either</i> of the following users: ".implode(", ", $incluids).".</li>";
		}
		if (count($excluids))
		{
		echo "<li>Comments <i>uploaded by neither</i> of the follow users: ".implode(", ", $excluids).".</li>";
		}
		echo "<li>Ordered by `$orderbystr` in $orderstr order.</li>";
		
		echo '</ul><hr><table border="1"><tr><th>Time</th><th>Comment</th><th>UserName</th><th>UserID</th><th>Likes</th><th>LevelID</th></tr>';
		
		for ($i = 0; $i < count($result); $i++)
		{
			$time = date("d/m/y h:i:s", $result[$i]['timestamp']);
			$comment = htmlspecialchars(base64_decode($result[$i]['comment']));
			foreach ($inclstr as $kw)
			{
				$comment = preg_replace("/($kw)/i","<b>$1</b>", $comment);
			}
			$username = $result[$i]['userName'];
			$userID = $result[$i]['userID'];
			$likes = $result[$i]['likes'];
			$levelID = $result[$i]['levelID'];
			echo "<tr><td>$time</td><td>$comment</td><td>$username</td><td>$userID</td><td>$likes</td><td>$levelID</td></tr>";
		}
		
		echo '</table>';
	}
}

?></body></html>