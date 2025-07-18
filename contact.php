<?php
require_once 'includes/db.con.php';
include 'includes/functions.php';

if (isset($_GET['logout'])) {
	session_start();
	$_SESSION =[];
  session_destroy();
  setcookie(session_name(), '', time() -3600, '/'); //Expire the session cookie
  unset($_SESSION['username']);
  header("location: login.php");
  exit();
}

  //SEND MESSAGE
// initializing variables
$conname = "";
$conemail = "";
$conmsg = "";
$errors = array();


if (isset($_POST['msgsend'])) {
// receive all input values from the form
$conname = mysqli_real_escape_string($DBconn, $_POST['Name']);
$conemail = mysqli_real_escape_string($DBconn, $_POST['Email']);
$conmsg = mysqli_real_escape_string($DBconn, $_POST['Message']);

// form validation: ensure that the form is correctly filled ...
// by adding (array_push()) corresponding error unto $errors array
if (empty($conname)) { array_push($errors, "Name is required"); }
if (empty($conemail)) { array_push($errors, "Email is required"); }
if (empty($conmsg)) { array_push($errors, "Message is required"); }

      // Finally, register user if there are no errors in the form
      if (count($errors) == 0) {

          $contactmsgquery = "INSERT INTO contactform (conname, conemail, conmsg) 
          VALUES('$conname', '$conemail', '$conmsg')";
          mysqli_query($DBconn, $contactmsgquery);
          $_SESSION['successInfo'] = "Message Sent Successfully!!!";
          // header('location: contact.php');
          }
          else{
          array_push($errors, "Message Send Failed.");
          }
}
?>
<!DOCTYPE html>
<html lang="en">
<title>Connect | Affiliate Marketing</title>
<meta name="description" content="Best Affiliate Marketing, Best Work From Home, Passive Income, Top, Source Of Income">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/mycss.css">
<link rel="stylesheet" href="css/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<script src="js/new_myjs.js" defer></script>

<!-- Auto sign-outout user if inactive. -->
<script src="includes/sessionTimeout.js"></script>
<style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
</style>
<body class="w3-theme-l5">
    
<?php
    include 'includes/pubnav.php';
?>

<!-- Page Container  -->
<div class="w3-display-container w3-content" style="max-width:1400px; height:100%">

              <div class="w3-row"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br>
                                      <div class="w3-half w3-dark-grey w3-container w3-center" style="height:600px">
                                      <div class="w3-padding-64"><br><br><br>
      <h1>Contact Us @</h1><br>
                                      </div>
                                      
                                        <div class="w3-row">
                                        <div class="w3-col m12">
                                        <p><i class="fa fa-envelope"> </i> <a href="mailto:support@connect.com"> support@connect.com</a></p><br>
                                        <p><i class="fa fa-envelope"> </i> <a href="mailto:customercare@connect.com"> customercare@connect.com</a></p><br>
                                        </div>
                                        </div>
                                    </div>

                                  <div class="w3-half w3-teal w3-container w3-center" style="height:600px">
                                  <div class="w3-padding-64 w3-padding-large"><br><br>
                                    <?php 
                                          echo successInfo();
                                          echo failureInfo();
                                          include ('errors.php'); 
                                    ?>
                                    <p class="w3-opacity">GET IN TOUCH</p>
                                    <form method="POST" class="w3-container w3-card w3-padding-32 w3-white" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                                      <div class="w3-section">
                                        <label>Name</label>
                                        <input class="w3-input" style="width:100%;" type="text" required name="Name">
                                      </div>
                                      <div class="w3-section">
                                        <label>Email</label>
                                        <input class="w3-input" style="width:100%;" type="text" required name="Email">
                                      </div>
                                      <div class="w3-section">
                                        <label>Message</label>
                                        <textarea class="w3-input" style="width:100%;" type="text" required name="Message"></textarea>
                                      </div>
                                      <button type="submit" name="msgsend" id="msgsend" class="w3-button w3-teal w3-center">Send</button>
                                    </form>
                                  </div>
                                </div>
              </div>
</div>

<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"> </button>
<?php
    include 'includes/footer.php';
?>

    </body>
</html>