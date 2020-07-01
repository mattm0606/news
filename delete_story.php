<?php
session_start();
//define relevant variables from POST and SESSION arrays
$story_id=$_POST['story_id'];
//connect to MySQL news database
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
//query to delete row from stories table for specified story id
$stmt = $mysqli->prepare("delete from stories where id = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $story_id);
//if execute is successful, return home
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}
?>