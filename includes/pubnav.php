<style>
  @font-face {
   font-family: myFirstFont;
   src: url(sansation_light.woff);
}

* {
   font-family: myFirstFont;
   font-size: 16px;
}
</style>
<!-- Navbar -->
<div class="w3-top w3-hide-small">
 <!-- TradingView Widget BEGIN -->
 <div class="tradingview-widget-container">
  <div class="tradingview-widget-container__widget"></div>
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
{
  "symbols": [
    {
      "proName": "FOREXCOM:SPXUSD",
      "title": "S&P 500"
    },
    {
      "proName": "FOREXCOM:NSXUSD",
      "title": "Nasdaq 100"
    },
    {
      "proName": "FX_IDC:EURUSD",
      "title": "EUR/USD"
    },
    {
      "proName": "BITSTAMP:BTCUSD",
      "title": "BTC/USD"
    },
    {
      "proName": "BITSTAMP:ETHUSD",
      "title": "ETH/USD"
    },
    {
      "proName": "FX_IDC:GBPUSD",
      "title": "GBP/USD"
    },
    {
      "proName": "FX_IDC:USDJPY",
      "title": "USD/JPY"
    },
    {
      "proName": "FX_IDC:AUDUSD",
      "title": "AUD/USD"
    },
    {
      "proName": "FX_IDC:USDCAD",
      "title": "USD/CAD"
    },
    {
      "proName": "BINANCE:BNBUSDT",
      "title": "BNB/USDT"
    },
    {
      "proName": "BINANCE:XRPUSDT",
      "title": "XRP/USDT"
    },
    {
      "proName": "BINANCE:SOLUSDT",
      "title": "SOL/USDT"
    },
    {
      "proName": "BINANCE:ADAUSDT",
      "title": "ADA/USDT"
    },
    {
      "proName": "BITSTAMP:LTCUSD",
      "title": "LTC/USD"
    },
    {
      "proName": "BITSTAMP:BCHUSD",
      "title": "BCH/USD"
    },
    {
      "proName": "BINANCE:DOGEUSDT",
      "title": "DOGE/USDT"
    },
    {
      "proName": "BINANCE:MATICUSDT",
      "title": "MATIC/USDT"
    },
    {
      "proName": "BINANCE:DOTUSDT",
      "title": "DOT/USDT"
    },
    {
      "proName": "FX_IDC:USDCHF",
      "title": "USD/CHF"
    },
    {
      "proName": "FX_IDC:NZDUSD",
      "title": "NZD/USD"
    }
  ],
  "showSymbolLogo": true,
  "colorTheme": "dark",
  "isTransparent": false,
  "displayMode": "adaptive",
  "locale": "en"
}
</script>

</div>
<!-- TradingView Widget END -->

<!-- Navbar -->
<div class="w3-top">

<!-- slidebar -->
<?php
  include 'includes/slide.php';
  ?>
    <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
        <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
        <a href="index.php" class="w3-bar-item w3-button w3-padding-medium w3-hover-white" title="Connect Logo" style="cursor:pointer">Connect</a>
        <a href="index.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Home" style="cursor:pointer"><i class="fa fa-home"></i> Home</a>
        <a href="about.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="About" style="cursor:pointer"><i class="fa fa-globe"></i> About</a>
		<a href="product-list.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Market Place" style="cursor:pointer"><i class="fa fa-store"></i> Market Place</a>
		<a href="forum.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Forums" style="cursor:pointer"><i class="fa fa-newspaper"></i> Forums</a>
		<a href="pair_charts.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Pair Charts" style="cursor:pointer"><i class="fa fa-chart-line"></i> Charts</a>
		<a href="trainings.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Trainings" style="cursor:pointer"><i class="fa fa-graduation-cap"></i> Trainings</a>
		<a href="authenticate.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Authenticate" style="cursor:pointer"><i class="fa fa-double-check"></i> Authenticate</a>
        <a href="contact.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white" title="Contact"><i class="fa fa-mobile"></i> Contact</a>
        <a href="register.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-right w3-text-blue" title="Register"><i class="fa fa-laptop"></i> Register</a>
        <a href="login.php" class="w3-bar-item w3-button w3-hide-small w3-padding-medium w3-hover-white w3-right w3-text-green" title="Login"><i class="fa fa-lock-open"></i> Login</a>
    </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">
    <a href="#about" class="w3-bar-item w3-button w3-padding-large">About</a>
    <a href="#features" class="w3-bar-item w3-button w3-padding-large">Features</a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large">Contact</a>
    <a href="login.php" class="w3-bar-item w3-button w3-padding-large">Login</a>
    <a href="register.php" class="w3-bar-item w3-button w3-padding-large">Register</a>
</div>

<header class="w3-bar w3-hide-medium w3-hide-large w3-card w3-theme-d2">
  <button class="w3-bar-item w3-button w3-xxlarge w3-hover-theme" onclick="openSidebar()">&#9776;</button>
  <h1 class="w3-bar-item"><a href="mypage.php"><img class="w3-circle" src="images/logo.png" alt="Connect" style="width:100%"></a></h1>
</header>


<script>
closeSidebar();
function openSidebar() {
  document.getElementById("mySidebar").style.display = "block";
}

function closeSidebar() {
  document.getElementById("mySidebar").style.display = "none";
}
</script>

	<script type="text/javascript">
		function googleTranslateElementInit() {
			new google.translate.TranslateElement({
				pageLanguage: 'en',
				layout: google.translate.TranslateElement.InlineLayout.SIMPLE
			}, 'google_translate_element');
		}
	</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</div>