<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="This is receipt page.">
	<meta name="keywords"    content="HTML, PHP, CSS">
	<meta name="author"      content="Quoc Bao Pham">
	<meta name="viewport"	 content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<title>Receipt</title>
</head>
<body>
	<?php
		include_once("includes/header.inc");
		include_once("includes/nav.inc");

		echo "<h2 class='receipt_header'>Receipt</h2>";
		if (!isset($_GET["message"])) {
			header("location:enquire.php");
			exit();
		}
		else {
            $first_name = $_SESSION['first_name'];


            $last_name = $_SESSION["last_name"];
            $email = $_SESSION["email"];
            $address = $_SESSION["address"];
            $suburb = $_SESSION["suburb"];
            $state = $_SESSION["state"];
            $postcode = $_SESSION["postcode"];
            $phone = $_SESSION["phone"];
            $product = $_SESSION["product"];
            $preferred_contact = $_SESSION["preferred_contact"];
            $features = $_SESSION["features"];
            $card_type = $_SESSION["card_type"];
            $card_name = $_SESSION["card_name"];
            $card_number = $_SESSION["card_number"];
            $card_expiry = $_SESSION["card_expiry"];
            $card_cvv = $_SESSION["card_cvv"];

            echo "<p class='error-message'>Your order is recorded</p>"
            . "<table class=''receipt-table'><tr><th>ITEM</th><th>VALUE</th></tr>"
            . "<tr><th>Order number:</th><td>" . mysqli_insert_id($conn) . "</td></tr>"

            . "<tr><th>Order status</th><td>PENDING</td></tr>"
            . "<tr><th>First name</th><td>$first_name</td></tr>"
            . "<tr><th>Last name</th><td>$last_name</td></tr>"
            . "<tr><th>Email</th><td>$email</td></tr>"
            . "<tr><th>Address</th><td>$address</td></tr>"
            . "<tr><th>Suburb</th><td>$suburb</td></tr>"
            . "<tr><th>State</th><td>$state</td></tr>"
            . "<tr><th>Postcode</th><td>$postcode</td></tr>"
            . "<tr><th>Phone number</th><td>$phone</td></tr>"
            . "<tr><th>Product:</th><td>$product</td></tr>"
            . "<tr><th>Contact method</th><td>$preferred_contact</td></tr>"

            . "<tr><th>Features chosen:</th><td>$features</td></tr>"

            . "<tr><th>Card type:</th><td>$card_type</td></tr>"
            . "<tr><th>Card owner:</th><td>$card_name</td></tr>"
            . "<tr><th>Card number</th><td>$card_number</td></tr>"
            . "<tr><th>Card expiry</th><td>$card_expiry</td></tr>"
            . "<tr><th>Card CVV</th><td>$card_cvv</td></tr>"
            . "</table>";
		}

		include_once("includes/footer.inc");
	?>
</body>
</html>
