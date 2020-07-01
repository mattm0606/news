<?php
session_start();
//display username
$user=$_SESSION['username'];
echo "Hello " . $user . "! <br><br>";

//submit form to return home
echo "<form action='home.php'>
<input type='submit' value='Return home'/>
</form>";

//display user's posted stories
echo "Your posted stories:";
$mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
if($mysqli->connect_errno) {
    printf("Connection failed: %s\n", $mysqli->connect_error);
    exit;
}
//query to selecct titles of stories posted by specified user
$stmt = $mysqli->prepare("Select title from stories where story_user=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $user);
$stmt->execute();
$result = $stmt->get_result();
echo "<ul>\n";
//display titles of stories
while($row = $result->fetch_assoc()){
    printf("\t%s<br>",
    htmlspecialchars( $row["title"] )
    );
}
echo "</ul>\n";
$stmt->close();

//display user's comments
echo "<br><br>Your comments:";
//query to select all comments from the specified user
$stmt2 = $mysqli->prepare("select comment from comments where username=?");
if(!$stmt2){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt2->bind_param('s', $user);
$stmt2->execute();
$result2 = $stmt2->get_result();
echo "<ul>\n";
//display comments
while($row = $result2->fetch_assoc()){
    printf("\t%s<br>",
    htmlspecialchars( $row["comment"] )
    );
}
echo "</ul>\n";
$stmt2->close();
?>