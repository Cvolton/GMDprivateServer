<?php
$e = 403;
$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
$path =  str_replace('/errors/'.$e.'/index.php', '', $path);
require $_SERVER['DOCUMENT_ROOT'].''.$path.'/incl/dashboardLib.php';
$dl = new dashboardLib();
$dl->title($e);
echo '<a href="../"><p class="error">'.$e.'</p></a>
<p class="errtext">'.$dl->getLocalizedString($e).'</p>
<p class="hint">'.$dl->getLocalizedString($e.'!').'</p>';
?>
<style>
* {
	background: #36393e;
}
  .error {
	display: flex;
    height: 55%;
    margin: 0;
    padding: 0;
    font-size: 200;
    color: #c0c0c0;
    align-items: flex-end;
    font-weight: 700;
    text-shadow: 0px 0px 10px black;
    justify-content: center;
    cursor: pointer;
}
.errtext {
	display: flex;
	margin-top: -2vh;
    margin-bottom: 1vh;
    font-size: 35px;
    justify-content: center;
	color: #c0c0c0;
    text-shadow: 0px 0px 5px black;
}
.hint {
	display: flex;
    margin: 0;
    text-align: center;
    font-size: 20px;
    justify-content: center;
	color: gray;
    text-shadow: 0px 0px 5px black;
}
</style>