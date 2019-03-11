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
	$emailswhitelist = "aol.com att.net comcast.net facebook.com gmail.com gmx.com googlemail.com google.com hotmail.com hotmail.co.uk mac.com me.com mail.com msn.com live.com sbcglobal.net verizon.net yahoo.com yahoo.co.uk email.com fastmail.fm games.com gmx.net hush.com hushmail.com icloud.com iname.com inbox.com lavabit.com love.com outlook.com pobox.com protonmail.com rocketmail.com safe-mail.net wow.com ygm.com ymail.com zoho.com yandex.com bellsouth.net charter.net cox.net earthlink.net juno.com btinternet.com virginmedia.com blueyonder.co.uk freeserve.co.uk live.co.uk ntlworld.com o2.co.uk orange.net sky.com talktalk.co.uk tiscali.co.uk virgin.net wanadoo.co.uk bt.comsina.com sina.cn qq.com naver.com hanmail.net daum.net nate.com yahoo.co.jp yahoo.co.kr yahoo.co.id yahoo.co.in yahoo.com.sg yahoo.com 163.com 126.com aliyun.com foxmail.com hotmail.fr live.fr laposte.net yahoo.fr wanadoo.fr orange.fr gmx.fr sfr.fr neuf.fr free.frgmx.de hotmail.de live.de online.de t-online.de web.de yahoo.delibero.it virgilio.it hotmail.it aol.it tiscali.it alice.it live.it yahoo.it email.it tin.it poste.it teletu.it mail.ru rambler.ru yandex.ru ya.ru list.ru hotmail.be live.be skynet.be voo.be tvcablenet.be telenet.be hotmail.com.ar live.com.ar yahoo.com.ar fibertel.com.ar speedy.com.ar arnet.com.aryahoo.com.mx live.com.mx hotmail.es hotmail.com.mx prodigy.net.mxyahoo.com.br hotmail.com.br outlook.com.br uol.com.br bol.com.br terra.com.br ig.com.br itelefonica.com.br r7.com zipmail.com.br globo.com globomail.com oi.com.br";
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
