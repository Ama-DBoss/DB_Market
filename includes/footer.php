<footer class="w3-container w3-theme-d2">
    <p style="text-align: center;">
        <h5 style="text-align: center;">
            <a href="https://facebook.com/connectfunds" target="_blank" class="facebook">
                <i class="fa fa-facebook" style="padding-right: 20px;"></i>
            </a>
            <a href="https://instagram.com/connectfunds" target="_blank" class="instagram">
                <i class="fa fa-instagram" style="padding-right: 20px;"></i>
            </a>
            <a href="https://twitter.com/connectfunds" target="_blank" class="twitter">
                <i class="fa fa-twitter" style="padding-right: 20px;"></i>
            </a>
        </h5>
    </p>
    <p style="text-align: center;">
        Powered by 
        <a href="index.php" style="text-decoration: none" target="">CONNECT &copy; <?php echo date("Y"); ?></a>
    </p>
    <p style="text-align: center;">
        <a href="about.php" style="text-decoration: none">ABOUT US</a> | 
        <a href="tnc.php#faq" style="text-decoration: none">FAQ</a> | 
        <a href="tnc.php#tnc" style="text-decoration: none">T&C's</a> | 
        <a href="tnc.php#pp" style="text-decoration: none">PRIVACY POLICY</a> | 
        <a href="contact.php" style="text-decoration: none">CONTACT US</a>
    </p>
</footer>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>

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

<script>
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");
    var overlayBg = document.getElementById("myOverlay");

    // Toggle between showing and hiding the sidebar, and add overlay effect
    function w3_open() {
        if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
            overlayBg.style.display = "none";
        } else {
            mySidebar.style.display = 'block';
            overlayBg.style.display = "block";
        }
    }

    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
        overlayBg.style.display = "none";
    }

    // Accordion
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-theme-d1";
        } else { 
            x.className = x.className.replace("w3-show", "");
            x.previousElementSibling.className = x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
    }

    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
        var x = document.getElementById("mySidebar");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else { 
            x.className = x.className.replace("w3-show", "");
        }
    }
</script>