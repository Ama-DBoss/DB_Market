<script>
    // Handle form actions dynamically
    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'items_gen.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('vendorOutput').innerHTML = xhr.responseText;
            }
        };
        xhr.send(`action=${action}`);
    }

    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myProducts'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }

    function removeProduct(productId) {
        if (confirm("Are you sure you want to remove this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myWishlist'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }
</script>


    
    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
function showRSS(str) {
if (str.length==0) { 
document.getElementById("rssOutput").innerHTML="";
return;
}
if (window.XMLHttpRequest) {
// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
} else {// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function() {
if (this.readyState==4 && this.status==200) {
document.getElementById("rssOutput").innerHTML=this.responseText;
}
}
xmlhttp.open("GET","get_rss.php?q="+str,true);
xmlhttp.send();
}
</script>

<script>
  // Get the Sidebar
  var mySidebar = document.getElementById("mySidebar");
  
  // Get the DIV with overlay effect
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
  </script>
  
  <script>
      // Accordion
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-theme-d1";
        } else { 
          x.className = x.className.replace("w3-show", "");
          x.previousElementSibling.className = 
          x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
      }
      
      // Used to toggle the menu on smaller screens when clicking on the menu button
      function openNav() {
        var x = document.getElementById("mySidebar");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else { 
          x.className = x.className.replace(" w3-show", "");
        }
      }
      </script>
  
      <script>
      // Toggle between showing and hiding the sidebar when clicking the menu icon
      var mySidebar = document.getElementById("mySidebar");
      
      function w3_open() {
        if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
        } else {
          mySidebar.style.display = 'block';
        }
      }
      
      // Close the sidebar with the close button
      function w3_close() {
          mySidebar.style.display = "none";
      }
      </script>

<script>
  var myIndex = 0;
  carousel();
  
  function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2500);    
  }
  </script>

  <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>













