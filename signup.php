<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="Signup" >
	<meta name="keywords" content="HTML, PHP" >
    <meta name="author" content="MOON" >
	<title> Sign Up </title>
  <link rel="icon" href="styles/images/logo.png" />
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
    <?php
	include_once("includes/navbar.inc");
	require_once("settings.php");
        if (!isset($_POST["username"]))
        {
    ?>
        <div class="enterform">
            <form method="post" action="./signup.php">
                <h1 class="enterform_title"> Sign Up </h1>
                <p class="enterform_input_name"> <strong> Email </strong> </p>
                <p> <input type="text" class="enterform_input" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="Email address"> </p>
                <p class="enterform_input_name"> <strong> Username </strong> <em> (6-24 lowercase characters) </em> </p>
                <p> <input type="text" class="enterform_input" name="username" pattern="[a-z].{6,24}" placeholder="Username"> </p>
                <p class="enterform_input_name"> <strong> Password </strong> <em> (6-18 characters, must have at least one uppercase, one lowercase letter) </em> </p>
                <p> <input type="password" class="enterform_input" name="password" pattern="(?=.*[a-z])(?=.*[A-Z]).{6,18}" placeholder="Password"> </p>
                <p> <input type="submit" class="enterform_submit" name="submit" value="Register"> </p>
            </form>
            <p> Already have an Account? Login <a href="./login.php"> here </a> </p>
        </div>
    <?php
        }
        else
        {
            $email = trim($_POST["email"]);
            $username = trim($_POST["username"]);
            $password = trim($_POST["password"]);

            $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
            if (!$conn)
            {   echo "<p> Unable to connect to the database. Please try again later. </p>"; }
            else
            {
		//Create table if needed
                $account_table = "account";
                $create_table_query = "CREATE TABLE IF NOT EXISTS $account_table (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL
                    );";
		//Execute query
                $create_table_result = mysqli_query($conn, $create_table_query);
                if (!$create_table_result)
                {   echo "<p> Failed to create the new table. Please try again later. </p>"; }
                else
                {
		    //Add username and password to account table
                    $query = "INSERT into $account_table (username, password, email) VALUES ('$username', '$password', '$email');";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_connect_errno())
                    {   echo "<p> Failed to connect to MySQL </p>" . mysqli_connect_error(); }
                    if ($result)
                    {
			//Successfully signed up
                        echo "<div>
                                <h2> You are registered successfully. </h2> <br>
                                <p> Click here to <a href='./login.php'> Login </a> </p>
                              </div>";
                    }
                    else
                    {
			//Errors occurred
                        echo "<div>
                                <h2> Something is wrong with your registration!! </h2> <br>
                                <p> Click here to <a href='./signup.php'> Signup </a> again. </p>
                              </div>";
                    }
                    mysqli_close($conn);
                }
            }
        }
	include_once("includes/footer.inc");
    ?>
</body>

</html>
