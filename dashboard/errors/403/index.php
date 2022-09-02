<?php
session_start();
require "../../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title(403);
$dl->printFooter('../../');
$dl->error('<a href="../"><p class="error">403</p></a><br>
<p class="errtext">'.$dl->getLocalizedString("403").'</p>');
?>