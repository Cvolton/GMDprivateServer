<?php
error_reporting(0);
include "connection.php";
$query = $db->prepare("SELECT * FROM mappacks");
$query->execute();
$page = $_POST["page"];
$lvlpage = $page*10;
$result = $query->fetchAll();
$mappack1 = $result[$lvlpage];
if($mappack1["ID"]!=""){
echo "1:".$mappack1["ID"].":2:".$mappack1["name"].":3:".$mappack1["levels"].":4:".$mappack1["stars"].":5:".$mappack1["coins"].":6:".$mappack1["difficulty"].":7:".$mappack1["rgbcolors"].":8:".$mappack1["rgbcolors"];
}
$mappack2 = $result[$lvlpage+1];
if($mappack2["ID"]!=""){
echo "|1:".$mappack2["ID"].":2:".$mappack2["name"].":3:".$mappack2["levels"].":4:".$mappack2["stars"].":5:".$mappack2["coins"].":6:".$mappack2["difficulty"].":7:".$mappack2["rgbcolors"].":8:".$mappack2["rgbcolors"];
}
$mappack3 = $result[$lvlpage+2];
if($mappack3["ID"]!=""){
echo "|1:".$mappack3["ID"].":2:".$mappack3["name"].":3:".$mappack3["levels"].":4:".$mappack3["stars"].":5:".$mappack3["coins"].":6:".$mappack3["difficulty"].":7:".$mappack3["rgbcolors"].":8:".$mappack3["rgbcolors"];
}
$mappack4 = $result[$lvlpage+3];
if($mappack4["ID"]!=""){
echo "|1:".$mappack4["ID"].":2:".$mappack4["name"].":3:".$mappack4["levels"].":4:".$mappack4["stars"].":5:".$mappack4["coins"].":6:".$mappack4["difficulty"].":7:".$mappack4["rgbcolors"].":8:".$mappack4["rgbcolors"];
}
$mappack5 = $result[$lvlpage+4];
if($mappack5["ID"]!=""){
echo "|1:".$mappack5["ID"].":2:".$mappack5["name"].":3:".$mappack5["levels"].":4:".$mappack5["stars"].":5:".$mappack5["coins"].":6:".$mappack5["difficulty"].":7:".$mappack5["rgbcolors"].":8:".$mappack5["rgbcolors"];
}
$mappack6 = $result[$lvlpage+5];
if($mappack6["ID"]!=""){
echo "|1:".$mappack6["ID"].":2:".$mappack6["name"].":3:".$mappack6["levels"].":4:".$mappack6["stars"].":5:".$mappack6["coins"].":6:".$mappack6["difficulty"].":7:".$mappack6["rgbcolors"].":8:".$mappack6["rgbcolors"];
}
$mappack7 = $result[$lvlpage+6];
if($mappack7["ID"]!=""){
echo "|1:".$mappack7["ID"].":2:".$mappack7["name"].":3:".$mappack7["levels"].":4:".$mappack7["stars"].":5:".$mappack7["coins"].":6:".$mappack7["difficulty"].":7:".$mappack7["rgbcolors"].":8:".$mappack7["rgbcolors"];
}
$mappack8 = $result[$lvlpage+7];
if($mappack8["ID"]!=""){
echo "|1:".$mappack8["ID"].":2:".$mappack8["name"].":3:".$mappack8["levels"].":4:".$mappack8["stars"].":5:".$mappack8["coins"].":6:".$mappack8["difficulty"].":7:".$mappack8["rgbcolors"].":8:".$mappack8["rgbcolors"];
}
$mappack9 = $result[$lvlpage+8];
if($mappack9["ID"]!=""){
echo "|1:".$mappack9["ID"].":2:".$mappack9["name"].":3:".$mappack9["levels"].":4:".$mappack9["stars"].":5:".$mappack9["coins"].":6:".$mappack9["difficulty"].":7:".$mappack9["rgbcolors"].":8:".$mappack9["rgbcolors"];
}
$mappack10 = $result[$lvlpage+9];
if($mappack10["ID"]!=""){
echo "|1:".$mappack10["ID"].":2:".$mappack10["name"].":3:".$mappack10["levels"].":4:".$mappack10["stars"].":5:".$mappack10["coins"].":6:".$mappack10["difficulty"].":7:".$mappack10["rgbcolors"].":8:".$mappack10["rgbcolors"];
}
echo "#9999:".$lvlpage.":10";
?>