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
$path =  str_replace('/errors/500/index.php', '', $path);
include $_SERVER['DOCUMENT_ROOT'].''.$path.'/../config/dashboard.php';
if($_COOKIE["lang"] == 'RU') $text = 'Внутренняя ошибка сервера!'; else $text = 'Internal server error!';
echo '<title>500 | '.$gdps.'</title>
<a href="'.$path.'"><p class="error">500</p></a>
<p class="errtext">'.$text.'</p>';
?>