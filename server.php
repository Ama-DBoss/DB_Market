<?php
error_reporting(E_ALL ^ E_NOTICE);
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

//session_start();
//session_regenerate_id(true); //Regenerate session ID to prevent fixation attacks
//ini_set('session.cookie_httponly', 1); //Prevent Javascript access to session
//ini_set('session.cookie_secure', 1); //Ensure cookies are sent only over HTTPS
//ini_set('session.use_only_cookies', 1); //Enforce use of cookies instead of URL-based sessions

// Handle and display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<div class="error">' . htmlspecialchars($error) . '</div>';
    }
}


// LOGIN ADMIN USER
if (isset($_POST['valpass'])) {
  $adminvaluser = mysqli_real_escape_string($DBconn, $_POST['adminvaluser']);
  $adminvalpass = mysqli_real_escape_string($DBconn, $_POST['adminvalpass']);

  if (empty($adminvaluser)) {
      array_push($errors, "Username is required");
  }
  if (empty($adminvalpass)) {
      array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
      // $password = md5($adminvalpass);
      $adminquery = "SELECT * FROM admins WHERE admin_uname='$adminvaluser' AND admin_pwd='$adminvalpass'";
      $results = mysqli_query($DBconn, $adminquery);
      if (mysqli_num_rows($results) == 1) {
        $_SESSION['adminuser'] = $adminvaluser;
        $_SESSION['logged_in'] = true;
        header('location: adminboard.php');
      }else {
          array_push($errors, "Wrong username/password combination");
      }
  }
  // global $_SESSION['username'];
  global $adminvaluser;
}

//ADD ACCT DETAILS
// initializing variables
$bName = "";
  $bvn = "";
  $aName = "";
  $aNo = "";
  $errors = array();


if (isset($_POST['saveacctdet'])) {
  $acctuser = $_SESSION['username'];
  // receive all input values from the form
  $bName = mysqli_real_escape_string($DBconn, $_POST['bankname']);
  $bvn = mysqli_real_escape_string($DBconn, $_POST['bvn']);
  $aName = mysqli_real_escape_string($DBconn, $_POST['acctname']);
  $aNo = mysqli_real_escape_string($DBconn, $_POST['acctno']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($bName)) { array_push($errors, "Bank name is required"); }
  if (empty($bvn)) { array_push($errors, "BVN is required"); }
  if (empty($aName)) { array_push($errors, "Account name is required"); }
  if (empty($aNo)) { array_push($errors, "Account number is required"); }

      // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM bankdetails WHERE uname= '$acctuser' LIMIT 1";
  $result = mysqli_query($DBconn, $user_check_query);
  $userc = mysqli_fetch_assoc($result);
  
  if ($userc) { // if user exists
    if ($userc['uname'] === $acctuser) {
      array_push($errors, "Account Details Already Exist... <br>To Update, contact our support team at support@connect.com <br>Thanks.");
    }
  }

        // Finally, register user if there are no errors in the form
        if (count($errors) == 0) {

            $acctquery = "INSERT INTO bankdetails (uname, userbankname, useracctname, useracctnumber, useracctbvn) 
            VALUES('$acctuser', '$bName', '$aName', '$aNo', '$bvn')";
            mysqli_query($DBconn, $acctquery);
            // $_SESSION['username'] = $user;
            $_SESSION['successInfo'] = "Account Saved Successfully!!!";
            header('location: acc_settings.php');
            }
            else{
            array_push($errors, "Account Details Not Saved.");
            }
  }



$actcode = "";
$pcktype = "";
$actsubuser = $_SESSION['username'] ?? ''; // Ensure session is active and username is set

$errors = []; // Initialize error array

