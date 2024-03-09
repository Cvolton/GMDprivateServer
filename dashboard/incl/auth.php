<?php
class au {
  function auth($dbPath = '../') {
    if(file_exists($dbPath."incl/lib/connection.php")) include_once $dbPath."incl/lib/connection.php";
    elseif(file_exists("../../$dbPath".''."incl/lib/connection.php")) include_once "../../$dbPath".''."incl/lib/connection.php";
    else include_once "../$dbPath".''."incl/lib/connection.php";
    error_reporting(0);
    if($_SESSION["accountID"] != 0) {
        $query = $db->prepare("SELECT auth FROM accounts WHERE accountID = :id");
        $query->execute([':id' => $_SESSION["accountID"]]);
        $auth = $query->fetch();
        if($_COOKIE["auth"] != $auth["auth"]) $_SESSION["accountID"] = 0;
    } else {
        $query = $db->prepare("SELECT accountID FROM accounts WHERE auth = :id");
        $query->execute([':id' => $_COOKIE["auth"]]);
        $auth = $query->fetch();
        if(!empty($auth) AND $_COOKIE["auth"] != 'none') $_SESSION["accountID"] = $auth["accountID"];
    }
  }
}
?>
