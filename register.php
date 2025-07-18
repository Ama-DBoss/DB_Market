<?php
require_once 'includes/db.con.php';
include 'includes/functions.php';

// Initializing variables
$userErr = $lastErr = $firstErr = $middleErr = $emailErr = $genderErr = $dobErr = $countryErr = $ccErr = $phoneErr = $pwdErr = $con_pwdErr = $addressErr = $refby = "";
$last = $first = $middle = $user = $email = $gender = $dob = $country = $cc = $phone = $pwd = $con_pwd = $address = $refby = "";
$errors = array();

// Connect to the database
$DBconn = mysqli_connect('localhost', 'root', '', 'crdb');

// Function to calculate age from date of birth
function calculate_age($dob) {
    $dob = new DateTime($dob);
    $today = new DateTime();
    $age = $dob->diff($today)->y;
    return $age;
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
<script type="text/javascript" src="jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="jquery.pwdMeter.js"></script>
<script src="js/new_myjs.js" defer></script>
<style>
  .veryweak{
    color:#B40404;
  }

  .weak{
    color:#DF7401;
  }

  .medium{
    color:#FFFF00;
  }

  .strong{
    color:#9AFE2E;
  }

  .verystrong{
    color:#0B610B;
  }

  body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
	.bgimg {
  background-image: url('images/forestbridge.jpg');
  min-height: 100%;
  background-position: center;
  background-size: cover;
}
    </style>
</head>
<body class="w3-theme-l5">

<?php
  include 'includes/pubnav.php';
  ?>

<div id="id01" class="bgimg w3-display-container w3-animate-opacity w3-text-white w3-animate-zoom">

    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:900px">
   
    <br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small"><br class="w3-hide-small">

      <?php 
          include ("errors.php");
          echo successInfo();
          echo failureInfo();
      ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="w3-container w3-text-black" method="POST" enctype="multipart/form-data">
      <?php include('errors.php'); ?>
      <h2 class="w3-center">Create An Account<br>
      <label class=" w3-center w3-text-red" style="font-size:14px"> ** <i style="font-size:14px">marked fields are required to successfully 
	  register.<br>persons under the age of 18years are not permitted to register.</i></label><br>
      </h2>

      <div class="w3-row-padding">
        <div class="w3-col m6">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Username</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="user" id="user" type="text" placeholder="User Name" required>
          </div>
      </div>
      </div>

      <div class="w3-col m6">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Email</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-envelope-o"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="email" id="email" type="text" placeholder="Email" required>
          </div>
      </div>
      </div>
      </div>
      <div class="w3-row-padding">
        <div class="w3-col m4">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Lastname</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="last" id="last" type="text" placeholder="Last Name" required>
          </div>
      </div>
      </div>
      
      <div class="w3-col m4">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Firstname</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="first" id="first" type="text" placeholder="First Name" required>
          </div>
      </div>
      </div>

      <div class="w3-col m4">
      <div class="w3-row w3-section">
          <label class="w3-center"><b>Middle name</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-user"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="middle" id="middle" type="text" placeholder="Middle Name">
          </div>
      </div>
      </div>
      </div>

      <div class="w3-row-padding">
        <div class="w3-col m6">
          <div class="w3-row w3-section">
            <label class="w3-center"><b><i class="w3-text-red">* </i>Gender</b></label>
          <div class="w3-col" style="width:50px"><i class="w3-large fa fa-male fa fa-female"> | </i><i class="w3-large fa fa-female"></i></div>
            <div class="w3-rest">
              <select class="w3-select w3-center w3-border w3-white w3-round-xxlarge" name="gender" id="gender" type="text" required>
                <option value="" disabled selected>Choose...</option>
                <option value="FEMALE">FEMALE</option>
                <option value="MALE">MALE</option>
            </select>
            </div>
          </div>
        </div>
        
          <!-- Date of Birth (DOB) input field -->
          <div class="w3-col m6">
              <div class="w3-row w3-section">
                  <label class="w3-center"><b><i class="w3-text-red">* </i>DOB</b></label>
                  <div class="w3-col" style="width:50px"><i class="w3-large fa fa-calendar"></i></div>
                  <div class="w3-rest">
                      <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="dob" id="dob" type="date" placeholder="DOB DD/MM/YY" required>
                  </div>
              </div>
          </div>

<!-- Error message for underage users -->
<div id="ageError" class="w3-text-red" style="display: none;">You must be at least 18 years old to register.</div>

<script>
    // Add an event listener for the form submission
    document.querySelector("form").addEventListener("submit", function(event) {
        var dobInput = document.getElementById("dob");
        var dob = new Date(dobInput.value); // Get the selected DOB
        var today = new Date(); // Current date

        // Calculate the user's age
        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();

        // Adjust age if the birthday hasn't occurred yet this year
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        // Check if the user is under 18 years old
        if (age < 18) {
            // Show error message and prevent form submission
            document.getElementById("ageError").style.display = "block";
            event.preventDefault(); // Prevent form submission
        } else {
            // Hide error message if age is 18 or older
            document.getElementById("ageError").style.display = "none";
        }
    });
</script>

      </div>

	  <div class="w3-row-padding">
        <div class="w3-col m3">
      <div class="w3-row w3-section">
		<label for="country" class="w3-center"><b><i class="w3-text-red">* </i>Select Country</b></label>
				<div class="w3-col" style="width:50px"><i class="w3-large fa fa-flag"></i></div>
					<div class="w3-rest">
		<select class="w3-select w3-center w3-border w3-white w3-round-xxlarge" name="country" type="text" required id="country"></select>
		</div>
		</div>
          </div>
		  
        <div class="w3-col m3">
      <div class="w3-row w3-section">
<label for="countryCode" class="w3-center"><b><i class="w3-text-red">* </i>Country Code</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-flag"></i></div>
            <div class="w3-rest">
<select class="w3-select w3-center w3-border w3-white w3-round-xxlarge" name="countryCode" type="text" required id="countryCode"></select>
</div>
</div>
          </div>

      <div class="w3-col m6">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>WhatsApp / Phone Number <small>(Active on whatsapp)</small></b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-mobile"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="phone" id="phone" type="text" placeholder="Phone number without country/dialing code" required>
          </div>
      </div>
</div>
</div>

      <div class="w3-row-padding">
        <div class="w3-col m6">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Password</b><span class="w3-right"><i class="w3-large fa fa-eye-slash" onclick="mypwdFunction()"></i></span></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-lock"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border  w3-white w3-round-xxlarge" name="pwd" id="pwd" type="password" placeholder="Password" required>
          </div>
      </div>
</div>

      <div class="w3-col m6">
      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Confirm Password</b><span class="w3-right"><i class="w3-large fa fa-eye-slash" onclick="myconpwdFunction()"></i></span></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-lock"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="con_pwd" id="con_pwd" type="password" placeholder="Confirm Password" required>
          </div>
      </div>
</div>
<span id="pwdMeter" class="neutral w3-left"></span><br>
<span id="pwdMatch" class="neutral w3-left"></span>
<label id="message" style="display:none"></label>
</div>

      <div class="w3-row w3-section">
          <label class="w3-center"><b><i class="w3-text-red">* </i>Address</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-map"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="address" id="address" type="text" placeholder="Address" required>
          </div>
      </div>

      <div class="w3-row w3-section">
          <label class="w3-center"><b>Referred By (Optional)</b></label>
        <div class="w3-col" style="width:50px"><i class="w3-large fa fa-fog"></i></div>
          <div class="w3-rest">
            <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="refby" id="refby" type="text" placeholder="Referers ID (123456)">
          </div>
      </div>

      <p class="w3-center w3-text-blue">
        * By clicking "SIGN UP" below, you agree to OUR <a href="tnc.php" class="w3-text-red"><b>T&C's</b></a> / <a href="tnc.php#pp" class="w3-text-red"><b>Privacy Policy</b></a>.<br>
      <button class="w3-button w3-section w3-green w3-round-xxlarge w3-large w3-ripple" id="register" name="register"><i class="w3-large fa fa-pencil"> Sign Up</i></button>
      </p>
      </form>
      <p class="w3-center">
      <button onclick="document.getElementById('id03').style.display='block'" class="w3-button w3-section w3-green w3-round-xxlarge w3-large w3-ripple" id="waregister" name="waregister"><i class="w3-large fa fa-pencil"> Sign Up</i></button>
	  </p>

      <p class="w3-center">
        <span class="w3-padding w3-text-blue ">Already a member? <a href="login.php">LOGIN</a></span>
      </p><br>
    </div>
	<br>
  </div>
  
  <?php
	
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = mysqli_real_escape_string($DBconn, $_POST['user']);
    $email = mysqli_real_escape_string($DBconn, $_POST['email']);
    $lastname = mysqli_real_escape_string($DBconn, $_POST['last']);
    $firstname = mysqli_real_escape_string($DBconn, $_POST['first']);
    $gender = mysqli_real_escape_string($DBconn, $_POST['gender']);
    $dob = mysqli_real_escape_string($DBconn, $_POST['dob']);
    $country = mysqli_real_escape_string($DBconn, $_POST['country']);
    $phone = mysqli_real_escape_string($DBconn, $_POST['phone']);
    $password = mysqli_real_escape_string($DBconn, $_POST['pwd']);
    $confirm_password = mysqli_real_escape_string($DBconn, $_POST['con_pwd']);

    // Ensure passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match. Please try again.');</script>";
        exit;
    }

    // Generate a hashed password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate a random 6-digit verification code
    $verification_code = rand(100000, 999999);
    $_SESSION['verification_code'] = $verification_code;
    $_SESSION['phone'] = $phone;
    $_SESSION['email'] = $email;
    $_SESSION['user_data'] = [
        'username' => $username,
        'email' => $email,
        'lastname' => $lastname,
        'firstname' => $firstname,
        'gender' => $gender,
        'dob' => $dob,
        'country' => $country,
        'phone' => $phone,
        'password' => $hashed_password,
    ];