if (isset($_POST['actbtn'])) {
    // Sanitize inputs
    $actcode = mysqli_real_escape_string($DBconn, $_POST['actcode']);
    $pcktype = mysqli_real_escape_string($DBconn, $_POST['selpck']);

    // Validate inputs
    if (empty($actcode)) {
        $errors[] = "Activation Code is required.";
    }
    if (empty($pcktype)) {
        $errors[] = "Select Desired Package.";
    }

    if (empty($errors)) {
        // Check for activation code in the activationcodes table
        $concode_check_query = "SELECT * FROM sactivationcodes WHERE Package_name = ? AND activation_code = ? AND subuser = ? LIMIT 1";
        $stmt = mysqli_prepare($DBconn, $concode_check_query);
        mysqli_stmt_bind_param($stmt, 'sss', $pcktype, $actcode, $actsubuser);
        mysqli_stmt_execute($stmt);
        $concodeuserc = mysqli_stmt_get_result($stmt)->fetch_assoc();
        mysqli_stmt_close($stmt);

        if (!$concodeuserc) {
            $errors[] = "Invalid Activation Token. Please Purchase A Valid Activation Token.";
        } else {
            // Check if the code has been used
            $cuser_check_query = "SELECT * FROM subscription WHERE act_code = ? LIMIT 1";
            $stmt = mysqli_prepare($DBconn, $cuser_check_query);
            mysqli_stmt_bind_param($stmt, 's', $actcode);
            mysqli_stmt_execute($stmt);
            $cuserc = mysqli_stmt_get_result($stmt)->fetch_assoc();
            mysqli_stmt_close($stmt);

            if ($cuserc) {
                $errors[] = "Activation Token Already Used.";
            }

            // Check if the user already has an active subscription
            $user_check_query = "SELECT * FROM subscription WHERE uname = ? LIMIT 1";
            $stmt = mysqli_prepare($DBconn, $user_check_query);
            mysqli_stmt_bind_param($stmt, 's', $actsubuser);
            mysqli_stmt_execute($stmt);
            $userc = mysqli_stmt_get_result($stmt)->fetch_assoc();
            mysqli_stmt_close($stmt);

            if ($userc) {
                $errors[] = "You Have An Active Subscription.";
            }

            // If no errors, proceed with subscription
            if (empty($errors)) {
                // Fetch package amount
                $gpa_query = "SELECT pck_amount FROM packages WHERE pck_name = ? LIMIT 1";
                $stmt = mysqli_prepare($DBconn, $gpa_query);
                mysqli_stmt_bind_param($stmt, 's', $pcktype);
                mysqli_stmt_execute($stmt);
                $gparesult = mysqli_stmt_get_result($stmt);
                $package = $gparesult->fetch_assoc();
                mysqli_stmt_close($stmt);

                if ($package) {
                    $gpava = $package['pck_amount'];
                    $gpacat = 'Deposit';

                    // Insert history record
                    $gpaquery = "INSERT INTO history (h_uname, h_category, h_purpose, h_value) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($DBconn, $gpaquery);
                    mysqli_stmt_bind_param($stmt, 'sssd', $actsubuser, $gpacat, $pcktype, $gpava);
                    if (!mysqli_stmt_execute($stmt)) {
                        $errors[] = "Error inserting into history: " . mysqli_error($DBconn);
                    }
                    mysqli_stmt_close($stmt);

                    // Insert subscription
                    $subquery = "INSERT INTO subscription (uname, type, act_code) VALUES (?, ?, ?)";
                    $stmt = mysqli_prepare($DBconn, $subquery);
                    mysqli_stmt_bind_param($stmt, 'sss', $actsubuser, $pcktype, $actcode);
                    if (!mysqli_stmt_execute($stmt)) {
                        $errors[] = "Error activating subscription: " . mysqli_error($DBconn);
                    }
                    mysqli_stmt_close($stmt);

                    // Remove activation code from sactivationcodes
                    $deleteacSql = "DELETE FROM sactivationcodes WHERE activation_code = ?";
                    $stmt = mysqli_prepare($DBconn, $deleteacSql);
                    mysqli_stmt_bind_param($stmt, 's', $actcode);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);

                    if (empty($errors)) {
                        $errors[] = "Account Activated Successfully!";
                    }
                } else {
                    $errors[] = "Selected package not found.";
                }
            }
        }
    }
}

