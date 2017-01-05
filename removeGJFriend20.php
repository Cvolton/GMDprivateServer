<?php
include "connection.php";
$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
$targetAccountID = htmlspecialchars($_POST["targetAccountID"],ENT_QUOTES);
// REMOVING FOR USER 1
$query = "SELECT * FROM accounts WHERE accountID = '$accountID'";
$query = $db->prepare($query);
$query->execute();
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friendlist = $accinfo["friends"];
$friends = $accinfo["friends"];
$friendsarray = explode(',',$friendlist);
if(($key = array_search($targetAccountID, $friendsarray)) !== false) {
    unset($friendsarray[$key]);
}
$newfriends = implode(",",$friendsarray);
$query = $db->prepare("UPDATE accounts SET friends='$newfriends' WHERE accountID='$accountID'");
$query->execute();
// REMOVING FOR USER 2
$query = "SELECT * FROM accounts WHERE accountID = '$targetAccountID'";
$query = $db->prepare($query);
$query->execute();
$requests = $query->rowCount();
$result = $query->fetchAll();
$accinfo = $result[0];
$friendlist = $accinfo["friends"];
$friends = $accinfo["friends"];
$friendsarray = explode(',',$friendlist);
if(($key = array_search($accountID, $friendsarray)) !== false) {
    unset($friendsarray[$key]);
}
$newfriends = implode(",",$friendsarray);
$query = $db->prepare("UPDATE accounts SET friends='$newfriends' WHERE accountID='$targetAccountID'");
$query->execute();
//RESPONSE SO IT DOESNT SAY "FAILED"
echo "1";
?>