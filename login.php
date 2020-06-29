<?php
	//gets username from POST array, opens Users.txt
	$user = $_POST["username"];
	$h = fopen("/srv/Users.txt", "r");

	//reads lines of Users.txt to see if inputted username matches
	while(!feof($h)) {
		$line = trim(fgets($h));
		//if inputted name does match, redirect to UserFiles
		if($user == $line) {
			fclose($h);
			$url = "/~matthewmartin/module2group/UserFiles.php?user=" . $user;
			header('location: '.$url);
			exit;
		}
	}
	//if inputted name does not match, error message
	fclose($h);
	echo "invalid username ";
?>