// Display errors or success messages
foreach ($errors as $error) {
    echo "<p>$error</p>";
}

//withdrawal method
$wduser = $_SESSION['username'];
$minwd = 3000;
$mindays = 30;

global $minwd;
global $mindays;

$neededsql = "SELECT * FROM connect_users WHERE uname= '$wduser'";
$result =$DBconn->query($neededsql);
if($result->num_rows < 0){
  //do nothing
}
else {
  while($row = $result->fetch_assoc()){
    ?>
    <label class="w3-hide">
      <?php
        echo $row['email'];
        echo $row['pnumber'];
        echo $row['user_ref_link'];
      ?>
    </label>
    <?php
    $wdpnumber = $row['pnumber'];
    $wdemail = $row['email'];
    $userreflink = $row['user_ref_link'];
  }
  global $userreflink;
}

$neededearnsql = "SELECT * FROM earnings WHERE uname= '$wduser'";
$result =$DBconn->query($neededearnsql);
  if($result->num_rows < 0){
    //do nothing
  }
  else {
    while($row = $result->fetch_assoc()){
      ?>
      <label class="w3-hide">
        <?php
          echo $row['totalearning'];
        ?>
      </label>
      <?php
      $wdte = $row['totalearning'];
    }
  }

  $crbsql = "SELECT COUNT(referredby) FROM connect_users WHERE referredby='$userreflink' ";
    $result = $DBconn->query($crbsql);
    while($row = $result->fetch_assoc()){
    ?>
    <p class="w3-hide"><?php echo $row['COUNT(referredby)']; ?></p>
    <?php
    $crb = $row['COUNT(referredby)'];
  global $crb; }

  $ctesql = "SELECT COUNT(totalearning) FROM earnings WHERE uname= '$wduser' ";
    $result = $DBconn->query($ctesql);
      while($row = $result->fetch_assoc()){
      ?>
    <p class="w3-hide"><?php echo $row['COUNT(totalearning)']; ?></p>
    <?php
    $cte = $row['COUNT(totalearning)'];
    global $cte;}

  $ctpsql = "SELECT COUNT(uname) FROM posts WHERE uname= '$wduser' ";
    $result = $DBconn->query($ctpsql);
      while($row = $result->fetch_assoc()){
      ?>
    <p class="w3-hide"><?php echo $row['COUNT(uname)']; ?></p>
    <?php
    $ctp = $row['COUNT(uname)'];
    global $ctp;}

	$dd = date("Y-m-d");
  $ctdsql = "SELECT COUNT(created_at) FROM earnings WHERE created_at= '$dd' AND uname= '$wduser' ";
    $result = $DBconn->query($ctdsql);
      while($row = $result->fetch_assoc()){
      ?>
    <p class="w3-hide"><?php echo $row['COUNT(created_at)']; ?></p>
    <?php
    $ctd = $row['COUNT(created_at)'];
    global $ctd;}

    $calrefearnsql = "SELECT type FROM subscription WHERE uname= '$wduser'";
    $result =$DBconn->query($calrefearnsql);
      if($result->num_rows < 0){
        //do nothing
      }
      else {
        while($row = $result->fetch_assoc()){
          ?>
          <label class="w3-hide">
            <?php
              echo $row['type'];
            ?>
          </label>
          <?php
          $subtype = $row['type'];
          global $subtype;
        }
      }
      global $subtype;
      global $totalrefearn;
      global $userpck;

      $pckrefearnsql = "SELECT pck_referralearns FROM packages WHERE pck_name= '$subtype'";
    $result =$DBconn->query($pckrefearnsql);
      if($result->num_rows < 0){
        //do nothing
      }
      else {
        while($row = $result->fetch_assoc()){
          ?>
          <label class="w3-hide">
            <?php
              echo $row['pck_referralearns'];
            ?>
          </label>
          <?php
          $pckrefearn = $row['pck_referralearns'];
          global $pckrefearn;
          $totalrefearn = $pckrefearn * $crb;
          global $totalrefearn;
        }
      }

        $tesql = "SELECT SUM(totalearning) FROM earnings WHERE uname= '$wduser' ";
        $result = $DBconn->query($tesql);
          while($row = $result->fetch_assoc()){
          ?>
        <p class="w3-hide"><?php echo $row['SUM(totalearning)']; ?></p>
        <?php
        $ste = $row['SUM(totalearning)'];
        $te = $ste + $totalrefearn;
        global $te; }

        global $wduser;

