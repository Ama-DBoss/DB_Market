<?php 
session_start();

// function mail() {
//     $to = $email; // Send email to our user
//   $subject = 'Connect Signup | Account Verification'; // Give the email a subject 
//   $message = '
//
//   Welcome To The CONNECT FAMILY!
//   Your account has been created, you can login with the following credentials after you have activated your 
//   account by pressing the url below.
//
//   ------------------------
//   Username: '.$user.'
//   Password: '.$password.'
//   ------------------------
//
//   Please click this link to activate your account:
//   http://www.connect.com/verify.php?email='.$email.'&hash='.$hash.''; // Our message above including the link
//
//   $headers = 'From:noreply@connect.com' . "\r\n"; // Set from headers
//   mail($to, $subject, $message, $headers); // Send our email
// }

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

function successInfo(){
    if(isset($_SESSION['successInfo'])){
        $output = "<div class=\"alert alert-success\" role=\"alert\">";
        $output .= htmlentities($_SESSION['successInfo']);
        $output .= "</div>";

        $_SESSION['successInfo'] = null;
        return $output;
    }
}

function failureInfo(){
    if(isset($_SESSION['failureInfo'])){
        $output = "<div class=\"alert alert-danger\" role=\"alert\">";
        $output .= htmlentities($_SESSION['failureInfo']);
        $output .= "</div>";

        $_SESSION['failureInfo'] = null;
        return $output;
    }
}

function outcomeInfo(){
    if(isset($_SESSION['outcomeInfo'])){
        $output = "<div class=\"alert alert-warning\" role=\"alert\">";
        $output .= htmlentities($_SESSION['outcomeInfo']);
        $output .= "</div>";

        $_SESSION['outcomeInfo'] = null;
        return $output;
    }
}

function __construct() {
    $DBconn = $this->connectDB();
    if(!empty($DBconn)) {
        $this->selectDB($DBconn);
    }
}

function connectDB() {
    $DBconn = mysql_connect($this->host,$this->user,$this->password);
    return $DBconn;
}

function selectDB($DBconn) {
    mysql_select_db($this->database,$DBconn);
}

function runQuery($query) {
    $result = mysql_query($query);
    while($row=mysql_fetch_assoc($result)) {
        $resultset[] = $row;
    }		
    if(!empty($resultset))
        return $resultset;
}

function numRows($query) {
    $result  = mysql_query($query);
    $rowcount = mysql_num_rows($result);
    return $rowcount;	
}

function updateQuery($query) {
    $result = mysql_query($query);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    } else {
        return $result;
    }
}

function insertQuery($query) {
    $result = mysql_query($query);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    } else {
        return $result;
    }
}

function deleteQuery($query) {
    $result = mysql_query($query);
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    } else {
        return $result;
    }
}

function getRealIP(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) { //check for ip from shared internet
        $ip=$_SERVER['HTTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { //check if ip is passed from proxy
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function validStrLen($str, $min, $max){
    $len = strlen($str);
    if($len < $min){
      return "Username is too short. Minimum length is $min characters ($max max)";
    }
    elseif($len > $max){
      return "Username is too long. Maximum length is $max characters ($min min)";
    }
    return TRUE;
  }
?>

<script>
function clickCounter(){
    document.getElementById("like").style.backgroundColor = "pink";

    var clicks = 0;
    if(typeof(Storage) !== "undefined"){
        if(localStorage.clickcount) {
            local.Storage.clickcount = Number(localStorage.clickcount)+1;
        }
        else {
            localStorage.clickcount = 1;
        }

        document.getElementById("result").innerHTML = localStorage.clickcount + "likes";
    }
}

function clickCounter1(){
    document.getElementById("dislike").style.backgroundColor = "pink";

    var clicks = 0;
    if(typeof(Storage) !== "undefined"){
        if(localStorage.clickcount1) {
            local.Storage.clickcount1 = Number(localStorage.clickcount1)+1;
        }
        else {
            localStorage.clickcount1 = 1;
        }

        document.getElementById("result").innerHTML = localStorage.clickcount1 + "dislikes";
    }
}
</script>