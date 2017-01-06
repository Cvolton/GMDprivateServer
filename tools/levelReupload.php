<?php
//error_reporting(0);
include "../connection.php";
if($_POST["levelid"]!=0){
$levelid = $_POST["levelid"];
$url = 'http://'.$_POST["server"].'/database/downloadGJLevel20.php';
$data = array('levelID' => $levelid, 'secret' => 'Wmfd2893gb7');

$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
$resultarray = explode(':', $result);
//var_dump($resultarray);
$uploadDate = time();
$query = $db->prepare("INSERT INTO levels (levelName, gameVersion, binaryVersion, userName, levelDesc, levelVersion, levelLength, audioTrack, auto, password, original, twoPlayer, songID, objects, coins, requestedStars, extraString, levelString, levelInfo, secret, uploadDate, starDifficulty, starDemon, starAuto, starStars, starFeatured)
VALUES ('$resultarray[3]','20', '27', 'ORS', '$resultarray[5]', '$resultarray[9]', '$resultarray[35]', '$resultarray[21]', '0', '1337666', '0', '$resultarray[39]', '$resultarray[45]', '0', '$resultarray[49]', '$resultarray[53]', '$resultarray[47]', '$resultarray[7]', '0', '0', '$uploadDate', '$resultarray[15]', '$resultarray[27]', '$resultarray[29]', '$resultarray[31]', '$resultarray[33]')");
$query->execute();
echo "Level reuploaded, ID: " . $db->lastInsertId() . "<br><hr><br>";

var_dump($resultarray);
}else{
	echo '<form action="levelReupload.php" method="post">ID: <input type="text" name="levelid"><br>Server: <input type="text" name="server" value="www.boomlings.com"><br><input type="submit" value="Reupload"></form><br><a href="songReupload.php">pls use the song reupload tool too, danke schon</a>';
}
/*
+;'+;+;;#+###+######''+++#####@#+#########++'
''''+':+#+###+###+##;;'+''+++##@##########+''
'+''':++#####+##+'+#;::;;;+++++@###########;'
'+'+':+#########';'#+;:::;';;'+###########+';
;++++;+########+';;+##+'''::;;;'#@#########+:
'''':++#########';;;'+++'::::;;'+#@#######+#;
'''''######@###+'';;;;::,::::::;+@#########+'
''''+#@#@#####+'';:::::,,,,,::::'#########+';
''':'#@######+;;;;::,,,,,,,,,,:::;+#######;;;
'';:'########;::::,,,,,,,,,,,,::::;+######'';
';;:++######+:,,,,,,,,,,,,,,,:,::::;+##@@#';;
;;;;+######+;,,,:,,,,,,,,,,:::::;;;''#@@@#+;;
;;;:+##@##+;:,::;;';:,,,,,::::;''''''#@@###';
;;;:###@##+::::::;;;;;::,,:;;''';;;;'@#@@##;;
;;;'+#####',:,,,,,::;;:,,::;';:::::;;##@##+;;
;;;'+#####:,,,,,::;;::;::,:';;''''';;###@#;;;
;;;'#####+,,,,''+##++':,..,;+'+++#+';+##@#';;
;;;;+####',,,;:::::;::,,.,,:::::::;;;'###+';;
;;;;####+',,,,,:::::,,,.,.,::::;;;:::;@##+'';
;;;;####+',,..,,,,,,,,,.,,,::;:::::::;####'''
;;;;####+',.....,,,,,:,,,,,,:;::,,,::;##+#:''
;;;;+++##+,......,,,:,:,,,,,:;::::,::;+###;''
;;;;+#####:.......,::,,,,,,,:;:;::::::##+;':'
;;;;+#####;......,::;,,:::::;;;;::::::##+++''
;;;;+###+#'.....,,:;::'+'::;++';:::::;#+;''''
';;;;+###++,...,,:;:,,::,:;''';;::::;;#+;''''
';;;;:+##'',,,,,,:;,.,,,::'';;;;:::;;'#;'';''
';;;;.:;+#',,,,,:;:...,,:;;;:::;::;;;#+''''''
;';;;'+##+;,,,,,:;,..,,.,:,::::;;:;;;#'''''''
'';;;;'',:+,,,,,:;,,,:;;::;;;;;;;;;;;#,''''''
'';;;;;'#+,,,,,,;;:';:,,:;:'';'';;;;+';''''''
''';;;';;:,,,,,,;;#;..,....,:,#':;;;';;''''''
''''';;;;;;;,,,,;;#+;:,.,,,'+#+;:;;#;;;;;;;;;
''''''';;;:;,,,,;:'+;''+'+++++;;;;;';';;;;;;;
'''''';';::,,,,,;::';:;;;';''+:;;;,'''';;;;;;
''''''';;,,',,,,::,:;;:,:;;;:;:;;;';''''';';;
'''''''':,,+,,,,:,,,:;'''':;;;;;;'++;;''''';'
;'''''':,,,+:,,,,,,,:::;;;;;;;;;;##+';';,''';
;;'''#,,,,,+:,,,,,,,,:;;;;'';;;;;###+;';:;;;'
;;;'':.,,,,';,,,,,,,,,:;;;;;;;;;'####;;;;;';;
+++,,,.,.,,:',,,,,,,,,::::;;;;:''###++;;;;;:'
,,,,,,.:..,,',,,,,,.,,:,:::;;:;';+##+';;;;;::
::::,,.:,,,,+,,,:,,.,,,,,:::::;;'+#++;;:;:;::
*/
?>