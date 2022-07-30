<?php
session_start();
require "../../incl/lib/connection.php";
require "../incl/dashboardLib.php";
$dl = new dashboardLib();
require "../../incl/lib/mainLib.php";
error_reporting(0);
$gs = new mainLib();
include "../../incl/lib/connection.php";
if(empty($_POST["author"]) OR empty($_POST["name"])) {
if(isset($_GET["page"]) AND is_numeric($_GET["page"]) AND $_GET["page"] > 0){
	$page = ($_GET["page"] - 1) * 10;
	$actualpage = $_GET["page"];
}else{
	$page = 0;
	$actualpage = 1;
}
$table = '<table class="table table-inverse"><tr><th>#</th><th>'.$dl->getLocalizedString("songIDw").'</th><th>'.$dl->getLocalizedString("songAuthor").'</th><th>'.$dl->getLocalizedString("name").'</th><th>'.$dl->getLocalizedString("size").'</th><th>'.$dl->getLocalizedString("time").'</th></tr>';

$query = $db->prepare("SELECT * FROM songs ORDER BY ID ASC LIMIT 10 OFFSET $page");
$query->execute();
$result = $query->fetchAll();
$x = $page + 1;
foreach($result as &$action){
	$songsid = $action["ID"];
	$time = $dl->convertToDate($action["reuploadTime"]);
	$author = $action["authorName"];
	$name = $action["name"];
	$size = $action["size"];
	$manage = '<td><a class="dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">'.$dl->getLocalizedString("change").'</a>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink"  style="padding:17px 17px 0px 17px; top:0%;">
									 <form class="form__inner" method="post" action="">
										<div class="field" style="display:none"><input type="hidden" name="ID" value="'.$songsid.'"></div>
										<div class="field"><input type="text" name="author" placeholder="'.$author.'"></div>
										<div class="field"><input type="text" name="name" placeholder="'.$name.'"></div>
										<button type="submit" class="btn-song">'.$dl->getLocalizedString("change").'</button>
									</form>
								</div>
							</td>
							<script>
									document.addEventListener("submit", () => {
									let selectData = [];
									let checkboxData;
									let authorSong;
									let nameSong;
									document.querySelectorAll("select > option").forEach(el => {
										selectData.push(el.value);
									});
									checkboxData = document.querySelector("input[type=checkbox]").value;
									authorSong = document.querySelector("input[name=author]").value;
									nameSong = document.querySelector("input[name=name]").value;
									var formData = new FormData();
									formData.append("select_data", selectData);
									formData.append("author", authorSong);
									formData.append("name", nameSong);
									formData.append("checkbox_data", checkboxData);
									var request = new XMLHttpRequest();
									request.open("POST", "/");
									request.send(formData);
								});
								</script>';
						
if($gs->checkPermission($_SESSION["accountID"], "dashboardManageSongs")){
	$table .= "<tr>
						<th scope='row'>".$x."</th>
						<td>".$songsid."</td>
						<td>".$author."</td>
						<td>".$name."</td>
						<td>".$size."</td>
						<td>".$time."</td>
						<td>".$manage."</td>
						</tr>";
	$x++;
} else {
	$table .= "<tr>
						<th scope='row'>".$x."</th>
						<td>".$songsid."</td>
						<td>".$author."</td>
						<td>".$name."</td>
						<td>".$size."</td>
						<td>".$time."</td>
						</tr>";
}

}
$table .= "</table>";
/*
	bottom row
*/
//getting count
$query = $db->prepare("SELECT count(*) FROM songs");
$query->execute();
$packcount = $query->fetchColumn();
$pagecount = ceil($packcount / 10);
$bottomrow = $dl->generateBottomRow($pagecount, $actualpage);
$dl->printPage($table . $bottomrow, true, "browse");
} else {
	header("Location: renameSong.php?ID=".$_POST["ID"]."&author='".$_POST["author"]."'&name='".$_POST["name"]."'");
}
?>