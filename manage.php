<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="description" content="manager.php">
	<meta name="keywords" content="manager.php">
	<meta name="author" content="Nguyen Hung Nguyen">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<title>Manage</title>
</head>

<body>
	<?php
	$page = "managePage";
	include_once("includes/navbar.inc");
	session_start();
	?>
	<h1 class="query_message">Manage</h1>
	<br><br>
	<!-- Sort options -->
	<h2 class="query_message">Search</h2>
	<form method="post" action="manage.php">
		<fieldset>
			<legend>Query for a particular order (leave all blank to display all orders)</legend>
			<p>
				<label for="firstname">Customer's first name:</label>
				<input type="text" name="firstname" id="firstname">
			</p>
			<p>
				<label for="lastname">Customer's last name:</label>
				<input type="text" name="lastname" id="lastname">
			</p>
			<p>
				<label>Query orders for a particular product:</label>
			</p>
			<p>
				<input type="checkbox" id="plan1" name="product[]" value="mercury">
				<label for="plan1">Mercury</label>
			</p>
			<p>
				<input type="checkbox" id="plan2" name="product[]" value="venus">
				<label for="plan2">Venus</label>
			</p>
			<p>
				<input type="checkbox" id="plan3" name="product[]" value="earth">
				<label for="plan3">Earth</label>
			</p>
			<p>
				<input type="checkbox" id="plan4" name="product[]" value="mars">
				<label for="plan4">Mars</label>
			</p>
			<p>
				<input type="checkbox" id="plan5" name="product[]" value="jupiter">
				<label for="plan5">Jupiter</label>
			</p>
			<p>
				<input type="checkbox" id="plan6" name="product[]" value="saturn">
				<label for="plan6">Saturn</label>
			</p>
			<p>
				<input type="checkbox" id="plan7" name="product[]" value="uranus">
				<label for="plan7">Uranus</label>
			</p>
			<p>
				<input type="checkbox" id="plan8" name="product[]" value="neptune">
				<label for="plan8">Neptune</label>
			</p>
			<p>
				<label>Query orders that are pending:</label>
				<span>
					<input type="radio" id="pending" name="pending" value="yes">
					<label for="pending">Yes</label>
				</span>
				<span>
					<input type="radio" id="nopending" name="pending" value="no" checked>
					<label for="nopending">No</label>
				</span>
			</p>
			<p>
				<label>Query orders sorted by total cost:</label>
				<span>
					<input type="radio" id="sort" name="Arrange" value="yes">
					<label for="sort">Yes</label>
				</span>
				<span>
					<input type="radio" id="unsort" name="Arrange" value="no" checked>
					<label for="unsort">No</label>
				</span>
			</p>
			<p>
				<label for="sortProcess">Sorting outcomes based on other criteria (choose again to reverse order):</label>
				<select name="sortProcess" id="sort">
					<option value="">Select ...</option>
					<option value="order_id">ID</option>
					<option value="order_date">Date</option>
					<option value="order_status">Status</option>
					<option value="first_name">First Name</option>
					<option value="last_name">Last Name</option>
				</select>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Find" name="Finding">
	</form>

	<?php
	require_once("process_function.php");
	//if "Order Search" form was submitted
	if (isset($_POST["Finding"])) {
		$sort = "";
		$proviso = "";
		// If "Sort orders by cost" was chosen
		if ($_POST["Arrange"] == "yes")
			$sort = " ORDER BY order_cost";
		// If "Sort results by other criteria" was chosen
		if (isset($_POST["sortProcess"])) {
			$tag = "";
			//tag is used to arrange products by descending or ascending
			if (!isset($_SESSION["sortTag"])) {		// If tag is not been set, it will be set by ascending automatically
				$tag = "ASC";
				$_SESSION["sortTag"] = $tag;
			} else {
				if ($_SESSION["sortTag"] == "ASC") {		//switch form ascending to ascending
					$tag = "DESC";
					$_SESSION["sortTag"] = $tag;
				} else { 									//switch form descending to ascending
					$tag = "ASC";
					$_SESSION["sortTag"] = $tag;
				}
			}
			if ($_POST["sortProcess"] == "ID") {
				if ($sort != "")
					$sort .= ", id $tag";
				else
					$sort = " ORDER BY order_id $tag";
			}
			if ($_POST["sortProcess"] == "Date") {
				if ($sort != "")
					$sort .= ", date $tag";
				else
					$sort = " ORDER BY order_date $tag";
			}
			if ($_POST["sortProcess"] == "Status") {
				if ($sort != "")
					$sort .= ", status $tag";
				else
					$sort = " ORDER BY order_status $tag";
			}
			if ($_POST["sortProcess"] == "Name") {
				if ($sort != "")
					$sort .= ", firstName $tag";
				else
					$sort = " ORDER BY first_name $tag";
			}
			if ($_POST["sortProcess"] == "Name") {
				if ($sort != "")
					$sort .= ", lastName $tag";
				else
					$sort = " ORDER BY last_name $tag";
			}
		}

		// If search criteria was chosen
		if (isset($_POST["firstname"]) || isset($_POST["lastname"]) || $_POST["pending"] == "yes" || isset($_POST['product'])) {
			$firstname = cleanseInput($_POST["firstname"]);
			$lastname = cleanseInput($_POST["lastname"]);
			$pending = $_POST["pending"];
			require_once('settings.php');		//Acquire connection to database
			$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//connect to database
			if (!$conn) {
				echo "<h2 class='query_message'>Unable to connect to the database.</h2>";
			} else {
				if ($firstname != "") {
					if ($proviso != "")
						$proviso .= " AND ";
					$proviso .= "first_name LIKE '%$firstname%'";
				}
				if ($lastname != "") {
					if ($proviso != "")
						$proviso .= " AND ";
					$proviso .= "last_name LIKE '%$lastname%'";
				}
				if ($pending == "yes") {
					if ($proviso != "")
						$proviso .= " AND ";
					$proviso .= "order_status LIKE 'PENDING'";
				}
				if (isset($_POST['product'])) {
					$productstatus = $_POST["product"];
					$product_index = "";
					if ($proviso != "")
						$proviso .= " AND (";
					else
						$proviso .= " (";
					if (in_array('mercury', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Mercury%'";
						$product_index .= "mercury";
					}
					if (in_array('venus', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Venus%'";
						$product_index .= "venus";
					}
					if (in_array('earth', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Earth%'";
						$product_index .= "earth";
					}
					if (in_array('mars', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Mars%'";
						$product_index .= "mars";
					}
					if (in_array('jupiter', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Jupiter%'";
						$product_index .= "jupiter";
					}
					if (in_array('saturn', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Saturn%'";
						$product_index .= "saturn";
					}
					if (in_array('uranus', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Uranus%'";
						$product_index .= "uranus";
					}
					if (in_array('neptune', $productstatus)) {
						if ($product_index != "")
							$proviso .= " OR ";
						$proviso .= "enquiry LIKE '%Neptune%'";
						$product_index .= "neptune";
					}
					$proviso .= ")";
				}
			}
		}

		$proviso = ($proviso != "") ? " WHERE " . $proviso : $proviso;
		$query = "SELECT * FROM orders" . $proviso . $sort . ";";
		$query_result = mysqli_query($conn, $query);				//execute the query and store the result into result pointer
		if (!$query_result) {
			echo "<h2 class='query_message'>Failed to execute query: ", $query, ".</h2>";
		} else {
			if (mysqli_num_rows($query_result) > 0) {
				echo "<h2 class='query_message'>Search result</h2>";
				echo "<table id='searchResult'>
							<tr>
								<th>Order ID</th>
								<th>Total cost ($)</th>
								<th>Order date</th>
								<th>Order status</th>
								<th>First name</th>
								<th>Last name</th>
								<th>Purchases</th>
							</tr>";
				while ($saving = mysqli_fetch_assoc($query_result)) {
					echo "<tr>
								<td>{$saving['order_id']}</td>
								<td>{$saving['order_cost']}</td>
								<td>{$saving['order_date']}</td>
								<td>{$saving['order_status']}</td>
								<td>{$saving['first_name']}</td>
								<td>{$saving['last_name']}</td>
								<td>{$saving['enquiry']}</td>
							  </tr>";
				}
				echo "</table>";
				mysqli_free_result($query_result);
			} else {
				echo "<h2 class='query_message'>No result matches your search criteria</h2>";
				echo "<p class='query_message'>Your query: $query</p>";
			}
		}
		mysqli_close($conn);
	}
	?>
	<br><br><br>
	<!-- Enable manage to modify orders' status -->
	<h2 class="query_message">Update order's status</h2>
	<form method="post" action="manage.php">
		<fieldset>
			<legend>Update status of an order:</legend>
			<p>
				<label for="ID_update">Order ID:</label>
				<input type="number" name="ID_update" id="ID_update" required="required">
			</p>
			<p>
				<label for="Status">Order status:</label>
				<select name="Status" id="Status" required>
					<option value="">Select Status...</option>
					<option value="PENDING">PENDING</option>
					<option value="FULFILLED">FULFILLED</option>
					<option value="PAID">PAID</option>
					<option value="ARCHIVED">ARCHIVED</option>
				</select>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Update" name="Update">
	</form>

	<?php
	require_once("process_function.php");
	//if update form was submitted
	if (isset($_POST["Update"])) {
		require_once('settings.php');		//Acquire connection to database
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//connect to database
		if (!$conn) {
			echo "<h2 class='query_message'>Unable to connect to the database.</h2>";
		} else {
			$ID = cleanseInput($_POST["ID_update"]);
			$status = $_POST["Status"];
			$query = "SELECT * from orders WHERE order_id='$ID'";
			$query_result = mysqli_query($conn, $query);
			if ($query_result) {
				if (mysqli_num_rows($query_result) > 0) {
					$query = "UPDATE orders SET order_status='$status' WHERE order_id='$ID'";
					$query_result = mysqli_query($conn, $query);		//execute the query and store the result into result pointer
					if (!$query_result) {
						echo "<h2 class='query_message'>Failed to execute query: ", $query, ".</h2>";
					} else {
						echo "<h2 class='query_message'>Order status has been updated.</h2>";
					}
				}
				else {
					echo "<h2 class='query_message'>Can't find order with ID $ID.</h2>";
				}
				mysqli_close($conn);
			}
			else {
				echo "<h2 class='query_message'>Failed to execute query: ", $query, ".</h2>";
			}
		}
	}
	?>
	<br><br><br>
	<!-- Enable manage to delete pending orders -->
	<h2 class="query_message">Delete PENDING order</h2>
	<form method="post" action="manage.php">
		<fieldset>
			<legend>Delete an order (only PENDING orders can be deleted):</legend>
			<p>
				<label for="ID_delete">Order ID:</label>
				<input type="number" name="ID_delete" id="ID_delete" required="required">
			</p>
		</fieldset>
		<input class="button" type="submit" value="Delete" name="Delete">
	</form>

	<?php
	require_once("process_function.php");
	//if delete form was submitted
	if (isset($_POST["Delete"])) {
		require_once('settings.php');		//Acquire connection to database
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//connect to database
		if (!$conn) {
			echo "<h2 class='query_message'>Unable to connect to the database.</h2>";
		} else {
			$ID = cleanseInput($_POST["ID_delete"]);
			$query = "SELECT order_status FROM orders WHERE order_id='$ID'";
			$query_result = mysqli_query($conn, $query);		//execute the query and store the result into result pointer
			if (!$query_result) {
				echo "<h2 class='query_message'>Failed to execute query: ", $query, ".</h2>";
			} else {
				$saving = mysqli_fetch_assoc($query_result);
				if (mysqli_num_rows($query_result) == 0 ) {
					echo "<h2 class='query_message'>Can't find order with ID $ID</h2>";
				}
				else if ($saving["order_status"] != "PENDING") {
					echo "<h2 class='query_message'>Sorry you cannot delete this order, only existed orders or PENDING orders can be deleted.</h2>";
				} else {
					$delete = "DELETE FROM orders WHERE order_id='$ID'";
					$process = mysqli_query($conn, $delete);
					if (!$process) {
						echo "<h2 class='query_message'>Failed to execute query: ", $delete, ".</h2>";
					} else {
						echo "<h2 class='query_message'>The order has been deleted.</h2>";
					}
				}
			}
			mysqli_close($conn);
		}
	}
	?>
	<br><br><br>
	<!-- Enhancement -->
	<h2 class="query_message">Advance Report</h2>
	<form method="post" action="manage.php">
		<fieldset>
			<legend>More advanced manage report:</legend>
			<p>
				<label>Show best selling product: </label>
				<span>
					<input type="radio" id="showBest" name="best" value="yes">
					<label for="showBest">Yes</label>
				</span>
				<span>
					<input type="radio" id="noShowBest" name="best" value="no" checked>
					<label for="noShowBest">No</label>
				</span>
			</p>

			<p>
				<label>Show customer has the highest bill: </label>
				<span>
					<input type="radio" id="showPerson" name="purchase" value="yes">
					<label for="showPerson">Yes</label>
				</span>
				<span>
					<input type="radio" id="noShowPerson" name="purchase" value="no" checked>
					<label for="noShowPerson">No</label>
				</span>
			</p>

			<p>
				<label>Show average profit per transaction: </label>
				<span>
					<input type="radio" id="showAvgProfit" name="average_profit" value="yes">
					<label for="showAvgProfit">Yes</label>
				</span>
				<span>
					<input type="radio" id="noShowAvgProfit" name="average_profit" value="no" checked>
					<label for="noShowAvgProfit">No</label>
				</span>
			</p>

			<p>
				<label>Show number of PENDING | FULFILLED | PAID | ARCHIVED orders: </label>
				<span>
					<input type="radio" id="showStatusNumber" name="order_status_number" value="yes">
					<label for="showStatusNumber">Yes</label>
				</span>
				<span>
					<input type="radio" id="noShowStatusNumber" name="order_status_number" value="no" checked>
					<label for="noShowStatusNumber">No</label>
				</span>
			</p>
		</fieldset>
		<input class="button" type="submit" value="Check" name="Advance">
	</form>

	<?php
	//if enhancement form was submitted
	if (isset($_POST["Advance"])) {
		require_once('settings.php');		//Acquire connection to database
		$conn = @mysqli_connect($host, $user, $pwd, $sql_db);	//connect to database

		if (!$conn) {
			echo "<h2 class='query_message'>Unable to connect to the database.</h2>";
		} else {
			if ($_POST["best"] == "yes" || $_POST["purchase"] == "yes" || $_POST["average_profit"] == "yes" || $_POST["order_status_number"] == "yes") {
				$query = "SELECT * FROM orders";
				$result = mysqli_query($conn, $query);				//execute the query and store the result into result pointer
				if (!$result) {
					echo "<h2 class='query_message'>Failed to execute query: ", $query, ".</h2>";
				} else {
					$mercuryCount = 0;
					$venusCount = 0;
					$earthCount = 0;
					$marsCount = 0;
					$jupiterCount = 0;
					$saturnCount = 0;
					$uranusCount = 0;
					$neptuneCount = 0; //for best selling product
					$customers = array();
					$customerBills = array_fill(0, 100, 0);		//for customer with the highest bill
					$sum = 0;
					$numberOfOrders = 0;
					$pendingCount = 0;
					$fulfilledCount = 0;
					$paidCount = 0;
					$archivedCount = 0;

					while ($record = mysqli_fetch_assoc($result)) {					//fetch all the records
						// if showing best selling product was chosen
						if ($_POST["best"] == "yes") {
							if (strpos($record["enquiry"], "MERCURY Plan") !== false)		//if mercury is selected
								$mercuryCount++;
							if (strpos($record["enquiry"], "VENUS Plan") !== false)			//if venus is selected
								$venusCount++;
							if (strpos($record["enquiry"], "EARTH Plan") !== false)			//if bmw is selected
								$earthCount++;
							if (strpos($record["enquiry"], "MARS Plan") !== false)		//if tesla is selected
								$marsCount++;
							if (strpos($record["enquiry"], "JUPITER Plan") !== false)		//if tesla is selected
								$jupiterCount++;
							if (strpos($record["enquiry"], "SATURN Plan") !== false)		//if tesla is selected
								$saturnCount++;
							if (strpos($record["enquiry"], "URANUS Plan") !== false)		//if tesla is selected
								$uranusCount++;
							if (strpos($record["enquiry"], "NEPTUNE Plan") !== false)		//if tesla is selected
								$neptuneCount++;
						}
						// if showing customer with the highest bill was chosen
						if ($_POST["purchase"] == "yes") {
							if (!in_array($record["last_name"], $customers)) {
								$customers[] = $record["last_name"];		//add customer name into array
							}
							$index = array_search($record["last_name"], $customers);
							$customerBills[$index] += $record["order_cost"];
						}
						// if showing average profit per transaction was chosen
						if ($_POST["average_profit"] == "yes") {
							$numberOfOrders++;
							$sum += $record["order_cost"];
						}
						// if showing average profit per transaction was chosen
						if ($_POST["order_status_number"] == "yes") {
							if ($record["order_status"] == "PENDING")
								$pendingCount++;
							if ($record["order_status"] == "FULFILLED")
								$fulfilledCount++;
							if ($record["order_status"] == "PAID")
								$paidCount++;
							if ($record["order_status"] == "ARCHIVED")
								$archivedCount++;
						}
					}
					echo "<h2 class='query_message'>Advance report result</h2>";
					if ($_POST["best"] == "yes") {
						$max = $mercuryCount;
						$name = "Mercury";
						if ($venusCount > $max) {
							$max = $venusCount;
							$name = "Venus";
						}
						if ($earthCount > $max) {
							$max = $earthCount;
							$name = "Earth";
						}
						if ($marsCount > $max) {
							$max = $marsCount;
							$name = "Mars";
						}
						if ($jupiterCount > $max) {
							$max = $jupiterCount;
							$name = "Jupiter";
						}
						if ($saturnCount > $max) {
							$max = $saturnCount;
							$name = "Saturn";
						}
						if ($uranusCount > $max) {
							$max = $uranusCount;
							$name = "Uranus";
						}
						if ($neptuneCount > $max) {
							$max = $neptuneCount;
							$name = "Neptune";
						}
						echo "<p class='query_message'>Best selling product is: $name, purchased by $max customer(s).</p>";
					}

					if ($_POST["purchase"] == "yes") {
						$max = $customerBills[0];
						$index = 0;
						for ($i = 1; $i < count($customers); $i++) {
							if ($customerBills[$i] > $max) {
								$max = $customerBills[$i];
								$index = $i;
							}
						}
						echo "<p class='query_message'>Customer with the highest bill is: $customers[$index], total amount spent is $max$.</p>";
					}

					if ($_POST["average_profit"] == "yes") {
						$avg = $sum / (float)$numberOfOrders;
						echo "<p class='query_message'>The average profit per transaction is: ", number_format((float) $avg, 3, '.', ''), "$.</p>";
					}

					if ($_POST["order_status_number"] == "yes") {
						echo "<p class='query_message'>The number of each order status:</p>";
						echo "<p class='query_message'>PENDING: $pendingCount order(s)</p>";
						echo "<p class='query_message'>FULFILLED: $fulfilledCount order(s)</p>";
						echo "<p class='query_message'>PAID: $paidCount order(s)</p>";
						echo "<p class='query_message'>ARCHIVED: $archivedCount order(s)</p>";
					}
				}
			}
			mysqli_close($conn);
		}
	}
	?>

	<?php
	include_once("includes/footer.inc");
	?>
</body>

</html>
