<?php
session_start();
$title = $_POST['title'];
$author = $_POST['author'];
$link = $_POST['link'];
$user=$_SESSION['username'];

$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
$stmt = $mysqli->prepare("insert into stories (title, author, link) values (?,?,?)");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('sss', $title,$author,$link);
if($stmt->execute()) {
    $stmt->close();
    header('Location: home.php');
}

?>