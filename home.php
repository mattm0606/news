<!DOCTYPE html>
<html lang="en">
    <head>
        <title>News Website</title>
    </head>
    <body>
        <div class="header">
            <h2>News Website</h2>
            <!-- Login and register buttons always visible -->
            <form action="login.html" method="POST">
                <input type="submit" value="Login" id="login"/>
            </form>
            <form action="register.php" method="POST">
                <input type="submit" value="Register" id="register"/>
            </form>
        </div>
        
        <?php
        session_start();
        //Logout, add story, and view posts buttons only availible if user is logged in
        if(isset($_SESSION['username'])) {
            echo "<form action='logout.php' method='POST'>
                <input type='submit' value='Logout' id='logout'/>
                </form>
                <form action='add_story.php' method='POST'>
                <input type='submit' value='Add story' id='addstory'/>
                </form>
                 <form action='your_posts.php' method='POST'>
                <input type='submit' value='View your posts' id='viewposts'/>
                </form>";
        }
            //connect to MySQL news database
            $mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
            if($mysqli->connect_errno) {
                printf("Connection failed: %s\n", $mysqli->connect_error);
                exit;
            }
            //query for story information
            $stmt = $mysqli->prepare("Select title, author, link, id, story_user from stories");
            if(!$stmt) {
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }
            $stmt->execute();
            $result = $stmt->get_result();

            //
            echo "<ul>\n";
        //loop through results of story query
        while($row = $result->fetch_assoc()){
            $story_id = $row['id'];
            //display button to view actual story from URL
            echo '<a href="'.htmlspecialchars($row["link"]).'"><button>View Story</button></a>' ;  
            //display story information
	        printf("\t<strong>%s</strong> By: %s<br> Posted by: %s <br>",
		        htmlspecialchars( $row["title"] ),
                htmlspecialchars( $row["author"]),
                htmlspecialchars( $row["story_user"] ) 
            );
            //if the user is logged in, they can delete their own stories
            if(isset($_SESSION['username']) && $_SESSION['username'] == $row["story_user"]){
                echo '<form action="delete_story.php" method="POST">
                <input type="submit" value="Delete Story"/>
                <input type="hidden" value='.$story_id.' name="story_id"/>
                </form>';
            }
            //query for comment information for each respective story
                $stmt_com = $mysqli->prepare("select comment, username,comment_num from comments join stories on (stories.id=comments.story_id) where story_id=?");
                if(!$stmt_com){
                    printf("Query Prep Failed: %s\n", $mysqli->error);
                    exit;
                }
                $stmt_com->bind_param('s',$row['id']);
                $story_id = $row['id'];
                $stmt_com->execute();
                $result2 = $stmt_com->get_result();
                echo "<ul>\n";
                //loop through results of comment query
                while($row = $result2->fetch_assoc()) {
	                printf("\t<li>%s says: %s</li>\n",
		            htmlspecialchars($row ["username"] ),
                    htmlspecialchars($row ["comment"])
                     );
                     $comment_num = $row['comment_num'];
                     //only the user who posted comment can edit or delete it
                    if(isset($_SESSION['username'])){
                        if($row["username"]==$_SESSION['username']){
                            echo '<form action="edit_comments.php" method="POST">
                                <input type="submit" value="Edit Comment"/>
                                <input type="hidden" value='.$story_id.' name="story_id"/>
                                <input type="hidden" value='.$comment_num.' name="comment_num"/>
                                </form>';
                            echo '<form action="delete_comments.php" method="POST">
                                <input type="submit" value="Delete Comment"/>
                                <input type="hidden" value='.$story_id.' name="story_id"/>
                                <input type="hidden" value='.$comment_num.' name="comment_num"/>
                                </form>';
                        }    
                    }
                
                }
                //logged in users can add comments to stories
                if(isset($_SESSION['username'])){
                    echo '<form action="add_comments.php" method="POST">
                        <label>Add Comment<input type="text" name="new_comment"/></label>
                        <input type="submit" value="Add"/>
                        <input type="hidden" value='.$story_id.' name="story_id"/>
                        </form>';
                }
                echo "</ul>\n<br><br>";
                $stmt_com->close();
            
            }
            echo "</ul>\n";

            $stmt->close(); 

        ?>
        
    </body>
</html>
