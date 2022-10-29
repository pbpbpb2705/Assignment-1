<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="description" content="Login">
    <meta name="keywords" content="HTML, PHP">
    <meta name="author" content="MOON">
    <title> Login </title>
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
</head>

<body>
    <?php
    include_once("includes/navbar.inc");
    require_once("settings.php");
    require_once("process_function.php");
    session_start();
        echo "<div class='enterform'>"
            . "<form method='post' action='login.php'>"
            . "<h1 class='enterform_title'> Login </h1>"
            . "<p class='enterform_input_name'> <strong> Username </strong> </p>"
            . "<p> <input type='text' class='enterform_input' name='username' placeholder='Username'> </p>"
            . "<p class='enterform_input_name'> <strong> Password </strong> </p>"
            . "<p> <input type='password' class='enterform_input' name='password' placeholder='Password'> </p>"
            . "<p> <input type='submit' class='enterform_submit' name='submit' value='Login'> </p>"
            . "</form>"
            . "<p> Don't have an account yet? <a href='./signup.php'> Register now! </a> </p>"
            . "</div>";
    if (isset($_SESSION["username"])) {
	header('location: manage.php');

    }
    if (isset($_POST["username"])) {

        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$conn) {
            echo "<p> Unable to connect to the database. Please try again later. </p>";
        } else {
            $account_table = "account";

            $create_table_query = "CREATE TABLE IF NOT EXISTS $account_table (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL
                    );";
            $create_table_result = mysqli_query($conn, $create_table_query);
            if (!$create_table_result) {
                echo "<p> Failed to access to table. Please try again later. </p>";
            } else {
                $query = "SELECT * FROM $account_table WHERE username='$username' AND password='$password'";
                $result = mysqli_query($conn, $query);
                if (!$result) {
                    echo "<p> Failed to login. Please try again later. </p>";
                } else {
                    if (mysqli_connect_errno()) {
                        echo "<p> Failed to connect to MySQL </p>" . mysqli_connect_error();
                    }
                    $num_of_rows = mysqli_num_rows($result);

                    if ($num_of_rows > 0) {
                        $_SESSION["username"] = $username;
                        $_SESSION["email"] = mysqli_fetch_assoc($result)["email"];
			header('location: manage.php');
                    } else {
                        echo "<h2> Incorect username or password. $username </h2>
                              <p> Please try again <a href='./login.php'> here </a>. </p>
                            <p> Or create a new account <a href='./signup.php'> here </a>. </p>";
                    }
                }
            }
            mysqli_close($conn);
        }
    }
    include_once("includes/footer.inc");
    ?>
</body>

</html>