// Send verification code via WhatsApp
    $whatsapp_link = "https://wa.me/$phone?text=" . urlencode(
        "Hello, Your phone number was used to create an account on https://www.connect.com\n" .
        "Please provide this code: $verification_code to activate your account.\n" .
        "Code expires in 5 minutes."
    );

    echo "<script>window.open('$whatsapp_link', '_blank');</script>";
    echo "<script>document.getElementById('id03').style.display='block';</script>";
}
?>

<!-- WhatsApp Verification Modal -->
<div id="id03" class="w3-modal">
    <div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">
        <span onclick="document.getElementById('id03').style.display='none'" class="w3-button w3-xxxlarge w3-transparent w3-display-topright" title="Close Modal">×</span>
        <div class="w3-container">
            <h4 class="w3-wide w3-center">Confirm WhatsApp/Phone Number</h4>
            <hr style="border: 1px solid">
            <p class="w3-center">We have sent a 6-digit code to your WhatsApp. Please enter it below:</p>

            <form action="verify.php" method="POST">
                <input class="w3-input w3-center w3-border w3-white w3-round-xxlarge" name="verification_code" id="verification_code" type="text" placeholder="Enter Code" required><br>
                <button class="w3-button w3-green w3-round-xxlarge w3-large w3-ripple" type="submit" name="verify_code">Verify</button>
            </form>
        </div>
    </div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top" class="fa fa-arrow-up" style="border-radius: 50%"> </button>