<script>
    // Handle form actions dynamically
    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'vendor_actions.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('vendorOutput').innerHTML = xhr.responseText;
            }
        };
        xhr.send(`action=${action}`);
    }

    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myProducts'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }

    function deleteForum(productId) {
        if (confirm("Are you sure you want to delete this forum?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_forum.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myforums'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }

    function removeProduct(productId) {
        if (confirm("Are you sure you want to remove this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myWishlist'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }
</script>

<script>
// Get the end date dynamically from PHP
var countDownDate = new Date("<?php echo $enddate; ?>").getTime(); // Set to dynamic expiration date from PHP

// Update the count down every 1 second
var x = setInterval(function() {

    // Get today's date and time
    var now = new Date().getTime();

    // Find the distance between now and the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    // Display the result in the element with id="demo"
    document.getElementById("demo").innerHTML = "<br><br><br>" + days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";

    // If the count down is finished, write some text
    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "<br><br><p class='w3-text-red'>SUBSCRIPTION EXPIRED...</p> <br><br><a href='package.php'><button class='w3-button w3-green w3-large w3-round-xxlarge'>Purchase Subscribtion</button></a>";
        document.getElementById("warning").innerHTML = "<i class='fa fa-times w3-text-red'></i>";
    }

    // If the count down is still active, show a check mark
    if (distance > 0) {
        document.getElementById("warning").innerHTML = "<i class='fa fa-check w3-text-green'></i>";
    }
}, 1000);
</script>
    
    <script>
        // Get the Sidebar
        var mySidebar = document.getElementById("mySidebar");
        
        // Get the DIV with overlay effect
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
        </script>
        
        <script>
            // Accordion
            function myFunction(id) {
              var x = document.getElementById(id);
              if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
                x.previousElementSibling.className += " w3-theme-d1";
              } else { 
                x.className = x.className.replace("w3-show", "");
                x.previousElementSibling.className = 
                x.previousElementSibling.className.replace(" w3-theme-d1", "");
              }
            }
            
            // Used to toggle the menu on smaller screens when clicking on the menu button
            function openNav() {
              var x = document.getElementById("mySidebar");
              if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
              } else { 
                x.className = x.className.replace(" w3-show", "");
              }
            }
            </script>
        
            <script>
            // Toggle between showing and hiding the sidebar when clicking the menu icon
            var mySidebar = document.getElementById("mySidebar");
            
            function w3_open() {
              if (mySidebar.style.display === 'block') {
                mySidebar.style.display = 'none';
              } else {
                mySidebar.style.display = 'block';
              }
            }
            
            // Close the sidebar with the close button
            function w3_close() {
                mySidebar.style.display = "none";
            }
            </script>

<script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

  <script>
    function myRef() {
      var x = document.getElementById("ref");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }
    </script>
	
	<script>
  // Load the Facebook SDK
  window.fbAsyncInit = function () {
    FB.init({
      appId: 'YOUR_FACEBOOK_APP_ID', // Replace with your Facebook App ID
      xfbml: true,
      version: 'v12.0',
    });
  };

  (function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = 'https://connect.facebook.net/en_US/sdk.js';
    fjs.parentNode.insertBefore(js, fjs);
  })(document, 'script', 'facebook-jssdk');

  // Attach click event to share buttons
  document.querySelectorAll('.share-btn').forEach(button => {
    button.addEventListener('click', function () {
      const title = this.getAttribute('data-title');
      const image = this.getAttribute('data-image');
      const url = this.getAttribute('data-url');

      FB.ui({
        method: 'share',
        href: url, // URL to share
        quote: title, // Optional: Add a quote
        hashtag: '#YourHashtag', // Optional: Add a hashtag
        display: 'popup',
      }, function (response) {
        if (response && !response.error_message) {
          alert('Post shared successfully!');
        } else {
          alert('Error while sharing.');
        }
      });
    });
  });
</script>


        <script>
            function fbs_click() {
                u = location.href;
                t = document.title;
                window.open('http://www.facebook.com/sharer.php?u=' + encodeURIComponent(u) + '&t=' + encodeURIComponent(t), 'sharer', 'toolbar=0,status=0,width=626,height=436');
                return false;
            }
        </script>
		
		       <script>
            function myAdt() {
              var x = document.getElementById("adt");
              if (x.className.indexOf("w3-show") == -1) {
                x.className += " w3-show";
              } else { 
                x.className = x.className.replace(" w3-show", "");
              }
            }
            </script>
			
			<script>
function showRSS(str) {
if (str.length==0) { 
document.getElementById("rssOutput").innerHTML="";
return;
}
if (window.XMLHttpRequest) {
// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();
} else {// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}
xmlhttp.onreadystatechange=function() {
if (this.readyState==4 && this.status==200) {
document.getElementById("rssOutput").innerHTML=this.responseText;
}
}
xmlhttp.open("GET","get_rss.php?q="+str,true);
xmlhttp.send();
}
</script>

<script>
  // Get the Sidebar
  var mySidebar = document.getElementById("mySidebar");
  
  // Get the DIV with overlay effect
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
  </script>
  
  <script>
      // Accordion
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-theme-d1";
        } else { 
          x.className = x.className.replace("w3-show", "");
          x.previousElementSibling.className = 
          x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
      }
      
      // Used to toggle the menu on smaller screens when clicking on the menu button
      function openNav() {
        var x = document.getElementById("mySidebar");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else { 
          x.className = x.className.replace(" w3-show", "");
        }
      }
      </script>
  
      <script>
      // Toggle between showing and hiding the sidebar when clicking the menu icon
      var mySidebar = document.getElementById("mySidebar");
      
      function w3_open() {
        if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
        } else {
          mySidebar.style.display = 'block';
        }
      }
      
      // Close the sidebar with the close button
      function w3_close() {
          mySidebar.style.display = "none";
      }
      </script>

<script>
  var myIndex = 0;
  carousel();
  
  function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2500);    
  }
  </script>

  <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>






<script>
window.addEventListener('load', function() {
    const scrollableDiv = document.getElementById('scrollableDiv');
    scrollableDiv.scrollTop = scrollableDiv.scrollHeight;
});
</script>

<script>
const ws = new WebSocket('ws://localhost:8080/chat');
let activeFriend = null;
const userId = "<?php echo htmlspecialchars($siu, ENT_QUOTES, 'UTF-8'); ?>";

ws.onopen = () => console.log('Connected to WebSocket server.');
ws.onclose = () => console.warn('Disconnected from WebSocket server.');
ws.onerror = () => console.error('WebSocket error.');

ws.onmessage = (event) => {
    const data = JSON.parse(event.data);
    if (data.type === 'message' && (data.sender === activeFriend || data.receiver === activeFriend)) {
        appendMessage(`${data.sender === userId ? 'You' : 'Friend'}: ${data.message}`);
    }
};

