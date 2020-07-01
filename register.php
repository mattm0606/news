<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register User</title>
</head>
<body>
    <!--gather user information -->
    <form action="register.php" method="POST">
        <input type="text" name="first" placeholder="Firstname"><br>
        <input type="text" name="last" placeholder="Lastname"><br>
        <input type="text" name="email" placeholder="Email address"><br>
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit" name="submit">Register!</button>
    </form>
    <?php
        //connect to MySQL news database
        $mysqli = new mysqli('localhost','wustl_inst','wustl_pass','news');
        if($mysqli->connect_errno) {
            printf("Connection failed: %s\n", $mysqli->connect_error);
            exit;
        }
        //define relevant variables from POST and SESSION arrays
        $first = $_POST['first'];
        $last = $_POST['last'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        //Hash and salt password
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //query to add new user information to users table
        $stmt = $mysqli->prepare("INSERT into users(first_name,last_name,username,email,password) 
            values (?,?,?,?,?)");
        if(!$stmt) {
            printf("Query Prep failed: %s\n", $mysqli->error);
            exit;
        }
        $stmt->bind_param('sssss',$first,$last,$username,$email,$password);
        //if successful, return home
        if ($stmt->execute()) {
            $stmt->close();
            header("Location: home.php");
            exit;
        }
    ?>
</body>