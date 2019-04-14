<?php

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

if (!endsWith($_SERVER[REQUEST_URI], "/"))
{
	header("Location: ".$_SERVER[REQUEST_URI]."/");
	exit();
}

$whitelist = array("incl/jscolor/jscolor.js");

$rd = array("change-password" => "account/changePassword.php",
			"change-username" => "account/changeUsername.php",
			"new-session" => "newSession.php",
			"level-reupload" => "levelReupload.php",
			"level-to-gd" => "levelToGD.php",
			"unlisted-levels" => "stats/myUnlistedLevels.php",
			"map-packs" => "stats/mapPacks.php",
			"reported-levels" => "stats/reportedLevels.php",
			"comments" => "stats/comments.php",
			"song-add" => "songAdd.php",
			"song-list" => "stats/songsList.php",
			"get-user-info" => "stats/getUserInfo.php",
			"star-gains" => "stats/starGains.php",
			"top-24h" => "stats/top24h.php",
			"top-week" => "stats/topWeek.php",
			"no-login" => "stats/noLogIn.php",
			"cron-job" => "cron/cron.php",
			"server-info" => "stats/serverInfo.php",
			"mod-action" => "stats/modActions.php",
			"leaderboard-ban" => "mod/leaderboardsBan.php",
			"leaderboard-unban" => "mod/leaderboardsUnban.php",
            "send-ban" => "mod/sendBan.php",
			"new-map-pack" => "mod/packCreate.php",
			"edit-map-pack" => "mod/editPack.php",
			"manage-comments" => "mod/manageComments.php",
			"set-mod" => "admin/mod.php",
			"set-admin" => "super/admin.php");

$dr = array_flip($rd);

$q = explode('/?', substr(substr($_SERVER['REQUEST_URI'], 18), 0, -1));

if (count($q) > 1)
{
	parse_str($q[1], $_GET);
}

if (in_array($q[0], $whitelist))
{
	var_dump(1);
	include $q[0];
}
else if (empty($q[0]))
{
	include "index.php";
}
else if (array_key_exists($q[0], $rd))
{
	chdir(dirname($rd[$q[0]]));
	include $rd[$q[0]];
}
else if (array_key_exists($q[0], $dr))
{
	header("Location: /gdps/gdapi/tools/".$dr[$q[0]]."/");
}
else
{
	echo "<pre>Error 404</pre>";
	http_response_code(404);
}

?>
