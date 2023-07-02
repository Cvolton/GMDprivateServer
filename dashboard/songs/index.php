<?php
session_start();
require "../incl/dashboardLib.php";
require "../".$dbPath."incl/lib/Captcha.php";
include "../".$dbPath."incl/lib/connection.php";
require_once "../".$dbPath."incl/lib/exploitPatch.php";
$dl = new dashboardLib();
$dl->title($dl->getLocalizedString("songAdd"));
$dl->printFooter('../');
if(strpos($songEnabled, '1') === false) {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="">
		<p>'.$dl->getLocalizedString("pageDisabled").'</p>
		<button type="button" onclick="a(\'\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
		</form>
	</div>', 'reupload');
	die();
}
if(isset($_SESSION["accountID"]) AND $_SESSION["accountID"] != 0){
if($_FILES && $_FILES['filename']['error'] == UPLOAD_ERR_OK) {
	if(!Captcha::validateCaptcha()) {
		$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("invalidCaptcha").'</p>
			<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-song">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
		</div>', 'reupload');
		die();
	} else {
		$file_type = $_FILES['filename']['type'];
		$allowed = array("audio/mpeg", "audio/ogg", "audio/mp3");
		if(!in_array($file_type, $allowed)) {
			$db_fid = -7;
		} else {
			$maxsize = $songSize * 1024 * 1024;
			if($_FILES['filename']['size'] >= $maxsize) {
				$db_fid = -5;
			} else {
				$length = 10;
				$db_fid = rand(2, 999999);
				move_uploaded_file($_FILES['filename']['tmp_name'], "$db_fid.mp3");
				$size = ($_FILES['filename']['size'] / 1048576);
				$size = round($size, 2);
				$hash = "";
				$types = array('.mp3', '.ogg', '.mpeg');
				$nAu = explode(' - ', str_replace($types, '', $_FILES['filename']['name']));
				if(empty($nAu[1])) $nAu = explode(' — ', str_replace($types, '', $_FILES['filename']['name']));
				if(!empty($nAu[1])) {
					if(!empty($_POST['name'])) $name = ExploitPatch::remove($_POST['name']);
					else $name = trim(ExploitPatch::remove($nAu[1]));
					if(!empty($_POST['author'])) $author = ExploitPatch::remove($_POST['author']);
					else $author = trim(ExploitPatch::remove($nAu[0]));
				} else {
					$name = ExploitPatch::remove($_POST['name']);
					$author = ExploitPatch::remove($_POST['author']);
				}
				if(empty($name)) $name = "Unnamed";
				if(empty($author)) $author = "Reupload";
				$servername = $_SERVER['SERVER_NAME'];
				$accountID = $_SESSION["accountID"];
				$path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['SCRIPT_FILENAME']);
				$path =  str_replace('index.php', '', $path);
				$song = "https://".$servername."".$path."".$db_fid.".mp3";
				$query = $db->prepare("INSERT INTO songs (ID, name, authorID, authorName, size, download, hash, reuploadTime, reuploadID) VALUES (:id, :name, '9', :author, :size, :download, :hash, :reuploadTime, :reuploadID)");
				$query->execute([':id' => $db_fid, ':name' => $name, ':download' => $song, ':author' => $author, ':size' => $size, ':hash' => $hash, ':reuploadTime' => time(), ':reuploadID' => $accountID]);
			} 
		}
		if($db_fid < 0) {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
			<form class="form__inner" method="post" action="">
				<p>'.$dl->getLocalizedString("songAddError$db_fid").'</p>
				<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("tryAgainBTN").'</button>
			</form>
			</div>', 'reupload');
		} else {
			$dl->printSong('<div class="form">
			<h1>'.$dl->getLocalizedString("songAdded").'</h1>
			<form class="form__inner" method="post" action="">
			<p>'.$dl->getLocalizedString("songID").'<b style="font-size: inherit;" class="accbtn songidyeah" id="copy'.$db_fid.'" onclick="copysong('.$db_fid.')">'.$db_fid.'</b></p>
			<button type="button" onclick="a(\'songs\', true, false, \'GET\')" class="btn-primary">'.$dl->getLocalizedString("songAddAnotherBTN").'</button>
			</form><script>
			function copysong(id) {
				navigator.clipboard.writeText(id);
				document.getElementById("copy"+id).style.transition = "0.05s";
				document.getElementById("copy"+id).style.color = "#bbffbb";
				setTimeout(function(){document.getElementById("copy"+id).style.transition = "0.2s";}, 1)
				setTimeout(function(){document.getElementById("copy"+id).style.color = "#007bff";}, 200)
			}
			</script>', 'reupload');
		}
	}
} else {
	$dl->printSong('<div class="draganddrop" id="dad" style="opacity: 0; visibility: hidden;"><div class="form dadform" style="background: #29282c;"><h1 class="dadh1"><i class="fa-solid fa-file-import"></i>Drag-and-drop!</h1></div></div>
	<div class="form">
    <h1>'.$dl->getLocalizedString("songAdd").'</h1>
    <form class="form__inner" method="post" action="" enctype="multipart/form-data">
		<p>'.$dl->getLocalizedString("songAddDesc").'</p>
        <div style="width:100%;text-align:center">
          <label for="upload" id="labelupload" class="btn-upload-song">
          	 <i style="margin:0;font-size: 17" class="fa-solid fa-music icon"></i> 
              <input id="upload" type="file" name="filename" size="10" accept="audio/mpeg, audio/ogg, audio/mp3">
                  <text style="font-size: 21">
                    <span id="songnamelol">
                        '.$dl->getLocalizedString("chooseFile").'
                    </span>
                  </text>
             <i style="margin:0;font-size: 17" class="fa-solid fa-music icon fa-flip-horizontal"></i>
		  </label>
		  <progress id="progress" style="display: none"></progress>
        </div>
        <div class="field"><input type="text" name="author" placeholder="'.$dl->getLocalizedString("songAddAuthorFieldPlaceholder").'"></div>
        <div class="field"><input type="text" name="name" placeholder="'.$dl->getLocalizedString("songAddNameFieldPlaceholder").'"></div>', 'reupload');
Captcha::displayCaptcha();
echo '<button type="button" onclick="a(\'songs\', true, false, \'POST\');" style="margin-top:5px;margin-bottom:5px" type="submit" id="submit" class="btn-song btn-block" disabled>'.$dl->getLocalizedString("reuploadBTN").'</button></form>
		<script>
			dad = document.getElementById("dad");
			document.getElementsByTagName("body")[0].ondragover = function(e) {
				dad.style.opacity = "1";
				dad.style.visibility = "initial";
				e.stopPropagation();
				e.preventDefault();
				return false;
			};
			document.getElementsByTagName("body")[0].ondragleave = function(e) {
				dad.style.opacity = "0";
				dad.style.visibility = "hidden";
				e.stopPropagation();
				e.preventDefault();
				return false;
			};
			document.getElementsByTagName("body")[0].ondrop = function(e) {
				changeSong(e);
				dad.style.opacity = "0";
				dad.style.visibility = "hidden";
				e.stopPropagation();
				e.preventDefault();
				return false;
			}
			$(".btn-upload-song input[type=file]").on("change", function(e) {changeSong(e);});
			function changeSong(fl) {
				if(typeof fl.target.files != "undefined") file = fl.target.files[0];
				else {
					document.getElementById("upload").files = fl.dataTransfer.files;
					file = fl.dataTransfer.files[0];
				}
				sn = document.getElementById("songnamelol");
				const upload = document.getElementById("labelupload");
				const btn = document.getElementById("submit");
				if(file.size > '.$songSize * 1024 * 1024 .') {
					sn.innerHTML = "'.$dl->getLocalizedString("songAddError-5").'";
					upload.classList.add("btn-size");
					btn.disabled = true;
					btn.classList.add("btn-block");
					btn.classList.remove("btn-song");
				}
				else if(file.type != "audio/mpeg" && file.type != "audio/ogg" && file.type != "audio/mp3") {
					sn.innerHTML = "'.$dl->getLocalizedString("songAddError-7").'";
					upload.classList.add("btn-size");
					btn.disabled = true;
					btn.classList.add("btn-block");
					btn.classList.remove("btn-song");
				} 
				else {
					sn.innerHTML = file.name.split(".").slice(0, -1).join(".");
					upload.classList.remove("btn-size");
					btn.removeAttribute("disabled");
					btn.classList.remove("btn-block");
					btn.classList.add("btn-song");
				}
				return false;
			}
		</script>';
}
} else {
	$dl->printSong('<div class="form">
		<h1>'.$dl->getLocalizedString("errorGeneric").'</h1>
		<form class="form__inner" method="post" action="./login/login.php">
		<p>'.$dl->getLocalizedString("noLogin?").'</p>
		<button type="button" onclick="a(\'login/login.php\');" class="btn-song">'.$dl->getLocalizedString("LoginBtn").'</button>
		</form>
	</div>', 'reupload');
}
?>