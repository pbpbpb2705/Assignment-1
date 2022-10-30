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
    include_once("includes/navbar.inc");
    ?>
    <section id="section1">
        <h1 id="form-title">Customer Enquiry Form</h1>
        <p id="require"><em><strong>*Please fill in all the answer in the form</strong></em></p>
        <?php
            session_start();
            //Print error message
        	$error_msg = $_SESSION["error_msg"];
            echo $error_msg;
        ?>
        <form id="form" method="post" novalidate action="process_order.php">
            <fieldset id="name">
                <legend><label for="first_name_box">Name</label></legend>
                <div id="first">
                    <input value = "<?php echo $_SESSION["first_name"];?>" type='text' name='first_name' id='first_name_box' required='required' maxlength='25' pattern='[A-Za-z]+'>";
                    <br>
                    <label class='name_label' for='first_name_box'>First</label>;
                </div>
                <div id="last">
                    <input value = "<?php echo $_SESSION["last_name"];?>" type="text" name="last_name" id="last_name_box" required="required" maxlength="25" pattern="[A-Za-z]+">
                    <br>
                    <label class="name_label" for="last_name_box">Last</label>
                </div>
            </fieldset>


            <fieldset id="email_box">
                <legend>
                    <label for="email">Email</label>
                </legend>
                <input value = "<?php echo $_SESSION["email"];?>" type="email" name="email" id="email" required="required">
            </fieldset>

            <br>

            <div>
                <fieldset id="address">
                    <legend>Address</legend>
                    <label for="street">Street Address</label>
                    <input value = "<?php echo $_SESSION["address"];?>" type="text" name="street" id="street" required="required" maxlength="40">
                    <br />
                    <label for="suburb">Suburb/Town</label>
                    <input value = "<?php echo $_SESSION["suburb"];?>" type="text" name="suburb" id="suburb" required="required" maxlength="20">
                    <br />
                    <label for="state">State</label>
                    <select name="state" id="state">
                        <option value="VIC">VIC</option>
                        <option value="NSW">NSW</option>
                        <option value="QLD">QLD</option>
                        <option value="NT">NT</option>
                        <option value="WA">WA</option>
                        <option value="SA">SA</option>
                        <option value="TAS">TAS</option>
                        <option value="ACT">ACT</option>
                    </select>
                    <label for="postcode">Postcode</label>
                    <input value = "<?php echo $_SESSION["postcode"];?>" type="text" name="postcode" id="postcode" maxlength="4" size="10" required="required" pattern="[0-9]+">
                </fieldset>

                <fieldset id="phone_field">
                    <legend><label for="Phone">Phone number</label></legend>
                    <input value="<?php echo $_SESSION["phone"] ?>" name="phone" id="Phone" type="text" maxlength="10" required="required" pattern="[0-9]+" placeholder="e.g 0123456789">
                </fieldset>

                <fieldset id="pref_contact">
                    <legend id="pref_contact_legend">Preferred contact</legend>

                    <label class="choose_contact">Email
                        <input <?php if ($_SESSION["preferred_contact"] == "Email") {echo "checked";}?> required="required" type="radio" name="contact" value="Email">
                        <span class="checkmark"></span>
                    </label>
                    <label class="choose_contact">Post
                        <input <?php if ($_SESSION["preferred_contact"] == "Post") {echo "checked";}?> required="required" type="radio" name="contact" value="Post">
                        <span class="checkmark"></span>
                    </label>
                    <label class="choose_contact">Phone
                        <input <?php if ($_SESSION["preferred_contact"] == "Phone") {echo "checked";}?> required="required" type="radio" name="contact" value="Phone">
                        <span class="checkmark"></span>
                    </label>
                </fieldset>
            </div>

            <br>

            <fieldset id="products">
                <legend><label for="product">Product</label></legend>
                <select name="product" id="product">
                    <option value="0">Choose an option</option>
                    <option <?php if ($_SESSION["product"] == "MERCURY Plan") {echo "selected";}?> value="MERCURY Plan">Mercury</option>
                    <option <?php if ($_SESSION["product"] == "VENUS Plan") {echo "selected";}?> value="VENUS Plan">Venus</option>
                    <option <?php if ($_SESSION["product"] == "EARTH Plan") {echo "selected";}?> value="EARTH Plan">Earth</option>
                    <option <?php if ($_SESSION["product"] == "MARS Plan") {echo "selected";}?> value="MARS Plan">Mars</option>
                    <option <?php if ($_SESSION["product"] == "JUPITER Plan") {echo "selected";}?> value="JUPITER Plan">Jupiter</option>
                    <option <?php if ($_SESSION["product"] == "SATURN Plan") {echo "selected";}?> value="SATURN Plan">Saturn</option>
                    <option <?php if ($_SESSION["product"] == "URANUS Plan") {echo "selected";}?> value="URANUS Plan">Uranus</option>
                    <option <?php if ($_SESSION["product"] == "NEPTUNE Plan") {echo "selected";}?> value="NEPTUNE Plan">Neptune</option>
                </select>
            </fieldset>

            <fieldset id="feature_field">
                <legend>Product feature:</legend>

                <label class="choose_feature">Data
                    <input <?php if (strpos($_SESSION["features"], "Dat") !== false) {echo "checked";} ?> type="checkbox" name="feature-1" value="Data">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Infinite Data
                    <input <?php if (strpos($_SESSION["features"], "Infdat") !== false) {echo "checked";} ?> type="checkbox" name="feature-2" value="Infinite Data">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Unlimited Call&Text
                    <input <?php if (strpos($_SESSION["features"], "Call") !== false) {echo "checked";} ?> type="checkbox" name="feature-3" value="Unlimited Call&Text">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">Data bank
                    <input <?php if (strpos($_SESSION["features"], "Bankdat") !== false) {echo "checked";} ?> type="checkbox" name="feature-4" value="Data bank">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">International talk zone 1
                    <input <?php if (strpos($_SESSION["features"], "Inter1") !== false) {echo "checked";} ?> type="checkbox" name="feature-5" value="International Talk Zone 1">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">International talk zone 2
                    <input <?php if (strpos($_SESSION["features"], "Inter2") !== false) {echo "checked";} ?> type="checkbox" name="feature-6" value="International Talk Zone 2">
                    <span class="checksquare"></span>
                </label>
            </fieldset>

            <fieldset id="comments_field">
                <legend><label for="comments">Comments:</label></legend>
                <textarea value = "<?php echo $_SESSION["comments"];?>" id="comments" name="comments" placeholder="Enter your comments here"></textarea>

            </fieldset>

            <fieldset id="card-details">
                <legend><label for="card-type">Payment details:</label></legend>
                <div id="cardtype">
                <select name="card_type" id="cardtype">
                    <option value="0">Choose an option</option>
                    <option <?php if ($_SESSION["card_type"] == "visa") {echo "selected";}?> value="visa">Visa</option>
                    <option <?php if ($_SESSION["card_type"] == "mastercard") {echo "selected";}?> value="mastercard">Mastercard</option>
                    <option <?php if ($_SESSION["card_type"] == "amex") {echo "selected";}?>value="amex">American Express</option>
                </select>
                </div>
                <div id="cardname">
                    <input value = "<?php echo $_SESSION["card_name"];?>" type="text" name="card_name" id="card-name-box">
                    <br>
                    <label class="name_label" for="card-name-box">Owner's name:</label>
                </div>
                <div id="cardnumber">
                    <input value = "<?php echo $_SESSION["card_number"];?>" type="text" name="card_number" id="card-number-box">
                    <br>
                    <label class="name_label" for="card-number-box">Card number:</label>
                </div>
                <div id="cardexpiry">
                    <input value = "<?php echo $_SESSION["card_expiry"];?>" type="text" name="card_expiry" id="card-expiry-box">
                    <br>
                    <label class="name_label" for="card-expiry-box">Expiry date:</label>
                </div>
                <div id="cardcvv">
                    <input value = "<?php echo $_SESSION["card_cvv"];?>" type="text" name="card_cvv" id="card-cvv-box">
                    <br>
                    <label class="name_label" for="card-cvv-box">Card CVV:</label>
                </div>
            </fieldset>

            <fieldset id="submit">
                <input type="submit" value="Submit">
                <input type="reset" value="Reset">
            </fieldset>

            <br>
        </form>
    </section>
    <?php
    include_once("includes/footer.inc")
    ?>
</body>
