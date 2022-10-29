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
        	$error_msg = $_SESSION["error_msg"];
            echo $error_msg;
        ?>
        <form id="form" method="post" novalidate action="process_order.php">
            <fieldset id="name">
                <legend><label for="first_name_box">Name</label></legend>
                <div id="first">
                    <?php
                    echo "<input type='text' name='first_name' id='first_name_box' required='required' maxlength='25' pattern='[A-Za-z]+'>";
                    echo "<br>
                        <label class='name_label' for='first_name_box'>First</label>";
                    ?>
                </div>
                <div id="last">
                    <input type="text" name="last_name" id="last_name_box" required="required" maxlength="25" pattern="[A-Za-z]+">
                    <br>
                    <label class="name_label" for="last_name_box">Last</label>
                </div>
            </fieldset>


            <fieldset id="email_box">
                <legend>
                    <label for="email">Email</label>
                </legend>
                <input type="email" name="email" id="email" required="required">
            </fieldset>

            <br>

            <div>
                <fieldset id="address">
                    <legend>Address</legend>
                    <label for="street">Street Address</label>
                    <input type="text" name="street" id="street" required="required" maxlength="40">
                    <br />
                    <label for="suburb">Suburb/Town</label>
                    <input type="text" name="suburb" id="suburb" required="required" maxlength="20">
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
                    <input type="text" name="postcode" id="postcode" maxlength="4" size="10" required="required" pattern="[0-9]+">
                </fieldset>

                <fieldset id="phone_field">
                    <legend><label for="Phone">Phone number</label></legend>
                    <input name="phone" id="Phone" type="text" maxlength="10" required="required" pattern="[0-9]+" placeholder="e.g 0123456789">
                </fieldset>

                <fieldset id="pref_contact">
                    <legend id="pref_contact_legend">Preferred contact</legend>

                    <label class="choose_contact">Email
                        <input required="required" type="radio" name="contact" value="Email">
                        <span class="checkmark"></span>
                    </label>
                    <label class="choose_contact">Post
                        <input required="required" type="radio" name="contact" value="Post">
                        <span class="checkmark"></span>
                    </label>
                    <label class="choose_contact">Phone
                        <input required="required" type="radio" name="contact" value="Phone">
                        <span class="checkmark"></span>
                    </label>
                </fieldset>
            </div>

            <br>

            <fieldset id="products">
                <legend><label for="product">Product</label></legend>
                <select name="product" id="product">
                    <option value="0">Choose an option</option>
                    <option value="MERCURY Plan">Mercury</option>
                    <option value="VENUS Plan">Venus</option>
                    <option value="EARTH Plan">Earth</option>
                    <option value="MARS Plan">Mars</option>
                    <option value="JUPITER Plan">Jupiter</option>
                    <option value="SATURN Plan">Saturn</option>
                    <option value="URANUS Plan">Uranus</option>
                    <option value="NEPTUNE Plan">Neptune</option>
                </select>
            </fieldset>

            <fieldset id="feature_field">
                <legend>Product feature:</legend>

                <label class="choose_feature">Data
                    <input type="checkbox" name="feature-1" value="Data">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Infinite Data
                    <input type="checkbox" name="feature-2" value="Infinite Data">
                    <span class="checksquare"></span>
                </label>


                <label class="choose_feature">Unlimited Call&Text
                    <input type="checkbox" name="feature-3" value="Unlimited Call&Text">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">Data bank
                    <input type="checkbox" name="feature-4" value="Data bank">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">International talk zone 1
                    <input type="checkbox" name="feature-5" value="International Talk Zone 1">
                    <span class="checksquare"></span>
                </label>

                <label class="choose_feature">International talk zone 2
                    <input type="checkbox" name="feature-6" value="International Talk Zone 2">
                    <span class="checksquare"></span>
                </label>
            </fieldset>

            <fieldset id="comments_field">
                <legend><label for="comments">Comments:</label></legend>
                <textarea id="comments" name="comments" placeholder="Enter your comments here"></textarea>

            </fieldset>

            <fieldset id="card-details">
                <legend><label for="card-type">Payment details:</label></legend>
                <div id="cardtype">
                <select name="card_type" id="cardtype">
                    <option value="0">Choose an option</option>
                    <option value="visa">Visa</option>
                    <option value="mastercard">Mastercard</option>
                    <option value="amex">American Express</option>
                </select>
                </div>
                <div id="cardname">
                    <input type="text" name="card-name" id="card-name-box">
                    <br>
                    <label class="name_label" for="card-name-box">Owner's name:</label>
                </div>
                <div id="cardnumber">
                    <input type="text" name="card-number" id="card-number-box">
                    <br>
                    <label class="name_label" for="card-number-box">Card number:</label>
                </div>
                <div id="cardexpiry">
                    <input type="text" name="card-expiry" id="card-expiry-box">
                    <br>
                    <label class="name_label" for="card-expiry-box">Expiry date:</label>
                </div>
                <div id="cardcvv">
                    <input type="text" name="card-cvv" id="card-cvv-box">
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
