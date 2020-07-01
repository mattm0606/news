<?php
session_start();
echo '<form action="add_story_send.php" method="POST">
    <label>ADD STORY </label>
    <input type="text" name="title" placeholder="Title"/>
    <input type="text" name="author" placeholder="Author"/>
    <input type="text" name="link" placeholder="URL"/>
    <input type="submit" value="Post"/>
    </form>';

?>