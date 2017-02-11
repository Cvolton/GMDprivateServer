<?php
include "fixcps.php";
ob_flush();
flush();
include "removeBlankLevels.php";
ob_flush();
flush();
include "autoban.php";
?>
