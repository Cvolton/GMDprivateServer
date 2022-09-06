<style>
* {
	background: #36393e;
}
  .error {
	display: flex;
    margin: 15vw 0px 0px 0px;
    padding: 0;
    font-size: 200;
    color: #c0c0c0;
    align-items: center;
    font-weight: 700;
    text-shadow: 0px 0px 10px black;
    justify-content: center;
    cursor: pointer;
}
.errtext {
	display: flex;
    margin: 0;
    font-size: 35px;
    justify-content: center;
	color: #c0c0c0;
    text-shadow: 0px 0px 5px black;
}</style>
<?php
$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
$path =  str_replace('/errors/403/index.php', '', $path);
include $_SERVER['DOCUMENT_ROOT'].''.$path.'/../config/dashboard.php';
if($_COOKIE["lang"] == 'RU') $text = 'Доступ запрещён!'; else $text = 'Forbidden!';
echo '<title>403 | '.$gdps.'</title>
<a href="'.$path.'"><p class="error">403</p></a>
<p class="errtext">'.$text.'</p>';
?>