<?php
//version 0.1
//thanks for using GDPSS!
$type = $_POST['type']; //used by GDPSS, DON'T edit it
$version = "1.9"; //the version of gd this server is based on (might be 1.9, 2.0 or 2.1, for an all version server, like cvoltongdps, type "all")
$isOnline = "1"; //if the server is offline, change this to "0"
$MOTD = "Powered by PHP!!"; //message of the day, you can type whatever you want (20 char max)
$icon = "icon.png"; //path of the icon, leave blank for an "NA" icon
switch ($type) {
    case "version":
        echo $version;
        break;
    case "isOnline":
        echo $isOnline;
        break;
	case "motd":
        echo $MOTD;
        break;
	case "icon":
        echo $icon;
        break;
    default:
        echo $version."|".$isOnline."|".$MOTD."|".$icon;
        break;
}
?>