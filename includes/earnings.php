<?php
global $tlikefunds;
?>
<p>
    <div class="w3-container">
        <?php include ('server.php'); ?>
        <form action="" method="POST">
        <p>Daily Earnings</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-blue-grey">₦ <?php echo number_format($_SESSION['dailye'], 2); ?> </div>
        </div>

        <p>Like Funds <i class="w3-text-purple"><small>(coming soon.)</small></i></p>
        <div size="1" class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-deep-purple">₦ 0.00
            <span class="w3-right"><a href="like_wallet.php" class="w3-button w3-round-xxlarge w3-deep-purple">CASHOUT</a></span>
            </div>
        </div>

        <p>Referral Earnings</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-khaki">₦ <?php echo $totalrefearn; ?>
            <span class="w3-right"><?php echo "(" .$crb. " referrals)"; ?></span> </div>
        </div>

        <p>Accumulated Daily Earnings</p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-teal">₦ <?php echo $ste; ?>
            <span class="w3-right"><?php echo "(" .$cte. " days earnings)"; ?></span> </div>
        </div>

        <p>Total Earnings <i class="w3-text-amber"><small>(total daily + referral earnings)</small></i></p>
        <div class="w3-grey">
            <div class="w3-container w3-center w3-padding w3-amber">₦ <?php echo number_format($te, 2); ?></div>
        </div>

        <p class=" w3-padding-50">
		<?php
		$mb = 3000;
		if ($te < $mb) {
			?>			
        <button disabled type="button" class="w3-button w3-round-xxlarge w3-red"> WITHDRAW</button>
			<?php
		} else {
		?>			
        <button type="button" href="javascript:void(0)" class="w3-button w3-round-xxlarge w3-red" onclick="document.getElementById('wdmodal').style.display='block'"> WITHDRAW</button>
		<?php
		}
		?>
          </p>
</form>
        </div>

        <!-- Withdrawal Modal -->
<div id="wdmodal" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom" style="padding:32px">
      <div class="w3-container w3-white w3-center">
        <form action="" method="POST">
        <i onclick="document.getElementById('wdmodal').style.display='none'" class="fa fa-remove w3-right w3-button w3-transparent w3-xxlarge"></i>
        <h3 class="w3-wide">CONFIRM WITHDRAWAL</h3>
		<p>You have requested to make a withdrawal of your available balance amounting to the sum of ₦ <?php echo number_format($te, 2); ?><br> Note, your subscription will be terminated.<br></p>
            <button type="submit" name="wdbtn" id="wdbtn" class="w3-button w3-margin-bottom w3-round-xxlarge w3-red w3-padding-large"> WITHDRAW</button>
        </form>
      </div>
    </div>
  </div>
</p>