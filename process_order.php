<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Quoc Bao Pham" />
    <meta name="topic" content="Process order page" />
    <meta name="keywords" content="HTML, CSS, PHP" />
    <meta name="description" content="This is the process order page" />
    <link rel="icon" href="styles/images/logo.png" />
    <link rel="stylesheet" type="text/css" href="styles/style.css" />
    <title>Enquiry</title>
</head>

<body>
    <?php
    require_once("settings.php");
    require_once("process_function.php");
if(!isset($_SERVER['HTTP_REFERER'])){
	header('location:enquire.php');
	exit;
}
    $error_msg = "";

    //Data cleansing
    $first_name = cleanseInput($_POST["first_name"]);
    $last_name = cleanseInput($_POST["last_name"]);
    $email = cleanseInput($_POST["email"]);
    $address = cleanseInput($_POST["address"]);
    $postcode = cleanseInput($_POST["postcode"]);
    $phone = cleanseInput($_POST["phone"]);
    $preferred_contact = cleanseInput($_POST["contact"]);
    $product = cleanseInput($_POST["product"]);
    $feature_1 = cleanseInput($_POST["feature-1"]);
    $feature_2 = cleanseInput($_POST["feature-2"]);
    $feature_3 = cleanseInput($_POST["feature-3"]);
    $feature_4 = cleanseInput($_POST["feature-4"]);
    $feature_5 = cleanseInput($_POST["feature-5"]);
    $feature_6 = cleanseInput($_POST["feature-6"]);
    $suburb = cleanseInput($_POST["suburb"]);
    $state = cleanseInput($_POST["state"]);
    $comments = cleanseInput($_POST["comments"]);
    $card_type = cleanseInput($_POST["card_type"]);
    $card_name = cleanseInput($_POST["card_name"]);
    $card_number = cleanseInput($_POST["card_number"]);
    $card_expiry = cleanseInput($_POST["card_expiry"]);
    $card_cvv = cleanseInput($_POST["card_cvv"]);

    //Data validating
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $first_name)) {
        $error_msg .= "<p class='error-message'>First name must contains only alphabetical characters and in between 1-25 characters length.</p>\n";
    }
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $last_name)) {
        $error_msg .= "<p class='error-message'>Last name must contains only alphabetical characters and in between 1-25 characters length.</p>\n";
    }
    if (!preg_match("/\S+@\S+\.\S+/", $email)) {
        $error_msg .= "<p class='error-message'>Your email must be in the format of email_name@service_provider_name.com</p>\n";
    }
    if (!preg_match("/^[a-zA-Z0-9 ]{1,40}$/", $address)) {
        $error_msg .= "<p class='error-message'>Your address must contains only alphabetical characters, numbers, spaces and in between 1-40 characters length.</p>\n";
    }
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $suburb)) {
        $error_msg .= "<p class='error-message'>Your suburb must contains only alphabetical characters and in between 1-20 characters length.</p>\n";
    }
    if ($state == "none") {
        $error_msg .= "<p class='error-message'>You must select your state.</p>\n";
    }
    if (!preg_match("/^\d{4}$/", $postcode)) {
        $error_msg .= "<p class='error-message'>Your postcode must be a 4-digit number.</p>\n";
    }
    if (!preg_match("/^\d{8,12}$/", $phone)) {
        $error_msg .= "<p class='error-message'>Your phone number must contains only numbers and in between 8-12 digits length .</p>\n";
    }
    if ($product == "0") {
        $error_msg .= "<p class='error-message'>Your must choose a plan .</p>\n";
    } else {
            if ($product == "MERCURY Plan") {
                $cost = 15;
	    }
            if ($product == "VENUS Plan") {
                $cost = 25;
	    }
            if ($product == "EARTH Plan") {
                $cost = 35;
	    }
            if ($product == "MARS Plan") {
                $cost = 45;
	    }
            if ($product == "JUPITER Plan") {
                $cost = 55;
	    }
            if ($product == "SATURN Plan") {
                $cost = 65;
	    }
            if ($product == "URANUS Plan") {
                $cost = 155;
	    }
            if ($product == "NEPTUNE Plan") {
                $cost = 1000;
	    }
    }
    $features = "";
    if ($feature_1 != "") {
	$features .= "Dat,";
    }
    if ($feature_2 != "") {
	$features .= "Infdat,";
    }

    if ($feature_3 != "") {
	$features .= "Call,";
    }

    if ($feature_4 != "") {
	$features .= "Bankdat,";
    }

    if ($feature_5 != "") {
	$features .= "Inter1,";
    }

    if ($feature_6 != "") {
	$features .= "Inter2";
    }
    if ($features == "") {
	$error_msg .= "<p class='error-message'>You must select enquiry features.</p>\n";
    }
    if ($comments == "") {
        $error_msg .= "<p class='error-message'>You must enter your comments.</p>\n";
    }
    if ($card_type == "none") {                                //if state has not been selected
        $error_msg .= "<p class='error-message'>You must select your card type.</p>\n";
    }
    if ($card_name == "") {
        $error_msg .= "<p class='error-message'>You must enter your name on card.</p>\n";
    } else if (!preg_match("/^[a-zA-Z ]{1,40}$/", $card_name)) {
        $error_msg .= "<p class='error-message'>Card name must contains only alphabetical characters and spaces and cannot exceed 40 characters length.</p>\n";
    }
    if ($card_number == "") {
        $error_msg .= "<p class='error-message'>You must enter your card number.</p>\n";
    } else {
        switch ($card_type) {
            case "visa":
                if ($card_number[0] != "4") {                                                                            //Check if first number is 4
                    $error_msg .= "<p class='error-message'>Visa card number must start with 4.</p>\n";
                } else if (!preg_match("/^\d{16}$/", $card_number)) {                                                    //Check if length is 16 and only contains numbers
                    $error_msg .= "<p class='error-message'>Visa card number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
            case "mastercard":
                if (!($card_number[0] == "5" && ($card_number[1] >= 1 && $card_number[1] <= 5))) {                        //Check if first 2 numbers are 51->55
                    $error_msg .= "<p class='error-message'>MasterCard must start with digits \"51\" through to \"55\".</p>\n";
                } else if (!preg_match("/^\d{16}$/", $card_number)) {                                                    //Check if length is 16 and only contains numbers
                    $error_msg .= "<p class='error-message'>MasterCard number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
            case "amex":
                if (!($card_number[0] == "3" && ($card_number[1] == "4" || $card_number[1] == "7"))) {                    //Check if first 2 numbers are 34 or 37
                    $errMsg .= "<p class='align-center'>American Express must start with \"34\" or \"37\".</p>\n";
                } else if (!preg_match("/^\d{15}$/", $card_number)) {                                                            //Check if length is 15 and only contains numbers
                    $errMsg .= "<p class='align-center'>MasterCard number must be 15 digits and contains numbers only.</p>\n";
                }
                break;
        }
    }
    if ($card_expiry == "") {
        $error_msg .= "<p class='error-message'>Card expiry date cannot be left blank.</p>\n";
    } else if (!preg_match("/^\d{2}\/\d{2}$/", $card_expiry)) {        //Check if expiry date is in the right format
        $error_msg .= "<p class='error-message'>Expiry should be in the format of mm/yy.</p>\n";
    } else {
        $date = explode("/", $card_expiry);
        $month = $date[0];
        $year = $date[1];

        //Check if card is expired or not
        $expires = \DateTime::createFromFormat('my', $month . $year);
        $now = new \DateTime();
        if ($expires < $now) {
            $error_msg .= "<p class='error-message'>Card is expired.</p>\n";
        }
    }
    if ($card_cvv == "") {
        $error_msg .= "<p class='error-message'>Card CVV cannot be left blank.</p>\n";        //Check if CVV is left empty
    } else if (!preg_match("/^\d{3}$/", $card_cvv)) {
        $error_msg .= "<p class='error-message'>CVV must be a 3-digit number.</p>\n";        //check if CVV is a 3-digit number
    }

    //Invalid data case
    if ($error_msg != "") {
        session_start();
        $_SESSION["error_msg"] = $error_msg;
        //Pass message and data to fix order page
        $_SESSION["first_name"] = $first_name;
        $_SESSION["last_name"] = $last_name;
        $_SESSION["email"] = $email;
        $_SESSION["address"] = $address;
        $_SESSION["suburb"] = $suburb;
        $_SESSION["state"] = $state;
        $_SESSION["postcode"] = $postcode;
        $_SESSION["phone"] = $phone;
        $_SESSION["product"] = $product;
        $_SESSION["preferred_contact"] = $preferred_contact;
        $_SESSION["features"] = $features;
        $_SESSION["comments"] = $comments;
        $_SESSION["card_type"] = $card_type;
        $_SESSION["card_name"] = $card_name;
        $_SESSION["card_number"] = $card_number;
        $_SESSION["card_expiry"] = $card_expiry;
        $_SESSION["card_cvv"] = $card_cvv;
        header("location:fix_order.php");
        exit();
    }

    //Valid data case
    $confirm_msg = "";
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);
    if ($conn) {
        $sql_table = "orders";
        //Create table if it doesn't initialized
        $create_table = "CREATE TABLE IF NOT EXISTS $sql_table (
	                            order_id INT AUTO_INCREMENT PRIMARY KEY,
	                            first_name VARCHAR(25) NOT NULL,
	                            last_name VARCHAR(25) NOT NULL,
	                            email VARCHAR(50) NOT NULL,
	                            street VARCHAR(40) NOT NULL,
	                            suburb VARCHAR(20) NOT NULL,
	                            state VARCHAR(3) NOT NULL,
	                            postcode VARCHAR(4) NOT NULL,
	                            phone VARCHAR(15) NOT NULL,
	                            contact VARCHAR(10) NOT NULL,
	                            enquiry VARCHAR(20) NOT NULL,
	                            features VARCHAR(40),
	                            comment VARCHAR(200),
	                            card_type VARCHAR(20) NOT NULL,
	                            card_name VARCHAR(20) NOT NULL,
	                            card_number VARCHAR(20) NOT NULL,
	                            card_expiry VARCHAR(20) NOT NULL,
	                            card_CVV INT NOT NULL,
                                order_cost INT NOT NULL,
	                            order_date DATETIME NOT NULL,
                                order_status VARCHAR(10) NOT NULL
	                            );";
        $result = mysqli_query($conn, $create_table);
        //Execute the query
        if ($result) {
            $order_date = date('Y-m-d H:i:s');
            $add_order = "INSERT INTO orders
	        	(first_name, last_name, email, street, suburb, state, postcode, phone, contact, enquiry, features, comment,
                card_type, card_name, card_number, card_expiry, card_CVV, order_cost, order_date, order_status)
	        	VALUES ('$first_name', '$last_name', '$email', '$address', '$suburb', '$state', '$postcode', '$phone', '$preferred_contact', '$product',
	        	'$features', '$comments', '$card_type', '$card_name', '$card_number', '$card_expiry', '$cardCVV', '$cost', '$order_date', 'PENDING');";
            $execute = mysqli_query($conn, $add_order);

            if ($execute) {
                session_start();
                //Pass information to receipt page
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
                $_SESSION["email"] = $email;
                $_SESSION["address"] = $address;
                $_SESSION["suburb"] = $suburb;
                $_SESSION["state"] = $state;
                $_SESSION["postcode"] = $postcode;
                $_SESSION["phone"] = $phone;
                $_SESSION["product"] = $product;
                $_SESSION["preferred_contact"] = $preferred_contact;
                $_SESSION["features"] = $features;
		$_SESSION["comments"] = $comments;
		$_SESSION["order_cost"] = $cost;
                $_SESSION["card_type"] = $card_type;
                $_SESSION["card_name"] = $card_name;
                $_SESSION["card_number"] = $card_number;
                $_SESSION["card_expiry"] = $card_expiry;
                $_SESSION["card_cvv"] = $card_cvv;
                header("location:receipt.php?message=$confirm_msg");
                exit();
            } else {
                $confirm_msg = "<p>Failed to add order. Please try again later.</p>";
            }
        } else {
            $confirm_msg = "<p>Failed to create table. Please try again later.</p>";
        }
        mysqli_close($conn);
    } else {
        $confirm_msg = "<p>Unable to connect to the database. Please try again later.</p>";
    }
    //Navigate to receipt page
    header("location:receipt.php?message=$confirm_msg");

    ?>
</body>

</html>
