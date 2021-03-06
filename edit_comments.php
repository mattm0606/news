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
//query to select comment value for specified comment number
$stmt = $mysqli->prepare("select * from comments where comment_num = ?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s', $comment_num);
$stmt->execute();
$result = $stmt->get_result();
//display original on page
while($row = $result->fetch_assoc()) {
    printf("\t<p>Your comment: %s</p>\n",
    htmlspecialchars($row ["comment"] )
     );
}
//form to gather information to change comment
echo '<form action="edit_comments_send.php" method="POST">
    <label>Edit Comment<input type="text" name="edited_comment"/></label>
    <input type="submit" value="Change"/>
    <input type="hidden" value='.$story_id.' name="story_id"/>
    <input type="hidden" value='.$comment_num.' name="comment_num"/>
    </form>';

?>