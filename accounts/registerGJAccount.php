<?php
include "../incl/lib/connection.php";
require_once "../incl/lib/exploitPatch.php";
$ep = new exploitPatch();
if($_POST["userName"] != ""){
	//here im getting all the data
	$userName = $ep->remove($_POST["userName"]);
	$password = $ep->remove($_POST["password"]);
	$email = $ep->remove($_POST["email"]);
	$secret = "";
	//checking if name is taken
	$query2 = $db->prepare("SELECT count(*) FROM accounts WHERE userName LIKE :userName");
	$query2->execute([':userName' => $userName]);
	$regusrs = $query2->fetchColumn();
	$emailswhitelist = "aol.com att.net comcast.net facebook.com gmail.com gmx.com googlemail.comgoogle.com hotmail.com hotmail.co.uk mac.com me.com mail.com msn.comlive.com sbcglobal.net verizon.net yahoo.com yahoo.co.ukemail.com fastmail.fm games.com gmx.net hush.com hushmail.com icloud.cominame.com inbox.com lavabit.com love.com outlook.com pobox.com protonmail.comrocketmail.com safe-mail.net wow.com ygm.comymail.com zoho.com yandex.combellsouth.net charter.net cox.net earthlink.net juno.combtinternet.com virginmedia.com blueyonder.co.uk freeserve.co.uk live.co.ukntlworld.com o2.co.uk orange.net sky.com talktalk.co.uk tiscali.co.ukvirgin.net wanadoo.co.uk bt.comsina.com sina.cn qq.com naver.com hanmail.net daum.net nate.com yahoo.co.jp yahoo.co.kr yahoo.co.id yahoo.co.in yahoo.com.sg yahoo.com 163.com 126.com aliyun.com foxmail.comhotmail.fr live.fr laposte.net yahoo.fr wanadoo.fr orange.fr gmx.fr sfr.fr neuf.fr free.frgmx.de hotmail.de live.de online.de t-online.de /* T-Mobile */ web.de yahoo.delibero.it virgilio.it hotmail.it aol.it tiscali.it alice.it live.it yahoo.it email.it tin.it poste.it teletu.itmail.ru rambler.ru yandex.ru ya.ru list.ruhotmail.be live.be skynet.be voo.be tvcablenet.be telenet.behotmail.com.ar live.com.ar yahoo.com.ar fibertel.com.ar speedy.com.ar arnet.com.aryahoo.com.mx live.com.mx hotmail.es hotmail.com.mx prodigy.net.mxyahoo.com.br hotmail.com.br outlook.com.br uol.com.br bol.com.br terra.com.br ig.com.br itelefonica.com.br r7.com zipmail.com.br globo.com globomail.com oi.com.br";
	$emailchecker = explode("@",$email);
	$newemailwork = $emailchecker[1];
	if (strpos($emailswhitelist, $newemailwork) === false) {
    		exit("-6");
	}
	if ($regusrs > 0) {
		echo "-2";
	}else{
		$hashpass = password_hash($password, PASSWORD_DEFAULT);
		$query = $db->prepare("INSERT INTO accounts (userName, password, email, secret, saveData, registerDate, saveKey)
		VALUES (:userName, :password, :email, :secret, '', :time, '')");
		$query->execute([':userName' => $userName, ':password' => $hashpass, ':email' => $email, ':secret' => $secret, ':time' => time()]);
		echo "1";
	}
}
?>
