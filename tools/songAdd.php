<?php
//error_reporting(0);
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
require_once "../incl/lib/mainLib.php";
require_once "../incl/lib/Captcha.php";
$gs = new mainLib();
if(!empty($_POST['songlink'])){

	if(!Captcha::validateCaptcha())
		exit("Invalid captcha response");

	$result = $gs->songReupload($_POST['songlink']);
	if($result == "-4"){
		echo "This URL doesn't point to a valid audio file.";
	}elseif($result == "-3")
		echo "This song already exists in our database.";
	elseif($result == "-2")
		echo "The download link isn't a valid URL";
	else
		echo "Song reuploaded: <b>${result}</b><hr>";

}else{
	echo '<b>Direct links</b> or <b>Dropbox links</b> only accepted, <b><font size="5">NO YOUTUBE LINKS</font></b><br>
		<form action="songAdd.php" method="post">
		Link: <input type="text" name="songlink"><br>';
	Captcha::displayCaptcha();
	echo '<input type="submit" value="Add Song"></form>';
}
?>