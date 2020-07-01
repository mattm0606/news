<?php
session_start();
$story_id=$_POST['story_id'];
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
$stmt = $mysqli->prepare("delete from stories where id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $story_id);
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}


?>