fetch('chat.php?friends')
    .then(response => response.json())
    .then(friends => {
        const friendsList = document.getElementById('friends');
        friends.forEach(friend => {
            const div = document.createElement('div');
            div.textContent = friend.username;
            div.onclick = () => loadChat(friend.id);
            friendsList.appendChild(div);
        });
    })
    .catch(console.error);

function loadChat(friendId) {
    activeFriend = friendId;
    document.getElementById('messages').innerHTML = '';  // Clear messages when a new friend is selected
    fetch(`chat.php?chat_with=${friendId}`)
        .then(response => response.json())
        .then(messages => {
            messages.forEach(msg => appendMessage(`${msg.sender === userId ? 'You' : msg.sender}: ${msg.text}`));
        })
        .catch(console.error);
}

function appendMessage(msg) {
    const messagesDiv = document.getElementById('messages');
    const div = document.createElement('div');
    div.textContent = msg;
    messagesDiv.appendChild(div);
    messagesDiv.scrollTop = messagesDiv.scrollHeight;  // Scroll to the latest message
}

// Send message when the 'Send' button is clicked
document.getElementById('send').onclick = () => {
    const message = document.getElementById('message').value.trim();
    if (message && activeFriend) {
        const msgData = {
            type: 'message',
            sender: userId,
            receiver: activeFriend,
            message: message
        };
        ws.send(JSON.stringify(msgData));  // Send message through WebSocket
        appendMessage(`You: ${message}`);  // Append the message to the chat UI
        document.getElementById('message').value = '';  // Clear the input field
    } else if (!activeFriend) {
        alert("Please select a friend to chat with.");
    } else {
        alert("Message cannot be empty.");
    }
};
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
 var data = google.visualization.arrayToDataTable([
 ['Task', 'Amount'],
 ['Total User', 1385700],
 ['Total Investments', 3060500],
 ['Total Payouts', 8121000]
]);

 // Optional; add a title and set the width and height of the chart
 var options = {'title':'', 'width':550, 'height':400};

 // Display the chart inside the <div> element with id="piechart"
 var chart = new google.visualization.PieChart(document.getElementById('piechart'));
 chart.draw(data, options);
}
</script>

<script>
    // Get the Sidebar
    var mySidebar = document.getElementById("mySidebar");
    
    // Get the DIV with overlay effect
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
    </script>
    
    <script>
        // Accordion
        function myFunction(id) {
          var x = document.getElementById(id);
          if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-theme-d1";
          } else { 
            x.className = x.className.replace("w3-show", "");
            x.previousElementSibling.className = 
            x.previousElementSibling.className.replace(" w3-theme-d1", "");
          }
        }
        
        // Used to toggle the menu on smaller screens when clicking on the menu button
        function openNav() {
          var x = document.getElementById("mySidebar");
          if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
          } else { 
            x.className = x.className.replace(" w3-show", "");
          }
        }
        </script>
    
        <script>
        // Toggle between showing and hiding the sidebar when clicking the menu icon
        var mySidebar = document.getElementById("mySidebar");
        
        function w3_open() {
          if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
          } else {
            mySidebar.style.display = 'block';
          }
        }
        
        // Close the sidebar with the close button
        function w3_close() {
            mySidebar.style.display = "none";
        }
        </script>

<script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', () => handleAction(button.id));
    });

    const myButton = document.getElementById('myBtn');
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            myButton.style.display = 'block';
        } else {
            myButton.style.display = 'none';
        }
    };

    myButton.addEventListener('click', () => {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
});

async function handleAction(taction) {
    const output = document.getElementById('vendorOutput');
    output.innerHTML = '<p>Loading...</p>';
    try {
        const response = await fetch('ftopic_gen.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `taction=${taction}`
        });
        const result = await response.text();
        output.innerHTML = result;
    } catch (error) {
        output.innerHTML = 'Error loading data.';
        console.error('Error:', error);
    }
}

    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'ftopic_gen.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('feed-details').innerHTML = xhr.responseText;
            }
        };
        xhr.send(`action=${action}`);
    }
</script>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
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
</script>

