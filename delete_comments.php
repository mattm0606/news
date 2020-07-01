<?php
session_start();
//define relevant variables from POST and SESSION arrays
$comment_num=$_POST['comment_num'];
$story_id=$_POST['story_id'];
$user=$_SESSION['username'];
//connect to MySQL news database
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
//query to delete row from comments table for specified comment number
$stmt = $mysqli->prepare("delete from comments where comment_num = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $comment_num);
//if execute is successful, return to home
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}
?>