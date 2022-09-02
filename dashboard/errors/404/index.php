<?php
session_start();
require "../../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title(404);
$dl->printFooter('../../');
$dl->error('<a href="../"><p class="error">404</p></a><br>
<p class="errtext">'.$dl->getLocalizedString("404").'</p>');
?>