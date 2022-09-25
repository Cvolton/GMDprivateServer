<?php
include "../incl/lib/connection.php";
include "../config/dashboard.php";
if(!$installed) {
	$info = $db->query("SHOW VARIABLES like '%version%'")->fetchAll(PDO::FETCH_KEY_PAIR);
	$server  = strtok($info['version_comment']," ");
  	$ver = $info['version'];
  	if($server == 'MariaDB' AND $ver > 10) {
      $db->query("ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardLevelPackCreate INT NOT NULL DEFAULT '0' AFTER dashboardModTools; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardAddMod INT NOT NULL DEFAULT '0' AFTER dashboardLevelPackCreate; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardManageSongs INT NOT NULL DEFAULT '0' AFTER dashboardAddMod; 
      ALTER TABLE roles ADD COLUMN IF NOT EXISTS dashboardForceChangePassNick INT NOT NULL DEFAULT '0' AFTER dashboardManageSongs; 
      ALTER TABLE songs ADD COLUMN IF NOT EXISTS reuploadID INT NOT NULL DEFAULT '0' AFTER reuploadTime; 
      ALTER TABLE users ADD COLUMN IF NOT EXISTS banReason NOT NULL DEFAULT 'none' AFTER isCreatorBanned");
	} else {
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardLevelPackCreate'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardLevelPackCreate INT NOT NULL DEFAULT '0' AFTER dashboardModTools");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardAddMod'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardAddMod INT NOT NULL DEFAULT '0' AFTER dashboardLevelPackCreate");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardManageSongs'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardManageSongs INT NOT NULL DEFAULT '0' AFTER dashboardAddMod");
		$check = $db->query("SHOW COLUMNS FROM `roles` LIKE 'dashboardForceChangePassNick'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE roles ADD dashboardForceChangePassNick INT NOT NULL DEFAULT '0' AFTER dashboardManageSongs");
		$check = $db->query("SHOW COLUMNS FROM `songs` LIKE 'reuploadID'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE songs ADD reuploadID INT NOT NULL DEFAULT '0' AFTER reuploadTime");
		$check = $db->query("SHOW COLUMNS FROM `users` LIKE 'banReason'");
      	$exist = $check->fetchAll();
      	if(empty($exist)) $db->query("ALTER TABLE users ADD banReason varchar(255) NOT NULL DEFAULT 'none' AFTER isCreatorBanned");
	}
	$lines = file('../config/dashboard.php');
	$first_line = $lines[2];
	$lines = array_slice($lines, 1 + 2);
	$lines = array_merge(array($first_line, "\n"), $lines);
	$file = fopen('../config/dashboard.php', 'w');
  	fwrite($file, "<?php\r\n");
  	fwrite($file, "\$installed = true;\r");
	fwrite($file, implode('', $lines));
  	fclose($file);
  	header('Location: ../dashboard');
} else header('Location: ../dashboard');
?>