if (isset($_POST['wdbtn'])) {
    $errors = []; // Ensure the errors array is initialized

    // Check if user exists in the earnings table
    $e_check_query = "SELECT * FROM earnings WHERE uname = ? LIMIT 1";
    $stmt = mysqli_prepare($DBconn, $e_check_query);
    mysqli_stmt_bind_param($stmt, 's', $wduser);
    mysqli_stmt_execute($stmt);
    $euserc = mysqli_stmt_get_result($stmt);
    $userEarnings = mysqli_fetch_assoc($euserc);

    if ($userEarnings) {
        // Validate withdrawal conditions
        if ($te < $minwd) {
            $errors[] = "Insufficient funds for withdrawal.";
        } //elseif ($cte < $mindays) {
            //$errors[] = "Your 30-day investment period is still active.";
        //}
    } else {
        $errors[] = "You have no earnings for withdrawal.";
    }
    mysqli_stmt_close($stmt);

    // Fetch user's bank details
    $bsql = "SELECT * FROM bankdetails WHERE uname = ?";
    $stmt = mysqli_prepare($DBconn, $bsql);
    mysqli_stmt_bind_param($stmt, 's', $wduser);
    mysqli_stmt_execute($stmt);
    $bankDetails = mysqli_stmt_get_result($stmt);
    $bankRow = mysqli_fetch_assoc($bankDetails);

    if ($bankRow) {
        $wduserbankname = $bankRow['userbankname'];
        $wduseracctname = $bankRow['useracctname'];
        $wduseracctno = $bankRow['useracctnumber'];
    } else {
        $errors[] = "Bank details not found. Please update your profile.";
    }
    mysqli_stmt_close($stmt);

    // Check if a withdrawal request already exists for this user
    $wuser_check_query = "SELECT * FROM withdrawals WHERE uname = ? LIMIT 1";
    $stmt = mysqli_prepare($DBconn, $wuser_check_query);
    mysqli_stmt_bind_param($stmt, 's', $wduser);
    mysqli_stmt_execute($stmt);
    $withdrawalCheck = mysqli_stmt_get_result($stmt);
    $wuserc = mysqli_fetch_assoc($withdrawalCheck);

    if ($wuserc) {
        $errors[] = "Your withdrawal request has already been sent.";
    }
    mysqli_stmt_close($stmt);

    // Submit withdrawal request if no errors
    if (count($errors) === 0) {
        // Insert into withdrawals table
        $wsql = "INSERT INTO withdrawals (uname, wdamt, bankname, acctname, acctno, phoneno, email) 
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($DBconn, $wsql);
        mysqli_stmt_bind_param($stmt, 'sssssss', $wduser, $te, $wduserbankname, $wduseracctname, $wduseracctno, $wdpnumber, $wdemail);
        mysqli_stmt_execute($stmt);
		
		$wa = 'Withdrawal';
		$bn = 'Bank';
        // Insert into history table
        $hsql = "INSERT INTO history (h_uname, h_category, h_purpose, h_value) 
                 VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($DBconn, $hsql);
        mysqli_stmt_bind_param($stmt, 'ssss', $wduser, $wa, $bn, $te);
        mysqli_stmt_execute($stmt);

        // Remove user data from earnings and subscription tables
        $deleteEarningsSql = "DELETE FROM earnings WHERE uname = ?";
        $deleteSubscriptionSql = "DELETE FROM subscription WHERE uname = ?";

        $stmt = mysqli_prepare($DBconn, $deleteEarningsSql);
        mysqli_stmt_bind_param($stmt, 's', $wduser);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $stmt = mysqli_prepare($DBconn, $deleteSubscriptionSql);
        mysqli_stmt_bind_param($stmt, 's', $wduser);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $errors[] = "Withdrawal request sent successfully.";
    }

    // Display errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo '<div class="error">' . htmlspecialchars($error) . '</div>';
        }
    }
}

