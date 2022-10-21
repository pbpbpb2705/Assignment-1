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
			echo $_GET["message"];
		}

		include_once("includes/footer.inc");
	?>
</body>
</html>
