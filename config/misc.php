<?php
$orderMapPacksByStars = true; // true = in-game, order map packs by difficulty, false = in-game, order map packs by the date when they were created (newest to oldest)

$sakujes = true; // true = rename everyone to sakujes in the leaderboard on april 1st, false = don't rename everyone to sakujes in the leaderboard on april 1st

$enableCommentLengthLimiter = true; // true = use the 2 settings below to limit the amount of characters a comment can have, false = don't use the 2 settings below and unrestrict comment lengths
$maxCommentLength = 100; // default = 100, 100 characters is the default length for comments in game
$maxAccountCommentLength = 140; // default = 140, 140 characters is the default length for account comments in game

/*
    Minimum and Maximum Game versions

    Set both to 0 to disable
    Only setting one of them to something else than 0 will make this limit work but not the other

    Examples: setting minimum version to 22 and maximum version to 0 won't allow versions below 2.2 but will allow versions above or equal to 2.2
    or setting maximum version to 22 and minimum version to 0 will allow versions below or equel to 2.2 but not above

    Note: setting both to the same value will only allow this specific version
*/
$minGameVersion = 0;
$maxGameVersion = 0;

/* 
    Same thing, but for binary versions, also note:
    2.205 = 41
    2.204 = 40
    2.203 = 39
    2.202 = 38
    2.201 = 37
    2.200 = 36

    ...
*/
$minBinaryVersion = 0;
$maxBinaryVersion = 0;

$showAllLevels = false; // true => Shows all levels like robtop, even if the client can't support it || false => Only shows levels supported by client

$ratedLevelsUpdates = true; // true => allow updates on rated levels || false => dont allow rated levels to be updated, you can put exceptions as IDs in the parameter below
$ratedLevelsUpdatesExceptions = [
    1, // example
    2 // example
];

// New configurations for comment auto-like feature
$commentAutoLike = false; // true = auto-like is enabled, false = auto-like is disabled
$specialCommentLikes = [
    1 => 10, // commentID => multiplier
    2 => 20, // another commentID => multiplier
    // Add more comment IDs and their multipliers as needed
];
?>