//daily earning incremental
$earnuser = $_SESSION['username'];
$earnedday = date("Y-m-d");

$reqinfosql = "SELECT * FROM subscription WHERE uname= '$earnuser'";
$result =$DBconn->query($reqinfosql);
  if($result->num_rows < 0){
    //do nothing
  }
  else {
    while($row = $result->fetch_assoc()){
      ?>
      <label class="w3-hide">
        <?php
          echo $row['type'];
        ?>
      </label>
      <?php
    $userpck = $row['type'];
    global  $userpck;
    }
  }

  $reqinfo2sql = "SELECT * FROM earnings WHERE uname= '$earnuser'";
  $result =$DBconn->query($reqinfo2sql);
    if($result->num_rows < 0){
      //do nothing
    }
    else {
      while($row = $result->fetch_assoc()){
        ?>
        <label class="w3-hide">
          <?php
            echo $row['totalearning'];
          ?>
        </label>
        <?php
      $pckte = $row['totalearning'];
      global  $pckte;
      }
    }

  $reqinfo1sql = "SELECT * FROM packages WHERE pck_name= '$userpck'";
  $result =$DBconn->query($reqinfo1sql);
    if($result->num_rows < 0){
      array_push($errors, "Please Subscribe To A Package To Enable You Start Earning.");
    }
    else {
      while($row = $result->fetch_assoc()){
        ?>
        <label class="w3-hide">
          <?php
            echo $row['pck_amount'];
            echo $row['pck_roi'];
            echo $row['pck_dailyearns'];
            echo $row['pck_referralearns'];
          ?>
        </label>
        <?php
        $pckamt = $row['pck_amount'];
        $pckde = $row['pck_dailyearns'];
        $pckroi = $row['pck_roi'];
        $pckre = $row['pck_referralearns'];

        global $pckamt;
        global $pckde;
        global $pckroi;
        global $pckre;
      }
    }
	
if (isset($_POST['share'])) {
    // Get the current date
    $currentDate = date('Y-m-d');
    $earnuser = $_SESSION['username']; // User from session

    // Check if the user completed at least 2 tasks today
    $task_check_query = "SELECT COUNT(*) AS task_count FROM task_done WHERE uname = ? AND post_date = ?";
    $stmt = $DBconn->prepare($task_check_query);
    $stmt->bind_param("ss", $earnuser, $currentDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $taskData = $result->fetch_assoc();
    $taskCount = $taskData['task_count'];

    if ($taskCount < 2) {
        echo "Task not completed. You need to complete at least 2 tasks.";
    } else {
        // Check if earnings for today already exist for the user
        $earnings_check_query = "SELECT * FROM earnings WHERE uname = ? AND day = ? LIMIT 1";
        $stmt = $DBconn->prepare($earnings_check_query);
        $stmt->bind_param("ss", $earnuser, $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $earningsData = $result->fetch_assoc();

        if ($earningsData) {
            echo "Tasks already submitted for today.";
        } else {
            // Credit user if no earnings entry exists
            $userpck = "$userpck"; // Replace with actual package value
            $pckamt = "$pckamt";           // Replace with actual package amount
            $pckde = "$pckde";             // Replace with daily earning value
            $pckroi = "$pckroi";           // Replace with monthly earning value

            $insert_query = "INSERT INTO earnings (uname, user_package, pck_amt, dailyearning, monthlyearning, totalearning, day) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $DBconn->prepare($insert_query);
            $stmt->bind_param("sssddds", $earnuser, $userpck, $pckamt, $pckde, $pckroi, $pckde, $currentDate);

            if ($stmt->execute()) {
                echo "Task performed for the day. Your account has been credited.";
            } else {
                echo "Error: Unable to credit your account. Please try again.";
            }
        }
    }
}

?>