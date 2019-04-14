<?php

if ($_SERVER['QUERY_STRING'] == "demonList")
{
	header("Location: https://gdpslist.weebly.com/demons-list.html");
}
else if ($_SERVER['QUERY_STRING'] == "tools")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/");
}
else if ($_SERVER['QUERY_STRING'] == "changeUsername")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/change-username");
}
else if ($_SERVER['QUERY_STRING'] == "changePassword")
{
	header("Location: https://nettik.co.uk/gdps/database/tools/change-password");
}
else
{
	http_response_code(500);
}

?>