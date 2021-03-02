<?php
$topArtistsRedirectsMainGD = 0; // Indicates if the response from the main GD servers are redirected, 0 for no and 1 for yes.

/* If it does not redirect, based on how many songs an artists has on the songs index of the server, artists get higher on the top song makers.
Note: This excludes "Reupload" account.
*/

$soundcloudAPIKey = "dc467dd431fc48eb0244b0aead929ccd";

$timestampType = 0; // Indicates how timestamps are given to the game and bots; 0 = Sends timestamps with the following format: "{Number} {Highest time the timestamp is divisible by} ago", 1 = Send timestamps as dates.
?>