<script>
    // Accordion
    function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
      } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
      }
    }
    
    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
      var x = document.getElementById("mySidebar");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }
    </script>

    <script>
    // Toggle between showing and hiding the sidebar when clicking the menu icon
    var mySidebar = document.getElementById("mySidebar");
    
    function w3_open() {
      if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
      } else {
        mySidebar.style.display = 'block';
      }
    }
    
    // Close the sidebar with the close button
    function w3_close() {
        mySidebar.style.display = "none";
    }
    </script>

<script>
var myIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  myIndex++;
  if (myIndex > x.length) {myIndex = 1}    
  x[myIndex-1].style.display = "block";  
  setTimeout(carousel, 2500);    
}
</script>

<script>
  //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
  mybutton.style.display = "block";
} else {
  mybutton.style.display = "none";
}
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
document.body.scrollTop = 0; // For Safari
document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
if (str.length == 0) {
    document.getElementById("txtHint").innerHTML = "";
    return;
} else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "gethint.php?q=" + str, true);
    xmlhttp.send();
}
}
</script>

<script>
  function myFunction() {
 var x = document.getElementById("psw");
 if (x.type === "password") {
 x.type = "text";
 } else {
 x.type = "password";
 }
}
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
    // Handle form actions dynamically
    function handleAction(action) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'items_gen.php', true); // Point to a PHP script that handles actions
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('vendorOutput').innerHTML = xhr.responseText;
            }
        };
        xhr.send(`action=${action}`);
    }

    function deleteProduct(productId) {
        if (confirm("Are you sure you want to delete this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myProducts'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }

    function removeProduct(productId) {
        if (confirm("Are you sure you want to remove this product?")) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'remove_product.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Refresh the product list dynamically
                    handleAction('myWishlist'); // Reload the product list
                }
            };
            xhr.send(`product_id=${productId}`);
        }
    }
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
function showRSS(str) {
 if (str.length==0) { 
 document.getElementById("rssOutput").innerHTML="";
 return;
 }
 if (window.XMLHttpRequest) {
 // code for IE7+, Firefox, Chrome, Opera, Safari
 xmlhttp=new XMLHttpRequest();
 } else { // code for IE6, IE5
 xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 }
 xmlhttp.onreadystatechange=function() {
 if (this.readyState==4 && this.status==200) {
 document.getElementById("rssOutput").innerHTML=this.responseText;
 }
 }
 xmlhttp.open("GET","get_rss.php?q="+str,true);
 xmlhttp.send();
}
</script>

	<script>
function changeImages(event) {
    const updp = document.getElementById('profile-picture');
			updp.style.display='block';
}


function previewImages(event) {
    const files = event.target.files;
    const previewDiv = document.getElementById('image-preview');
    const upBtn = document.getElementById('uppp');
    const brBtn = document.getElementById('upbr');
    previewDiv.innerHTML = '';

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.marginRight = '10px';
            previewDiv.appendChild(img);
			upBtn.style.display='block';
        };
        reader.readAsDataURL(file);
    });
}
</script>

	  <script>
function previewImagess(event) {
    const files = event.target.files;
    const previewDiv = document.getElementById('image-previews');
    previewDiv.innerHTML = '';

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.marginRight = '10px';
            previewDiv.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}
</script>

<script>
function loadFeed() {
  fetch('getFeedWithAds.php')
    .then(response => response.json())
    .then(feed => {
      const feedContainer = document.getElementById('feedContainer');
      const adRow = document.getElementById('adRow');

      feedContainer.innerHTML = '';
      adRow.innerHTML = '';

      feed.forEach(item => {
        if (item.type === 'post') {
          // Render post
          const postDiv = document.createElement('div');
          postDiv.classList.add('feed-item');
          postDiv.textContent = item.data.content;
          feedContainer.appendChild(postDiv);
        } else if (item.type === 'ad') {
          // Render ad
          const adItem = document.createElement('div');
          adItem.classList.add('ad-item');

          const adTitle = document.createElement('h4');
          adTitle.textContent = item.data.title;

          const adImage = document.createElement('img');
          adImage.src = item.data.image_path;
          adImage.alt = item.data.title;

          adItem.appendChild(adImage);
          adItem.appendChild(adTitle);
          adRow.appendChild(adItem);
        }
      });

      startAutoScroll(); // Start scrolling ads
    })
    .catch(error => console.error('Error:', error));
}

