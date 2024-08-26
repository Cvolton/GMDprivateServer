<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");
require_once "../incl/dashboardLib.php";
require_once "../".$dbPath."incl/lib/connection.php";
if(!isset($_GET)) $_GET = json_decode(file_get_contents('php://input'), true);

$featuredID = $db->prepare("SELECT starFeatured FROM levels ORDER BY starFeatured DESC LIMIT 1");
$featuredID->execute();
$featuredID = $featuredID->fetchColumn();

if (!$featuredID) exit(json_encode(['dashboard' => true, 'success' => false, 'error' => 1, 'message' => 'No featured level found.']));

exit(json_encode(['dashboard' => true, 'success' => true, 'id' => $featuredID]));
?>