<!-- Footer -->
<?php
  include 'includes/footer.php';
  ?>

<script>
    // JavaScript for toggling password visibility
    function mypwdFunction() {
        var x = document.getElementById("pwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    function myconpwdFunction() {
        var x = document.getElementById("con_pwd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }

    // Password strength indicator (updated version)
    document.getElementById("pwd").addEventListener("input", function() {
        var password = document.getElementById("pwd").value;
        var meter = document.getElementById("pwdMeter");

        // Regular expressions for password strength
        var strongPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+={}\[\]|\\:;,.<>?/-]).{10,}$/;
        var mediumPattern = /^(?=.*[a-zA-Z])(?=.*\d).{8,}$/;

        // Check password strength
        if (strongPattern.test(password)) {
            meter.className = "strong";
            meter.textContent = "Strong Password Strength";
        } else if (mediumPattern.test(password)) {
            meter.className = "medium";
            meter.textContent = "Medium Password Strength";
        } else {
            meter.className = "weak";
            meter.textContent = "Weak Password Strength";
        }

        // Check password match
        checkPasswordMatch();
    });

    // Password match indicator (also called when confirm password field changes)
    document.getElementById("con_pwd").addEventListener("input", checkPasswordMatch);

    // Function to check password match
    function checkPasswordMatch() {
        var mpassword = document.getElementById("pwd").value;
        var cpassword = document.getElementById("con_pwd").value;
        var match = document.getElementById("pwdMatch");

        if (mpassword === cpassword && cpassword !== "") {
            match.className = "PasswordMatch";
            match.textContent = "Passwords Match";
        } else {
            match.className = "PasswordDoNotMatch";
            match.textContent = "Passwords Do Not Match";
        }
    }
</script>


<style>
  .PasswordMatch {
    color: green;
}

.PasswordDoNotMatch {
    color: red;
}

.weak {
    color: red;
}

.medium {
    color: orange;
}

.strong {
    color: green;
}
</style>

	  
  <script>
const countries = [
//{ name: "Select Country", code: "SL", dialCode: "Select Code" },
{ name: "Afghanistan", code: "AF", dialCode: "+93" },
{ name: "Albania", code: "AL", dialCode: "+355" },
{ name: "Algeria", code: "DZ", dialCode: "+213" },
{ name: "Andorra", code: "AD", dialCode: "+376" },
{ name: "Angola", code: "AO", dialCode: "+244" },
{ name: "Antigua and Barbuda", code: "AG", dialCode: "+1-268" },
{ name: "Argentina", code: "AR", dialCode: "+54" },
{ name: "Armenia", code: "AM", dialCode: "+374" },
{ name: "Australia", code: "AU", dialCode: "+61" },
{ name: "Austria", code: "AT", dialCode: "+43" },
{ name: "Azerbaijan", code: "AZ", dialCode: "+994" },
{ name: "Bahamas", code: "BS", dialCode: "+1-242" },
{ name: "Bahrain", code: "BH", dialCode: "+973" },
{ name: "Bangladesh", code: "BD", dialCode: "+880" },
{ name: "Barbados", code: "BB", dialCode: "+1-246" },
{ name: "Belarus", code: "BY", dialCode: "+375" },
{ name: "Belgium", code: "BE", dialCode: "+32" },
{ name: "Belize", code: "BZ", dialCode: "+501" },
{ name: "Benin", code: "BJ", dialCode: "+229" },
{ name: "Bhutan", code: "BT", dialCode: "+975" },
{ name: "Bolivia", code: "BO", dialCode: "+591" },
{ name: "Bosnia and Herzegovina", code: "BA", dialCode: "+387" },
{ name: "Botswana", code: "BW", dialCode: "+267" },
{ name: "Brazil", code: "BR", dialCode: "+55" },
{ name: "Brunei", code: "BN", dialCode: "+673" },
{ name: "Bulgaria", code: "BG", dialCode: "+359" },
{ name: "Burkina Faso", code: "BF", dialCode: "+226" },
{ name: "Burundi", code: "BI", dialCode: "+257" },
{ name: "Cabo Verde", code: "CV", dialCode: "+238" },
{ name: "Cambodia", code: "KH", dialCode: "+855" },
{ name: "Cameroon", code: "CM", dialCode: "+237" },
{ name: "Canada", code: "CA", dialCode: "+1" },
{ name: "Central African Republic", code: "CF", dialCode: "+236" },
{ name: "Chad", code: "TD", dialCode: "+235" },
{ name: "Chile", code: "CL", dialCode: "+56" },
{ name: "China", code: "CN", dialCode: "+86" },
{ name: "Colombia", code: "CO", dialCode: "+57" },
{ name: "Comoros", code: "KM", dialCode: "+269" },
{ name: "Congo (Congo-Brazzaville)", code: "CG", dialCode: "+242" },
{ name: "Congo (DRC)", code: "CD", dialCode: "+243" },
{ name: "Costa Rica", code: "CR", dialCode: "+506" },
{ name: "Croatia", code: "HR", dialCode: "+385" },
{ name: "Cuba", code: "CU", dialCode: "+53" },
{ name: "Cyprus", code: "CY", dialCode: "+357" },
{ name: "Czechia", code: "CZ", dialCode: "+420" },
{ name: "Denmark", code: "DK", dialCode: "+45" },
{ name: "Djibouti", code: "DJ", dialCode: "+253" },
{ name: "Dominica", code: "DM", dialCode: "+1-767" },
{ name: "Dominican Republic", code: "DO", dialCode: "+1-809" },
{ name: "Ecuador", code: "EC", dialCode: "+593" },
{ name: "Egypt", code: "EG", dialCode: "+20" },
{ name: "El Salvador", code: "SV", dialCode: "+503" },
{ name: "Equatorial Guinea", code: "GQ", dialCode: "+240" },
{ name: "Eritrea", code: "ER", dialCode: "+291" },
{ name: "Estonia", code: "EE", dialCode: "+372" },
{ name: "Eswatini", code: "SZ", dialCode: "+268" },
{ name: "Ethiopia", code: "ET", dialCode: "+251" },
{ name: "Fiji", code: "FJ", dialCode: "+679" },
{ name: "Finland", code: "FI", dialCode: "+358" },
{ name: "France", code: "FR", dialCode: "+33" },
{ name: "Gabon", code: "GA", dialCode: "+241" },
{ name: "Gambia", code: "GM", dialCode: "+220" },
{ name: "Georgia", code: "GE", dialCode: "+995" },
{ name: "Germany", code: "DE", dialCode: "+49" },
{ name: "Ghana", code: "GH", dialCode: "+233" },
{ name: "Greece", code: "GR", dialCode: "+30" },
{ name: "Grenada", code: "GD", dialCode: "+1-473" },
{ name: "Guatemala", code: "GT", dialCode: "+502" },
{ name: "Guinea", code: "GN", dialCode: "+224" },
{ name: "Guinea-Bissau", code: "GW", dialCode: "+245" },
{ name: "Guyana", code: "GY", dialCode: "+592" },
{ name: "Haiti", code: "HT", dialCode: "+509" },
{ name: "Honduras", code: "HN", dialCode: "+504" },
{ name: "Hungary", code: "HU", dialCode: "+36" },
{ name: "Iceland", code: "IS", dialCode: "+354" },
{ name: "India", code: "IN", dialCode: "+91" },
{ name: "Indonesia", code: "ID", dialCode: "+62" },
{ name: "Iran", code: "IR", dialCode: "+98" },
{ name: "Iraq", code: "IQ", dialCode: "+964" },
{ name: "Ireland", code: "IE", dialCode: "+353" },
{ name: "Israel", code: "IL", dialCode: "+972" },
{ name: "Italy", code: "IT", dialCode: "+39" },
{ name: "Jamaica", code: "JM", dialCode: "+1-876" },
{ name: "Japan", code: "JP", dialCode: "+81" },
{ name: "Jordan", code: "JO", dialCode: "+962" },
{ name: "Kazakhstan", code: "KZ", dialCode: "+7" },
{ name: "Kenya", code: "KE", dialCode: "+254" },
{ name: "Kiribati", code: "KI", dialCode: "+686" },
{ name: "Kuwait", code: "KW", dialCode: "+965" },
{ name: "Kyrgyzstan", code: "KG", dialCode: "+996" },
{ name: "Laos", code: "LA", dialCode: "+856" },
{ name: "Latvia", code: "LV", dialCode: "+371" },
{ name: "Lebanon", code: "LB", dialCode: "+961" },
{ name: "Lesotho", code: "LS", dialCode: "+266" },
{ name: "Liberia", code: "LR", dialCode: "+231" },
{ name: "Libya", code: "LY", dialCode: "+218" },
{ name: "Liechtenstein", code: "LI", dialCode: "+423" },
{ name: "Lithuania", code: "LT", dialCode: "+370" },
{ name: "Luxembourg", code: "LU", dialCode: "+352" },
{ name: "Madagascar", code: "MG", dialCode: "+261" },
{ name: "Malawi", code: "MW", dialCode: "+265" },
{ name: "Malaysia", code: "MY", dialCode: "+60" },
{ name: "Maldives", code: "MV", dialCode: "+960" },
{ name: "Mali", code: "ML", dialCode: "+223" },
{ name: "Malta", code: "MT", dialCode: "+356" },
{ name: "Marshall Islands", code: "MH", dialCode: "+692" },
{ name: "Mauritania", code: "MR", dialCode: "+222" },
{ name: "Mauritius", code: "MU", dialCode: "+230" },
{ name: "Mexico", code: "MX", dialCode: "+52" },
{ name: "Micronesia", code: "FM", dialCode: "+691" },
{ name: "Moldova", code: "MD", dialCode: "+373" },
{ name: "Monaco", code: "MC", dialCode: "+377" },
{ name: "Mongolia", code: "MN", dialCode: "+976" },
{ name: "Montenegro", code: "ME", dialCode: "+382" },
{ name: "Morocco", code: "MA", dialCode: "+212" },
{ name: "Mozambique", code: "MZ", dialCode: "+258" },
{ name: "Myanmar (Burma)", code: "MM", dialCode: "+95" },
{ name: "Namibia", code: "NA", dialCode: "+264" },
{ name: "Nauru", code: "NR", dialCode: "+674" },
{ name: "Nepal", code: "NP", dialCode: "+977" },
{ name: "Netherlands", code: "NL", dialCode: "+31" },
{ name: "New Zealand", code: "NZ", dialCode: "+64" },
{ name: "Nicaragua", code: "NI", dialCode: "+505" },
{ name: "Niger", code: "NE", dialCode: "+227" },
{ name: "Nigeria", code: "NG", dialCode: "+234" },
{ name: "North Korea", code: "KP", dialCode: "+850" },
{ name: "North Macedonia", code: "MK", dialCode: "+389" },
{ name: "Norway", code: "NO", dialCode: "+47" },
{ name: "Oman", code: "OM", dialCode: "+968" },
{ name: "Pakistan", code: "PK", dialCode: "+92" },
{ name: "Palau", code: "PW", dialCode: "+680" },
{ name: "Palestine", code: "PS", dialCode: "+970" },
{ name: "Panama", code: "PA", dialCode: "+507" },
{ name: "Papua New Guinea", code: "PG", dialCode: "+675" },
{ name: "Paraguay", code: "PY", dialCode: "+595" },
{ name: "Peru", code: "PE", dialCode: "+51" },
{ name: "Philippines", code: "PH", dialCode: "+63" },
{ name: "Poland", code: "PL", dialCode: "+48" },
{ name: "Portugal", code: "PT", dialCode: "+351" },
{ name: "Qatar", code: "QA", dialCode: "+974" },
{ name: "Romania", code: "RO", dialCode: "+40" },
{ name: "Russia", code: "RU", dialCode: "+7" },
{ name: "Rwanda", code: "RW", dialCode: "+250" },
{ name: "Saint Kitts and Nevis", code: "KN", dialCode: "+1-869" },
{ name: "Saint Lucia", code: "LC", dialCode: "+1-758" },
{ name: "Saint Vincent and the Grenadines", code: "VC", dialCode: "+1-784" },
{ name: "Samoa", code: "WS", dialCode: "+685" },
{ name: "San Marino", code: "SM", dialCode: "+378" },
{ name: "Sao Tome and Principe", code: "ST", dialCode: "+239" },
{ name: "Saudi Arabia", code: "SA", dialCode: "+966" },
{ name: "Senegal", code: "SN", dialCode: "+221" },
{ name: "Serbia", code: "RS", dialCode: "+381" },
{ name: "Seychelles", code: "SC", dialCode: "+248" },
{ name: "Sierra Leone", code: "SL", dialCode: "+232" },
{ name: "Singapore", code: "SG", dialCode: "+65" },
{ name: "Slovakia", code: "SK", dialCode: "+421" },
{ name: "Slovenia", code: "SI", dialCode: "+386" },
{ name: "Solomon Islands", code: "SB", dialCode: "+677" },
{ name: "Somalia", code: "SO", dialCode: "+252" },
{ name: "South Africa", code: "ZA", dialCode: "+27" },
{ name: "South Korea", code: "KR", dialCode: "+82" },
{ name: "South Sudan", code: "SS", dialCode: "+211" },
{ name: "Spain", code: "ES", dialCode: "+34" },
{ name: "Sri Lanka", code: "LK", dialCode: "+94" },
{ name: "Sudan", code: "SD", dialCode: "+249" },
{ name: "Suriname", code: "SR", dialCode: "+597" },
{ name: "Sweden", code: "SE", dialCode: "+46" },
{ name: "Switzerland", code: "CH", dialCode: "+41" },
{ name: "Syria", code: "SY", dialCode: "+963" },
{ name: "Taiwan", code: "TW", dialCode: "+886" },
{ name: "Tajikistan", code: "TJ", dialCode: "+992" },
{ name: "Tanzania", code: "TZ", dialCode: "+255" },
{ name: "Thailand", code: "TH", dialCode: "+66" },
{ name: "Timor-Leste", code: "TL", dialCode: "+670" },
{ name: "Togo", code: "TG", dialCode: "+228" },
{ name: "Tonga", code: "TO", dialCode: "+676" },
{ name: "Trinidad and Tobago", code: "TT", dialCode: "+1-868" },
{ name: "Tunisia", code: "TN", dialCode: "+216" },
{ name: "Turkey", code: "TR", dialCode: "+90" },
{ name: "Turkmenistan", code: "TM", dialCode: "+993" },
{ name: "Tuvalu", code: "TV", dialCode: "+688" },
{ name: "Uganda", code: "UG", dialCode: "+256" },
{ name: "Ukraine", code: "UA", dialCode: "+380" },
{ name: "United Arab Emirates", code: "AE", dialCode: "+971" },
{ name: "United Kingdom", code: "GB", dialCode: "+44" },
{ name: "United States", code: "US", dialCode: "+1" },
{ name: "Uruguay", code: "UY", dialCode: "+598" },
{ name: "Uzbekistan", code: "UZ", dialCode: "+998" },
{ name: "Vanuatu", code: "VU", dialCode: "+678" },
{ name: "Vatican City", code: "VA", dialCode: "+379" },
{ name: "Venezuela", code: "VE", dialCode: "+58" },
{ name: "Vietnam", code: "VN", dialCode: "+84" },
{ name: "Yemen", code: "YE", dialCode: "+967" },
{ name: "Zambia", code: "ZM", dialCode: "+260" },
{ name: "Zimbabwe", code: "ZW", dialCode: "+263" }
];

function populateFields() {
const countrySelect = document.getElementById("country");
const codeSelect = document.getElementById("countryCode");

countries.forEach(({ name, dialCode }) => {
  // Populate country dropdown
  const countryOption = document.createElement("option");
  countryOption.value = name;
  countryOption.textContent = name;
  countrySelect.appendChild(countryOption);

  // Populate country code dropdown
  const codeOption = document.createElement("option");
  codeOption.value = dialCode;
  codeOption.textContent = dialCode;
  codeSelect.appendChild(codeOption);
});

// Synchronize the dropdowns
countrySelect.addEventListener("change", () => {
  codeSelect.selectedIndex = countrySelect.selectedIndex;
});

codeSelect.addEventListener("change", () => {
  countrySelect.selectedIndex = codeSelect.selectedIndex;
});
}

window.onload = populateFields;
</script>
</body>
</html>