// Function to enable auto-scrolling for the ad row
function startAutoScroll() {
  const adRow = document.getElementById('adRow');
  let scrollAmount = 0;

  function scrollAds() {
    scrollAmount += 1;
    adRow.scrollLeft = scrollAmount;

    if (scrollAmount >= adRow.scrollWidth - adRow.clientWidth) {
      scrollAmount = 0; // Reset scrolling
    }

    requestAnimationFrame(scrollAds);
  }

  scrollAds();
}

const adRow = document.getElementById('adRow');

adRow.addEventListener('mouseover', () => cancelAnimationFrame(scrollAds));
adRow.addEventListener('mouseout', () => scrollAds());

// Load feed and ads on page load
document.addEventListener('DOMContentLoaded', loadFeed);
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Function to delete a post
  document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      const post = this.closest('.post');
      const postId = post.getAttribute('data-post-id');

      fetch(`deletePost.php?id=${postId}`, { method: 'DELETE' })
        .then(response => {
          if (!response.ok) throw new Error('Failed to delete post');
          return response.text();
        })
        .then(() => {
          post.remove(); // Remove the post from the DOM
          alert('Post deleted successfully!');
        })
        .catch(error => console.error('Error:', error));
    });
  });
  });
</script>

<script>
function likePost(postId) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'like.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.status === 200) {
            const response = this.responseText.trim();
            if (response === 'Like added') {
                // Update the like count and button text
                let likeCount = document.getElementById('likeCount' + postId);
                likeCount.innerHTML = parseInt(likeCount.innerHTML) + 1; // Increment like count
                document.getElementById('likeLabel' + postId).classList.add('liked'); // Mark as liked
            } else if (response === 'Like removed') {
                let likeCount = document.getElementById('likeCount' + postId);
                likeCount.innerHTML = parseInt(likeCount.innerHTML) - 1; // Decrement like count
                document.getElementById('likeLabel' + postId).classList.remove('liked'); // Mark as unliked
            }
        }
    };
    xhr.send('postid=' + postId);
}
</script>

//stopped copy for mypage.php

<script>
  // Get the Sidebar
  var mySidebar = document.getElementById("mySidebar");
  
  // Get the DIV with overlay effect
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
  </script>
  
  <script>
      // Accordion
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-theme-d1";
        } else { 
          x.className = x.className.replace("w3-show", "");
          x.previousElementSibling.className = 
          x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
      }
      
      // Used to toggle the menu on smaller screens when clicking on the menu button
      function openNav() {
        var x = document.getElementById("mySidebar");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else { 
          x.className = x.className.replace(" w3-show", "");
        }
      }
      </script>
  
      <script>
      // Toggle between showing and hiding the sidebar when clicking the menu icon
      var mySidebar = document.getElementById("mySidebar");
      
      function w3_open() {
        if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
        } else {
          mySidebar.style.display = 'block';
        }
      }
      
      // Close the sidebar with the close button
      function w3_close() {
          mySidebar.style.display = "none";
      }
      </script>

<script>
  var myIndex = 0;
  carousel();
  
  function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2500);    
  }
  </script>

  <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}



document.addEventListener('DOMContentLoaded', function () {
    const wishlistButtons = document.querySelectorAll('.save-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            // Create an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'wishlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Display success or error message
                    if (response.status === 'success') {
                        alert(response.message); // Optionally, use a better UI for notifications
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };

            xhr.send(`product_id=${productId}`);
        });
    });
});
</script>

		<script>
function processPayment(packageName) {
    fetch(`issue_at.php?package=${packageName}`)
        .then(response => {
            if (response.ok) {
                window.location.href = `issue_at.php?package=${packageName}`;
            } else {
                alert("Payment processing failed. Please try again.");
            }
        })
        .catch(error => {
            console.error("Payment error:", error);
            alert("An unexpected error occurred.");
        });
    return false; // Prevent default link behavior
}

