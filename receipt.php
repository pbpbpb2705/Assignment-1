<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="description" content="This is receipt page.">
	<meta name="keywords"    content="HTML, PHP, CSS">
	<meta name="author"      content="Quoc Bao Pham">
	<meta name="viewport"	 content="width=device-width, initial-scale=1">
  <link rel="icon" href="styles/images/logo.png" />
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<title>Receipt</title>
</head>
<body>
	<?php
		include_once("includes/navbar.inc");
		echo "<h2 class='receipt_header'>Receipt</h2>";

		if (!isset($_GET["message"])) {
			header("location:enquire.php");
			exit();
		}
		else {
	//Get information from session
	session_start();
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
	    $comments = $_SESSION["comments"];
	    $cost = $_SESSION["order_cost"];
            $card_type = $_SESSION["card_type"];
            $card_name = $_SESSION["card_name"];
            $card_number = $_SESSION["card_number"];
            $card_expiry = $_SESSION["card_expiry"];
            $card_cvv = $_SESSION["card_cvv"];

	    //Print receipt table
            echo "<p class='receipt-message'>Your order is recorded</p>"
            . "<table class='receipt_ctn'><tr><th class='receipt_th'>ITEM</th><th class='receipt_th'>VALUE</th></tr>"
            . "<tr><th class='receipt_th'>Order status</th><td class='receipt_td'>PENDING</td></tr>"
            . "<tr><th class='receipt_th'>First name</th><td class='receipt_td'>$first_name</td></tr>"
            . "<tr><th class='receipt_th'>Last name</th><td class='receipt_td'>$last_name</td></tr>"
            . "<tr><th class='receipt_th'>Email</th><td class='receipt_td'>$email</td></tr>"
            . "<tr><th class='receipt_th'>Address</th><td class='receipt_td'>$address</td></tr>"
            . "<tr><th class='receipt_th'>Suburb</th><td class='receipt_td'>$suburb</td></tr>"
            . "<tr><th class='receipt_th'>State</th><td class='receipt_td'>$state</td></tr>"
            . "<tr><th class='receipt_th'>Postcode</th><td class='receipt_td'>$postcode</td></tr>"
            . "<tr><th class='receipt_th'>Phone number</th><td class='receipt_td'>$phone</td></tr>"
            . "<tr><th class='receipt_th'>Product:</th><td class='receipt_td'>$product</td></tr>"
            . "<tr><th class='receipt_th'>Contact method</th><td class='receipt_td'>$preferred_contact</td></tr>"

            . "<tr><th class='receipt_th'>Features chosen:</th><td class='receipt_td'>$features</td></tr>"
            . "<tr><th class='receipt_th'>Comments:</th><td class='receipt_td'>$comments</td></tr>"

            . "<tr><th class='receipt_th'>Total cost:</th><td class='receipt_td'>$cost</td></tr>"

            . "<tr><th class='receipt_th'>Card type:</th><td class='receipt_td'>$card_type</td></tr>"
            . "<tr><th class='receipt_th'>Card owner:</th><td class='receipt_td'>$card_name</td></tr>"
            . "<tr><th class='receipt_th'>Card number</th><td class='receipt_td'>$card_number</td></tr>"
            . "<tr><th class='receipt_th'>Card expiry</th><td class='receipt_td'>$card_expiry</td></tr>"
            . "<tr><th class='receipt_th'>Card CVV</th><td class='receipt_td'>$card_cvv</td></tr>"
            . "</table>";
		}

		include_once("includes/footer.inc");
	?>
</body>
</html>
