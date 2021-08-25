<?php
//Cloud save encryption has been forcefully disabled in backupGJAccount and support for cloud encrypted saves might be removed from the server source altogether in the future
//$cloudSaveEncryption = 0; //0 = password string replacement, 1 = cloud save encryption (password dependant)

$sessionGrants = 1; //0 = GJP check is done every time; 1 = GJP check is done once per hour; drastically improves performance, slightly descreases security
?>