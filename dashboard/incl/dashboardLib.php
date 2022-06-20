<?php
class dashboardLib{
	public function printHeader($isSubdirectory = true){
		$this->handleLangStart();
		echo '<!DOCTYPE html>
				<html lang="en">
					<head>
						<meta charset="utf-8">';
		if($isSubdirectory){
			echo '<base href="../">';
		}
		echo '			<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
						<script async src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
						<script async src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
						<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.min.js"></script>
						<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
						<link async rel="stylesheet" href="incl/cvolton.css">
						<link async rel="stylesheet" href="incl/font-awesome-4.7.0/css/font-awesome.min.css">
						<title>[Beta] GDPS Dashboard</title>
						<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
		echo '		</head>
				<body>';
	}
	public function printBoxBody(){
		echo '<div class="container container-box">
					<div class="card">
						<div class="card-block buffer">';
	}
	public function printBox($content, $active = "", $isSubdirectory = true){
		$this->printHeader($isSubdirectory);
		$this->printNavbar($active);
		$this->printBoxBody();
		echo "$content";
		$this->printBoxFooter();
		$this->printFooter();
	}
	public function printBoxFooter(){
		echo '</div></div></div>';
	}
	public function printFooter(){
		echo '</body>
		</html>';
	}
	public function printLoginBox($content){
		$this->printBox("<h1>Login</h1>".$content);
	}
	public function printLoginBoxInvalid(){
		$this->printLoginBox("<p>Invalid username or password. <a href=''>Click here to try again.</a>");
	}
	public function printLoginBoxError($content){
		$this->printLoginBox("<p>An error has occured: $content. <a href=''>Click here to try again.</a>");
	}
	public function printNavbar($active){
		require_once __DIR__."/../../incl/lib/mainLib.php";
		$gs = new mainLib();
		$homeActive = "";
		$accountActive = "";
		$modActive = "";
		$reuploadActive = "";
		$statsActive = "";
		switch($active){
			case "home":
				$homeActive = "active";
				break;
			case "account":
				$accountActive = "active";
				break;
			case "mod":
				$modActive = "active";
				break;
			case "reupload":
				$reuploadActive = "active";
				break;
			case "stats":
				$statsActive = "active";
				break;
		}
		echo '<nav class="navbar navbar-expand-lg navbar-dark menubar">
			<a class="navbar-brand" href="index.php">GDPS</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item '.$homeActive.' ">
						<a class="nav-link" href="index.php">
							<i class="fa fa-home" aria-hidden="true"></i> '.$this->getLocalizedString("homeNavbar").'
						</a>
					</li>';
		$browse = '<li class="nav-item dropdown '.$accountActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-folder-open" aria-hidden="true"></i> '.$this->getLocalizedString("browse").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="#">'.$this->getLocalizedString("accounts").' (N)</a>
							<a class="dropdown-item" href="#">'.$this->getLocalizedString("levels").' (N)</a>
							<a class="dropdown-item" href="stats/modActionsList.php">'.$this->getLocalizedString("modActions").'</a>
							<a class="dropdown-item" href="stats/packTable.php">'.$this->getLocalizedString("packTable").'</a>
							<a class="dropdown-item" href="stats/gauntletTable.php">'.$this->getLocalizedString("gauntletTable").'</a>';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			echo '
					<li class="nav-item dropdown '.$accountActive.' ">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user" aria-hidden="true"></i> '.$this->getLocalizedString("accountManagement").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="../tools/account/changePassword.php">'.$this->getLocalizedString("changePassword").' (T)</a>
							<a class="dropdown-item" href="../tools/account/changeUsername.php">'.$this->getLocalizedString("changeUsername").' (T)</a>
							<a class="dropdown-item" href="account/unlisted.php">'.$this->getLocalizedString("unlistedLevels").'</a>
						</div>
					</li>' . $browse . '<a class="dropdown-item" href="../tools/stats/songList.php">'.$this->getLocalizedString("songs").' (T)</a></div></li>';
			if($gs->checkPermission($_SESSION["accountID"], "dashboardModTools")){
				echo '<li class="nav-item dropdown '.$modActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-wrench" aria-hidden="true"></i> '.$this->getLocalizedString("modTools").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="../tools/leaderboardsBan.php">'.$this->getLocalizedString("leaderboardBan").' (T)</a>
							<a class="dropdown-item" href="../tools/packCreate.php">'.$this->getLocalizedString("packManage").' (T)</a>
						</div>
					</li>';
			}
		}else{
			echo $browse . "</div></li>";
		}
		echo '		<li class="nav-item dropdown '.$reuploadActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-upload" aria-hidden="true"></i> '.$this->getLocalizedString("reuploadSection").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="../tools/levelReupload.php">'.$this->getLocalizedString("levelReupload").' (T) (note: gonna be both gdps to gd and gd to gdps)</a>
							<a class="dropdown-item" href="reupload/songAdd.php">'.$this->getLocalizedString("songAdd").'</a>
						</div>
					</li>
					<li class="nav-item dropdown '.$statsActive.'">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-bar-chart" aria-hidden="true"></i> '.$this->getLocalizedString("statsSection").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="stats/dailyTable.php">'.$this->getLocalizedString("dailyTable").'</a>
							<a class="dropdown-item" href="stats/modActions.php">'.$this->getLocalizedString("modActions").'</a>
							<a class="dropdown-item" href="../tools/stats/top24h.php">'.$this->getLocalizedString("leaderboardTime").' (T)</a>
						</div>
					</li>
				</ul>
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-language" aria-hidden="true"></i> '.$this->getLocalizedString("language").'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="lang/switchLang.php?lang=CS">Česky</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=DE">Deutsch</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=EE">Eesti</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=EN">English</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=EO">Esperanto</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=ES">Español</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=GR">Ελληνικά</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=HR">Hrvatski</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=IT">Italiano</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=PT">Português</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=RU">Русский</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=TH">ภาษาไทย</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=TR">Türkçe</a>
							<a class="dropdown-item" href="lang/switchLang.php?lang=test">translTest</a>
						</div>';
		if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
			$userName = $gs->getAccountName($_SESSION["accountID"]);
			echo'<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle" aria-hidden="true"></i> '.sprintf($this->getLocalizedString("loginHeader"), $userName).'
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<a class="dropdown-item" href="login/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> '.$this->getLocalizedString("logout").'</a>
						</div>
					</li>';
		}else{
			/*echo '<li class="nav-item">
						<a class="nav-link" href="login/login.php"><i class="fa fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'</a>
					</li>';*/
			echo '<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-sign-in" aria-hidden="true"></i> '.$this->getLocalizedString("login").'
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink" style="padding:17px;">
									<form action="login/login.php" method="post">
										<div class="form-group">
											<input type="text" class="form-control login-input" id="usernameField" name="userName" placeholder="Username">
										</div>
										<div class="form-group">
											<input type="password" class="form-control login-input" id="passwordField" name="password" placeholder="Password">
										</div>
										<button type="submit" class="btn btn-primary btn-block">'.$this->getLocalizedString("login").'</button>
									</form>
						</div>';
		}		
		echo'	</ul>
			</div>
		</nav>';
	}
	public function printPage($content, $isSubdirectory = true, $navbar = "home"){
		$dl = new dashboardLib();
		$dl->printHeader($isSubdirectory);
		$dl->printNavbar($navbar);
		echo '<div class="container d-flex flex-column">
				<div class="row fill d-flex justify-content-start content buffer">
					'.$content.'
				</div>
			</div>';
		$dl->printFooter();
	}
	public function handleLangStart(){
		if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
			setcookie("lang", "EN", 2147483647, "/");
		}
	}
	public function getLocalizedString($stringName){
		if(!isset($_COOKIE["lang"]) OR !ctype_alpha($_COOKIE["lang"])){
			$lang = "EN";
		}else{
			$lang = $_COOKIE["lang"];
		}
		$locale = __DIR__ . "/lang/locale".$lang.".php";
		if(file_exists($locale)){
			include $locale;
		}else{
			include __DIR__ . "/lang/localeEN.php";
		}
		if($lang == "TEST"){
			return "lnf:$stringName";
		}
		if(isset($string[$stringName])){
			return $string[$stringName];
		}else{
			return "lnf:$stringName";
		}
	}
	public function convertToDate($timestamp){
		return date("d/m/Y G:i:s", $timestamp);
	}
	public function generateBottomRow($pagecount, $actualpage){
		$pageminus = $actualpage - 1;
		$pageplus = $actualpage + 1;
		$bottomrow = '<div>'.sprintf($this->getLocalizedString("pageInfo"),$actualpage,$pagecount).'</div><div class="btn-group" style="margin-left:auto; margin-right:0;">';
		$bottomrow .= '<a id="first" href="'.strtok($_SERVER["REQUEST_URI"],'?').'?page=1" class="btn btn-outline-secondary"><i class="fa fa-backward" aria-hidden="true"></i> '.$this->getLocalizedString("first").'</a><a id="prev" href="'.strtok($_SERVER["REQUEST_URI"],'?').'?page='. $pageminus .'" class="btn btn-outline-secondary"><i class="fa fa-chevron-left" aria-hidden="true"></i> '.$this->getLocalizedString("previous").'</a>';
		//updated to ".."
		$bottomrow .= '<a class="btn btn-outline-secondary" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">..</a>
			<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink" style="padding:17px;">
				<form action="" method="get">
					<div class="form-group">
						<input type="text" class="form-control" name="page" placeholder="#">';
		foreach($_GET as $key => $param){
			if($key != "page"){
				$bottomrow .= '<input type="hidden" name="'.$key.'" value="'.$param.'">';
			}
		}
		$bottomrow .= '</div>
					<button type="submit" class="btn btn-primary btn-block">'.$this->getLocalizedString("go").'</button>
				</form>
			</div>';
		$bottomrow .= '<a href="'.strtok($_SERVER["REQUEST_URI"],'?').'?page='.$pageplus.'" id="next" class="btn btn-outline-secondary">'.$this->getLocalizedString("next").' <i class="fa fa-chevron-right" aria-hidden="true"></i></a><a id="last" href="'.strtok($_SERVER["REQUEST_URI"],'?').'?page='. $pagecount .'" class="btn btn-outline-secondary">'.$this->getLocalizedString("last").' <i class="fa fa-forward" aria-hidden="true"></i></a>';
		$bottomrow .= "</div><script>
			function disableElement(element){
				if(element){
					element.className += first.className ? ' disabled' : 'disabled';
				}
			}
			var pagecount = $pagecount;
			var actualpage = $actualpage;
			if(actualpage == 1){
				disableElement(document.getElementById('first'));
				disableElement(document.getElementById('prev'));
			}
			if(pagecount == actualpage){
				disableElement(document.getElementById('last'));
				disableElement(document.getElementById('next'));
			}
			</script>";
		return $bottomrow;
	}
	public function generateLineChart($elementID, $name, $data){
		$labels = implode('","', array_keys($data));
		$data = implode(',', $data);
		$chart = "<script>
					var ctx = document.getElementById(\"$elementID\");
					var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: [\"$labels\"],
							datasets: [{
								label: '$name',
								data: [$data],
								backgroundColor: [
									'rgba(255, 99, 132, 0.2)'
								],
								borderColor: [
									'rgba(255,99,132,1)'
								],
							}]
						},
						options: {
							responsive: true,
							maintainAspectRatio: false,
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero:true
									}
								}]
							}
						}
					});
					</script>";
		return $chart;
	}
}
