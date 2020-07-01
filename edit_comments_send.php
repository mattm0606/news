<?php
session_start();
$comment_num=$_POST['comment_num'];
$story_id=$_POST['story_id'];
$user=$_SESSION['username'];
$edited = $_POST['edited_comment'];
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}

$stmt = $mysqli->prepare("update comments set comment=? where comment_num=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ss', $edited, $comment_num);
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}


?>