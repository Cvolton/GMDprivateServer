<?php
include "../connection.php";
if($_POST["userName"] != ""){
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"] . "epithewoihewh577667675765768rhtre67hre687cvolton5gw6547h6we7h6wh");
$email = htmlspecialchars($_POST["email"],ENT_QUOTES);
$secret = "";
//checking if name is taken
$query2 = $db->prepare("SELECT * FROM accounts WHERE userName=:userName");
$query2->execute([':userName' => $userName]);
$regusrs = $query2->rowCount();
if ($regusrs > 0) {
echo "-1";
}else{
//creating pass hash
CRYPT_BLOWFISH or die ('-2');
//This string tells crypt to use blowfish for 5 rounds.
$Blowfish_Pre = '$2a$05$';
$Blowfish_End = '$';
// Blowfish accepts these characters for salts.
$Allowed_Chars =
'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789./';
$Chars_Len = 63;
$Salt_Length = 21;
$salt = "";
for($i=0; $i < $Salt_Length; $i++)
{
    $salt .= $Allowed_Chars[mt_rand(0,$Chars_Len)];
}
$bcrypt_salt = $Blowfish_Pre . $salt . $Blowfish_End;
$password = crypt($password, $bcrypt_salt);
//registering
$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, salt, saveData)
VALUES (:userName, :password, :email, :secret, :salt, '')");

$query->execute([':userName' => $userName, ':password' => $password, ':email' => $email, ':secret' => $secret, ':salt' => $salt]);
echo "1";
}
}
?>