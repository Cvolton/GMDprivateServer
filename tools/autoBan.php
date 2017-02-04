<?php
include "connection.php";
$maxstars = 0;
$query = "SELECT starStars FROM levels";
$query = $db->prepare($query);
$query->execute();
$results = $query->fetchAll();
foreach ($results as $star) {
    $maxstars += $star["starStars"];
}

$bancount = 0;
$query2 = "SELECT stars, userID FROM users";
$query2 = $db->prepare($query2);
$query2->execute();
$allusers = $query2->fetchAll();
foreach ($allusers as $user) {
    if ($user["stars"] > $maxstars) {
        $query3 = "UPDATE users SET isBanned = 1 WHERE userID = :userID";
        $query3 = $db->prepare($query2);
        $query3->execute([':userID' => $user["userID"]]);
        $bancount++;
    }
}

echo $bancount.' Users Banned';
?>
