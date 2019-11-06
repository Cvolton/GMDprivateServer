<?php
/*
	QUESTS
*/
//NOW SET IN THE QUESTS TABLE IN THE MYSQL DATABASE
/*
	REWARDS
*/
//SMALL CHEST
$chest1minOrbs = 500;
$chest1maxOrbs = 1000;
$chest1minDiamonds = 5;
$chest1maxDiamonds = 10;
$chest1minShards = 1;
$chest1maxShards = 3;
$chest1minKeys = 2;
$chest1maxKeys = 5;
//BIG CHEST
$chest2minOrbs = 5000;
$chest2maxOrbs = 10000;
$chest2minDiamonds = 50;
$chest2maxDiamonds = 500;
$chest2minShards = 10;
$chest2maxShards = 20; // THIS VARIABLE IS NAMED IMPROPERLY, A MORE ACCURATE NAME WOULD BE $chest2minItemID AND $chest2maxItemID, BUT I DON'T WANT TO RENAME THIS FOR COMPATIBILITY REASONS... IF YOU'RE GETTING A BLANK CUBE IN YOUR DAILY CHESTS, YOU SET THIS TOO HIGH
$chest2minKeys = 4;
$chest2maxKeys = 10;
//REWARD TIMES (in seconds)
$chest1wait = 3600;
$chest2wait = 14400;
?>