</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>


    <script>
        function previewImage(event) {
            const image = document.getElementById('image-preview');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
	
	<script>
function previewImages(event) {
    const files = event.target.files;
    const previewDiv = document.getElementById('image-preview');
    previewDiv.innerHTML = '';

    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px';
            img.style.marginRight = '10px';
            previewDiv.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
    function showDescription(id) {
        const description = document.getElementById('description-' + id);
        description.style.display = description.style.display === 'block' ? 'none' : 'block';
    }
</script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const stars = document.querySelectorAll("#rating-container .fa");
                const highestRatingDisplay = document.getElementById("highest-rating");
                let currentRating = 0;

                // Fetch existing rating for the session user
                fetch('/get-rating') // Backend API to fetch rating
                    .then(response => response.json())
                    .then(data => {
                        currentRating = data.rating || 0;
                        highlightStars(currentRating);
                        highestRatingDisplay.textContent = `Highest Rating: ${currentRating}`;
                    });

                stars.forEach(star => {
                    // Mouseover to highlight stars
                    star.addEventListener("mouseover", () => {
                        const rating = star.getAttribute("data-value");
                        highlightStars(rating);
                    });

                    // Mouseout to reset stars
                    star.addEventListener("mouseout", () => {
                        highlightStars(currentRating);
                    });

                    // Click to set rating
                    star.addEventListener("click", () => {
                        currentRating = star.getAttribute("data-value");
                        highlightStars(currentRating);
                        highestRatingDisplay.textContent = `Rating: ${currentRating} star`;

                        // Save the rating to the database
                        fetch('/save-rating', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ rating: currentRating }),
                        }).then(response => {
                            if (!response.ok) {
                                console.error('Error saving rating');
                            }
                        });
                    });
                });

                function highlightStars(rating) {
                    stars.forEach(star => {
                        const value = star.getAttribute("data-value");
                        if (value <= rating) {
                            star.classList.remove("fa-star-o");
                            star.classList.add("fa-star");
                        } else {
                            star.classList.remove("fa-star");
                            star.classList.add("fa-star-o");
                        }
                    });
                }
            });
        </script>
		
		    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}


document.addEventListener('DOMContentLoaded', function () {
    const wishlistButtons = document.querySelectorAll('.save-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            // Create an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'wishlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Display success or error message
                    if (response.status === 'success') {
                        alert(response.message); // Optionally, use a better UI for notifications
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };

            xhr.send(`product_id=${productId}`);
        });
    });
});
</script>

<script>
    function showDescription(id) {
        const description = document.getElementById('description-' + id);
        description.style.display = description.style.display === 'block' ? 'none' : 'block';
    }
</script>

    <script>
	function redirectToLogin() {
    alert('Please login to save items to your wishlist.');
    window.location.href = 'index.php';
}

    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}

document.addEventListener('DOMContentLoaded', function () {
    const wishlistButtons = document.querySelectorAll('.save-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            // Create an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'wishlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Display success or error message
                    if (response.status === 'success') {
                        alert(response.message); // Optionally, use a better UI for notifications
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };

            xhr.send(`product_id=${productId}`);
        });
    });
});

</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script> $(document).ready(function(){
  $("#password").pwdMeter();
});
</script>

<script>
  // Get the Sidebar
  var mySidebar = document.getElementById("mySidebar");
  
  // Get the DIV with overlay effect
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
  </script>
  
  <script>
      // Accordion
      function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
          x.previousElementSibling.className += " w3-theme-d1";
        } else { 
          x.className = x.className.replace("w3-show", "");
          x.previousElementSibling.className = 
          x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
      }
      
      // Used to toggle the menu on smaller screens when clicking on the menu button
      function openNav() {
        var x = document.getElementById("mySidebar");
        if (x.className.indexOf("w3-show") == -1) {
          x.className += " w3-show";
        } else { 
          x.className = x.className.replace(" w3-show", "");
        }
      }
      </script>
  
      <script>
      // Toggle between showing and hiding the sidebar when clicking the menu icon
      var mySidebar = document.getElementById("mySidebar");
      
      function w3_open() {
        if (mySidebar.style.display === 'block') {
          mySidebar.style.display = 'none';
        } else {
          mySidebar.style.display = 'block';
        }
      }
      
      // Close the sidebar with the close button
      function w3_close() {
          mySidebar.style.display = "none";
      }
      </script>

<script>
  var myIndex = 0;
  carousel();
  
  function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
      x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 2500);    
  }
  </script>

  <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
  function mypwdFunction() {
 var x = document.getElementById("pwd");
 if (x.type === "password") {
 x.type = "text";
 } else {
 x.type = "password";
 }
}
</script>

