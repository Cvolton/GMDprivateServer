<?php
ini_set('display_errors', 0);
error_reporting(NULL);
chdir(dirname(__FILE__));
if(function_exists("set_time_limit")) set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
include "autoban.php";
ob_flush();
flush();
include "friendsLeaderboard.php";
ob_flush();
flush();
include "removeBlankLevels.php";
ob_flush();
flush();
include "songsCount.php";
ob_flush();
flush();
include "fixnames.php";
ob_flush();
flush();
include "demonlistPoints.php";
ob_flush();
flush();
echo "1";
file_put_contents("../logs/cronlastrun.txt",time());
?>
