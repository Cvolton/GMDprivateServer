<?php
/*
Anticheat server sided for GDPS's made by Yoanndp
*/
class Anticheat{
    public function check($accountID){
        chdir(dirname(__FILE__));
        require "connection.php";
        $starsLimit = Self::get_total_of_stars();
        $q = $db->prepare("SELECT stars FROM users WHERE extID = :accid");
        $q->execute([":accid" => $accountID]);
        $stars = $q->fetchColumn();

        $coinsLimit = Self::get_total_of_coins();
        $q = $db->prepare("SELECT coins FROM users WHERE extID = :accid");
        $q->execute([":accid" => $accountID]);
        $coins = $q->fetchColumn();

        $userCoinsLimit = Self::get_total_of_usercoins();
        $q = $db->prepare("SELECT userCoins FROM users WHERE extID = :accid");
        $q->execute([":accid" => $accountID]);
        $usercoins = $q->fetchColumn();

        $demonsLimit = Self::get_total_of_demons();
        $q = $db->prepare("SELECT demons FROM users WHERE extID = :accid");
        $q->execute([":accid" => $accountID]);
        $demons = $q->fetchColumn();
        
        return ($stars > $starsLimit) || ($coins > $coinsLimit) || ($usercoins > $userCoinsLimit) || ($demons > $demonsLimit);
    }

    static public function get_total_of_stars(){
        chdir(dirname(__FILE__));
        require "connection.php";
        require "settings.php";

        //local levels stars
        $totalStars = $_s["anticheat"]["stars"]["local"];

        //margin setup in settings
        $totalStars += $_s["anticheat"]["stars"]["margin"];

        //online levels stars
        $q = $db->query("SET @amount := 0");
        $q = $db->query("SELECT @amount := @amount + starStars AS amount FROM levels WHERE starStars > 0 ORDER BY amount DESC LIMIT 1");
        $totalStars += $q->fetchColumn();

        //map packs stars
        $q = $db->query("SET @amount := 0");
        $q = $db->query("SELECT @amount := @amount + stars AS amount FROM mappacks WHERE stars > 0 ORDER BY amount DESC LIMIT 1");
        $totalStars += $q->fetchColumn();

        return $totalStars;        
    }

    static public function get_total_of_coins(){
        chdir(dirname(__FILE__));
        require "connection.php";
        require "settings.php";

        //local coins
        $totalCoins = $_s["anticheat"]["coins"]["local"];

        //margin setup in settings
        $totalCoins += $_s["anticheat"]["coins"]["margin"];

        //map packs coins
        $q = $db->query("SET @amount := 0");
        $q = $db->query("SELECT @amount := @amount + coins AS amount FROM mappacks WHERE stars > 0 ORDER BY amount DESC LIMIT 1");
        $totalCoins += $q->fetchColumn();

        return $totalCoins;
    }

    static public function get_total_of_usercoins(){
        chdir(dirname(__FILE__));
        require "connection.php";
        require "settings.php";

        //margin setup in settings
        $totalUserCoins = $_s["anticheat"]["usercoins"]["margin"];

        //Online levels usercoins
        $q = $db->query("SET @amount := 0");
        $q = $db->query("SELECT @amount := @amount + coins AS amount FROM levels WHERE starCoins = 1 ORDER BY amount DESC LIMIT 1");
        $totalUserCoins += $q->fetchColumn();

        return $totalUserCoins;
    }

    static public function get_total_of_demons(){
        chdir(dirname(__FILE__));
        require "connection.php";
        require "settings.php";

        //local demon
        $totalDemons = $_s["anticheat"]["demons"]["local"];

        //margin
        $totalDemons += $_s["anticheat"]["demons"]["margin"];

        //Online levels demon
        $q = $db->query("SELECT count(levelID) FROM levels WHERE starDemon = 1");
        $totalDemons += $q->fetchColumn();
        
        //Map packs
        $q = $db->query("SELECT count(ID) FROM mappacks WHERE difficulty = 6");
        $totalDemons += $q->fetchColumn();

        return $totalDemons;
    }

    public function ban_by_accountID($accountID){
        chdir(dirname(__FILE__));
        require "connection.php";

        $q = $db->prepare("UPDATE users SET isBanned = 1 WHERE extID = :accountid");
        $q->execute([":accountid" => $accountID]);
    }
}
?>
