<?php
    //end session and return home
    session_start();
    session_destroy();
    header("Location: home.php");
?>