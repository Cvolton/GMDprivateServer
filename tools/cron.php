<?php
set_time_limit(0);
include "fixcps.php";
ob_flush();
flush();
include "removeBlankLevels.php";
ob_flush();
flush();
include "autoban.php";
file_put_contents("cronlastrun.txt",time());
?>
