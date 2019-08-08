<?php
class SendMail {
function Send($Email, $Title, $Content) {
require_once "Smtp.class.php";
//Setting
$smtpserver = "";//SMTP Server Address
$smtpserverport =465;//SMTP Server Port
$smtpusermail = "";//EmailAddress
$smtpemailto = $Email;//to
$smtpuser = "";//userName
$smtppass = "";//Password
$mailtitle = $Title;//Mail Title
$mailcontent = $Content;//Mail Content
$mailtype = "HTML";//type
//Send
$smtp = new Smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);
$smtp->debug = false;
$state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
if($state==""){
	return false;
} else {
return true;
}
}
}
?>
