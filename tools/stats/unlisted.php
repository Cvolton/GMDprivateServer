<?php

include "../../incl/lib/connection.php";
require "../../incl/lib/generatePass.php";
require_once "../../incl/lib/exploitPatch.php";
if (!empty($_POST["userName"]) and !empty($_POST["password"])) {
    $userName = ExploitPatch::remove($_POST["userName"]);
    $password = ExploitPatch::remove($_POST["password"]);
    $pass = GeneratePass::isValidUsrname($userName, $password);
    if ($pass == 1) {
        $query = $db->prepare("SELECT accountID FROM accounts WHERE userName=:userName");
        $query->execute([':userName' => $userName]);
        if ($query->rowCount()==0) {
            echo "Invalid password or nonexistant account. <a href='unlisted.php'>Try again</a>";
        } else {
            $accountID = $query->fetchColumn();
            $query = $db->prepare("SELECT levelID, levelName FROM levels WHERE extID=:extID AND unlisted=1");
            $query->execute([':extID' => $accountID]);
            $result = $query->fetchAll();
            echo '<table border="1"><tr><th>ID</th><th>Name</th></tr>';
            foreach ($result as &$level) {
                echo "<tr><td>".$level["levelID"]."</td><td>".$level["levelName"]."</td></tr>";
            }
            echo "</table>";
        }
    } else {
        echo "Invalid password or nonexistant account. <a href='unlisted.php'>Try again</a>";
    }
} else {
    echo '<form action="unlisted.php" method="post">Username: <input type="text" name="userName">
		<br>Password: <input type="password" name="password"><br><input type="submit" value="Show Unlisted Levels"></form>';
}
