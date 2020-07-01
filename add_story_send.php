<?php
session_start();
//define relevant variables from POST and SESSION arrays
$title = $_POST['title'];
$author = $_POST['author'];
$link = $_POST['link'];
$user=$_SESSION['username'];
//connect to MySQL news database
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
//query to add row to stories table with information from form
$stmt = $mysqli->prepare("insert into stories (title, author, link, story_user) values (?,?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('ssss', $title,$author,$link,$user);
//if execute is successful, return to home
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}

?>