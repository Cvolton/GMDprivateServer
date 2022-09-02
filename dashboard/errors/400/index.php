<?php
session_start();
require "../../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title(400);
$dl->printFooter('../../');
$dl->error('<a href="../"><p class="error">400</p></a><br>
<p class="errtext">'.$dl->getLocalizedString("400").'</p>');
?>