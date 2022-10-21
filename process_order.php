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
    require_once("setting.php");
    require_once("process_function.php");
    if (!isset($_GET["first_name"])) {
        header("payment.php");
    }

    $error_msg = "";

    //First name validation
    $first_name = cleanseInput($_POST["first_name"]);
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $first_name)) {
        $error_msg .= "<p class=''>First name must contains only alphabetical characters and in between 1-25 characters length.</p>\n";
    }

    //Last name validation
    $last_name = cleanseInput($_POST["last_name"]);
    if (!preg_match("/^[a-zA-Z]{1,25}$/", $last_name)) {
        $error_msg .= "<p class=''>Last name must contains only alphabetical characters and in between 1-25 characters length.</p>\n";
    }

    //Email validation
    $email = cleanseInput($_POST["email"]);
    if (!preg_match("/\S+@\S+\.\S+/", $email)) {
        $error_msg .= "<p class=''>Your email must be in the format of email_name@service_provider_name.com</p>\n";
    }

    //Street validation
    $street = cleanseInput($_POST["street"]);
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $street)) {
        $error_msg .= "<p class=''>Your street name must contains only alphabetical characters and in between 1-20 characters length.</p>\n";
    }

    //Suburb validation
    $suburb = cleanseInput($_POST["suburb"]);
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $suburb)) {
        $error_msg .= "<p class=''>Your suburb must contains only alphabetical characters and in between 1-20 characters length.</p>\n";
    }

    //State validation
    $state = cleanseInput($_POST["state"]);
    if ($state == "none") {
        $error_msg .= "<p class=''>You must select your state.</p>\n";
    }

    //Postcode validation
    $postcode = cleanseInput($_POST["postcode"]);
    if (!preg_match("/^\d{4}$/", $postcode)) {
        $error_msg .= "<p class=''>Your postcode must be a 4-digit number.</p>\n";
    }

    //Phone number validation
    $phone = cleanseInput($_POST["phone"]);
    if (!preg_match("/^\d{8,12}$/", $phone)) {
        $error_msg .= "<p class=''>Your phone number must contains only numbers and in between 8-12 digits length .</p>\n";
    }

    $preferred_contact = cleanseInput($_POST["contact"]);

    $product = cleanseInput($_POST["product"]);
    if ($product == "0") {
        $error_msg .= "<p class=''>Your must choose a plan .</p>\n";
    } else {
        switch ($product) {
            case "MERCURY Plan":
                $cost = 15;
            case "VENUS Plan":
                $cost = 25;
            case "EARTH Plan":
                $cost = 35;
            case "MARS Plan":
                $cost = 45;
            case "JUPITER Plan":
                $cost = 55;
            case "SATURN Plan":
                $cost = 65;
            case "URANUS Plan":
                $cost = 155;
            case "NEPTUNE Plan":
                $cost = 1000;
        }
    }

    //Enquiry validation
    $comments = cleanseInput($_POST["comments"]);
    if ($comments == "") {
        $error_msg .= "<p class=''>You must select your enquiry.</p>\n";
    }

    //Card type validation
    $card_type = cleanseInput($_POST["card_type"]);            //sanitise input
    if ($cardType == "none") {                                //if state has not been selected
        $error_msg .= "<p class=''>You must select your card type.</p>\n";
    }

    //Card name validation
    $card_name = cleanseInput($_POST["card_name"]);            //sanitise input
    if ($cardName == "") {
        $error_msg .= "<p class=''>You must enter your name on card.</p>\n";
    } else if (!preg_match("/^[a-zA-Z ]{1,40}$/", $cardName)) {
        $error_msg .= "<p class=''>Card name must contains only alphabetical characters and spaces and cannot exceed 40 characters length.</p>\n";
    }

    //Card number validation
    $card_number = cleanseInput($_POST["card_number"]);        //sanitise input
    if ($cardNumber == "") {                                //if state has not been selected
        $error_msg .= "<p class=''>You must enter your card number.</p>\n";
    } else {
        switch ($card_type) {
            case "visa":                                                                                             //post code check for visa type
                if ($cardNumber[0] != "4") {                                                                            //check if first number is 4
                    $error_msg .= "<p class=''>Visa card number must start with 4.</p>\n";
                } else if (!preg_match("/^\d{16}$/", $cardNumber)) {                                                    //check if length is 16 and only contains numbers
                    $error_msg .= "<p class=''>Visa card number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
            case "master":                                                                                             //post code check for mastercard type
                if (!($card_number[0] == "5" && ($cardNumber[1] >= 1 && $cardNumber[1] <= 5))) {                        //check if first 2 numbers are 51->55
                    $error_msg .= "<p class=''>MasterCard must start with digits \"51\" through to \"55\".</p>\n";
                } else if (!preg_match("/^\d{16}$/", $cardNumber)) {                                                    //check if length is 16 and only contains numbers
                    $error_msg .= "<p class=''>MasterCard number must be 16 digits and contains numbers only.</p>\n";
                }
                break;
        }
    }

    //Card expiry date validation
    $card_expiry = cleanseInput($_POST["card_expiry"]);                    //sanitise input
    if ($card_expiry == "") {
        $error_msg .= "<p class=''>Card expiry date cannot be left blank.</p>\n";    //Check if expiry date is left empty
    } else if (!preg_match("/^\d{2}\/\d{2}$/", $cardExpiry)) {        //Check if expiry date is in the right format
        $error_msg .= "<p class=''>Please enter expiry in the format of mm/yy.</p>\n";
    } else {        //Check if the card is expired
        $date = explode("/", $cardExpiry);
        $month = $date[0];
        $year = $date[1];
        $expires = \DateTime::createFromFormat('my', $month . $year);
        $now = new \DateTime();
        if ($expires < $now) {
            $error_msg .= "<p class=''>Card is expired.</p>\n";
        }
    }

    //CVV validation
    $card_cvv = cleanseInput($_POST["card_cvv"]);                    //sanitise input
    if ($card_cvv == "") {
        $error_msg .= "<p class=''>Card CVV cannot be left blank.</p>\n";        //Check if CVV is left empty
    } else if (!preg_match("/^\d{3}$/", $card_cvv)) {
        $error_msg .= "<p class=''>CVV must be a 3-digit number.</p>\n";        //check if CVV is a 3-digit number
    }

    //If the data is incorrect, redirect to fix_order.php
    if ($error_msg != "") {
        session_start();
        $_SESSION["error_msg"] = $error_msg;
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
        $_SESSION["card_type"] = $card_type;
        $_SESSION["card_name"] = $card_name;
        $_SESSION["card_number"] = $card_number;
        $_SESSION["card_expiry"] = $card_expiry;
        $_SESSION["card_cvv"] = $card_cvv;
        header("location:fix_order.php");
        exit();
    }

    $confirm_msg = "";
    $conn = @mysqli_connect($host, $user, $pwd, $sql_db);    //connect to database

    if ($conn) {
        $sql_table = "orders";
        //Create table if doesn't exist
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
        $result = mysqli_query($conn, $create_table);                //execute the query and store the result into result pointer
        if ($result) {
            //Order date
            $order_date = date('Y-m-d H:i:s');

            //Insert order query
            $add_order = "INSERT INTO orders
	        	(first_name, last_name, email, street, suburb, state, postcode, phone, contact, enquiry, features, comment,
                card_type, card_name, card_number, card_expiry, card_CVV, order_cost, order_date, order_status)
	        	VALUES ('$first_name', '$last_name', '$email', '$street', '$suburb', '$state', '$postcode', '$phone', '$preferred_contact', '$product',
	        	'$features', '$comment', '$cardType', '$cardName', '$cardNumber', '$cardExpiry', '$cardCVV', '$cost', '$order_date', 'PENDING');";
            $execute = mysqli_query($conn, $add_order);

            if ($execute) {
                $confirm_msg = "<p class=''>Your order is recorded</p>"
                    . "<table class=''receipt-table'><tr><th>ITEM</th><th>VALUE</th></tr>"
                    . "<tr><th>Order number:</th><td>" . mysqli_insert_id($conn) . "</td></tr>"
                    . "<tr><th>Total cost (GST included) ($)</th><td>$total_cost</td></tr>"
                    . "<tr><th>Order date</th><td>$datetime</td></tr>"
                    . "<tr><th>Order status</th><td>PENDING</td></tr>"
                    . "<tr><th>First name</th><td>$first_name</td></tr>"
                    . "<tr><th>Last name</th><td>$last_name</td></tr>"
                    . "<tr><th>Email</th><td>$email</td></tr>"
                    . "<tr><th>Address</th><td>$street</td></tr>"
                    . "<tr><th>Suburb</th><td>$suburb</td></tr>"
                    . "<tr><th>State</th><td>$state</td></tr>"
                    . "<tr><th>Postcode</th><td>$postcode</td></tr>"
                    . "<tr><th>Phone number</th><td>$phone</td></tr>"
                    . "<tr><th>Contact method</th><td>$preferred_contact</td></tr>"
                    . "<tr><th>Product:</th><td>$product</td></tr>"
                    . "<tr><th>Features chosen</th><td>$features</td></tr>"
                    . "<tr><th>Comment</th><td>$comment</td></tr>"
                    . "</table>";
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
    header("location:receipt.php?message=$confirm_msg");

    ?>
</body>

</html>