<script>
var pwd = document.getElementById("pwd");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
pwd.onfocus = function() {
 document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
pwd.onblur = function() {
 document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
pwd.onkeyup = function() {
 // Validate lowercase letters
 var lowerCaseLetters = /[a-z]/g;
 if(psw.value.match(lowerCaseLetters)) { 
 letter.classList.remove("invalid");
 letter.classList.add("valid");
 } else {
 letter.classList.remove("valid");
 letter.classList.add("invalid");
}

 // Validate capital letters
 var upperCaseLetters = /[A-Z]/g;
 if(pwd.value.match(upperCaseLetters)) { 
 capital.classList.remove("invalid");
 capital.classList.add("valid");
 } else {
 capital.classList.remove("valid");
 capital.classList.add("invalid");
 }

 // Validate numbers
 var numbers = /[0-9]/g;
 if(pwd.value.match(numbers)) { 
 number.classList.remove("invalid");
 number.classList.add("valid");
 } else {
 number.classList.remove("valid");
 number.classList.add("invalid");
 }

 // Validate length
 if(pwd.value.length >= 8) {
 length.classList.remove("invalid");
 length.classList.add("valid");
} else {
length.classList.remove("valid");
length.classList.add("invalid");
}
}
</script>

<script>
  function myconpwdFunction() {
var x = document.getElementById("con_pwd");
if (x.type === "password") {
x.type = "text";
} else {
x.type = "password";
}
}
</script>

<script>
var con_pwd = document.getElementById("con_pwd");
var letter = document.getElementById("letter");
var capital = document.getElementById("capital");
var number = document.getElementById("number");
var length = document.getElementById("length");

// When the user clicks on the password field, show the message box
con_pwd.onfocus = function() {
document.getElementById("message").style.display = "block";
}

// When the user clicks outside of the password field, hide the message box
con_pwd.onblur = function() {
document.getElementById("message").style.display = "none";
}

// When the user starts to type something inside the password field
con_pwd.onkeyup = function() {
// Validate lowercase letters
var lowerCaseLetters = /[a-z]/g;
if(con_pwd.value.match(lowerCaseLetters)) { 
letter.classList.remove("invalid");
letter.classList.add("valid");
} else {
letter.classList.remove("valid");
letter.classList.add("invalid");
}

// Validate capital letters
var upperCaseLetters = /[A-Z]/g;
if(con_pwd.value.match(upperCaseLetters)) { 
 capital.classList.remove("invalid");
 capital.classList.add("valid");
 } else {
 capital.classList.remove("valid");
 capital.classList.add("invalid");
 }

 // Validate numbers
 var numbers = /[0-9]/g;
 if(con_pwd.value.match(numbers)) { 
 number.classList.remove("invalid");
 number.classList.add("valid");
 } else {
 number.classList.remove("valid");
 number.classList.add("invalid");
 }

 // Validate length
 if(con_pwd.value.length >= 8) {
 length.classList.remove("invalid");
 length.classList.add("valid");
 } else {
 length.classList.remove("valid");
 length.classList.add("invalid");
 }
}
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}
</script>

<script>
    function showDescription(id) {
        const description = document.getElementById('description-' + id);
        description.style.display = description.style.display === 'block' ? 'none' : 'block';
    }
</script>

    <script>
    //Get the button:
mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 


//get hint code

function showHint(str) {
  if (str.length == 0) {
      document.getElementById("txtHint").innerHTML = "";
      return;
  } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
              document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
          }
      };
      xmlhttp.open("GET", "gethint.php?q=" + str, true);
      xmlhttp.send();
  }
}


document.addEventListener('DOMContentLoaded', function () {
    const wishlistButtons = document.querySelectorAll('.save-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-product-id');

            // Create an AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'wishlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);

                    // Display success or error message
                    if (response.status === 'success') {
                        alert(response.message); // Optionally, use a better UI for notifications
                    } else {
                        alert(response.message);
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            };

            xhr.send(`product_id=${productId}`);
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
        button.addEventListener('click', () => handleAction(button.id));
    });

    const myButton = document.getElementById('myBtn');
    window.onscroll = function () {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            myButton.style.display = 'block';
        } else {
            myButton.style.display = 'none';
        }
    };

    myButton.addEventListener('click', () => {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    });
});

async function handleAction(action) {
    const output = document.getElementById('vendorOutput');
    output.innerHTML = '<p>Loading...</p>';
    try {
        const response = await fetch('forum_gen.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `action=${action}`
        });
        const result = await response.text();
        output.innerHTML = result;
    } catch (error) {
        output.innerHTML = 'Error loading data.';
        console.error('Error:', error);
    }
}
</script>