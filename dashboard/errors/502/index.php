<?php
session_start();
require "../../incl/dashboardLib.php";
$dl = new dashboardLib();
$dl->title(502);
$dl->printFooter('../../');
$dl->error('<a href="../"><p class="error">502</p></a><br>
<p class="errtext">'.$dl->getLocalizedString("502").'</p>');
?>