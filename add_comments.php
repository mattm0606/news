<?php
session_start();
$new_comment=$_POST['new_comment'];
$story_id=$_POST['story_id'];
$user=$_SESSION['username'];
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
$stmt = $mysqli->prepare("insert into comments (username, comment, story_id) values (?, ?, ?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('sss', $user, $new_comment, $story_id);

if($stmt->execute()) {
    header('Location: home.php');
    $stmt->close();
}





?>