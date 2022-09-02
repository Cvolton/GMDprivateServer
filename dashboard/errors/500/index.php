<?php
session_start();
require "../../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title(500);
$dl->printFooter('../../');
$dl->error('<a href="../"><p class="error">500</p></a><br>
<p class="errtext">'.$dl->getLocalizedString("500").'</p>');
?>