<?php
function delete($uploadDate, $accountID, $levelID) {
    include dirname(__FILE__)."/../../lib/connection.php";
    if(!is_numeric($levelID)){
        return false;
    }
    $query = $db->prepare("DELETE from levels WHERE levelID=:levelID LIMIT 1");
    $query->execute([':levelID' => $levelID]);
    $query = $db->prepare("INSERT INTO modactions (type, value, value3, timestamp, account) VALUES ('6', :value, :levelID, :timestamp, :id)");
    $query->execute([':value' => "1", ':timestamp' => $uploadDate, ':id' => $accountID, ':levelID' => $levelID]);
    if(file_exists(dirname(__FILE__)."../../data/levels/$levelID")){
        rename(dirname(__FILE__)."../../data/levels/$levelID",dirname(__FILE__)."../../data/levels/deleted/$levelID");
    }
    return true;
}
?>