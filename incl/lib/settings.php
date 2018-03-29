<?php
$margin = 1000;
$local_stars = 187; // From Stereo Madness to Fingerdash
$local_coins = 64; //64 = (21 levels * 3 coins) + 1 (from the menu)
$local_demons = 3; // Clubstep, ToE II and Deadlocked

$_s = array(
    "anticheat" => array(
        "stars" => array(
            "margin" => $margin,
            "local" => $local_stars
        ),

        "coins" => array(
            "margin" => $margin,
            "local" => $local_coins 
        ),

        "usercoins" => array(
            "margin" => $margin
        ),

        "demons" => array(
            "margin" => $margin,
            "local" => $local_demons
        )
    )
);

?>
