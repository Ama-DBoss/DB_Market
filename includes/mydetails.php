<fieldset>

<!-- logged in user information -->
<?php  if (isset($_SESSION['username'])) : ?>
<legend>Welcome! 
    <label id="user_label"><b> <strong><?php echo $_SESSION['username']; ?></strong> </b></label>
</legend>
  <?php endif ?>
            <a href="logout.php"><button class="w3-button w3-round-xlarge w3-red w3-right fa fa-sign-out" name="logout"> LOGOUT</button></a>
          
         <p class="w3-center">
           <a href="acc_settings.php"><img src="images/avatar3.png" class="w3-circle" style="height:106px;width:106px" alt="Avatar"></a>
          </p>
         <hr style="border: 1px solid">
         <?php
              $sql = "SELECT * FROM connect_users WHERE uname=?";
              $stmt = mysqli_stmt_init($DBconn);
              mysqli_stmt_prepare($stmt,$sql);
               mysqli_stmt_bind_param($stmt,'s',$_SESSION['username']); //s-string, i-integer, d-double
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              if ($rows = mysqli_fetch_assoc($result)){
              ?>
           <p><i class="fa fa-user fa-fw w3-margin-right w3-text-theme"></i> <?php echo $rows['lname'].','. " " . $rows["fname"]. " " . $rows["mname"]; ?>  </p>
           <p><i class="fa fa-home fa-fw w3-margin-right w3-text-theme"></i> <?php echo $rows['address']; ?> </p>
           <p><i class="fa fa-phone fa-fw w3-margin-right w3-text-theme"></i> <?php echo $rows['pnumber']; ?> </p>
           <p><i class="fa fa-envelope fa-fw w3-margin-right w3-text-theme"></i> <?php echo $rows['email']; ?> </p>
           <p><i class="fa fa-birthday-cake fa-fw w3-margin-right w3-text-theme"></i> <?php echo $rows['user_dob']; ?> </p>
           <?php } ?>
         <hr style="border: 1px solid">
        <h4 class="w3-center w3-block w3-theme-l1">Account Details</h4>
        <?php
              $sql = "SELECT * FROM bankdetails WHERE uname=?";
              $stmt = mysqli_stmt_init($DBconn);
              mysqli_stmt_prepare($stmt,$sql);
               mysqli_stmt_bind_param($stmt,'s',$_SESSION['username']); //s-string, i-integer, d-double
              mysqli_stmt_execute($stmt);
              $result = mysqli_stmt_get_result($stmt);
              if ($rows = mysqli_fetch_assoc($result)){
              ?>
        <p><i class="fa fa-bank fa-fw w3-margin-right w3-text-theme"></i> Bank Name: <?php echo $rows['userbankname']; ?></p>
        <p><i class="fa fa-bank fa-fw w3-margin-right w3-text-theme"></i> Account Name: <?php echo $rows['useracctname']; ?></p>
        <p><i class="fa fa-bank fa-fw w3-margin-right w3-text-theme"></i> Account Number: <?php echo $rows['useracctnumber']; ?></p>
        <p><i class="fa fa-bank fa-fw w3-margin-right w3-text-theme"></i> BVN: <?php echo $rows['useracctbvn']; }?></p>
        </fieldset>