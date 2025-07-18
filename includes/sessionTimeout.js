// Set the timeout period (in milliseconds)
const timeoutPeriod = 5 * 60 * 1000; // 5 minutes

let timeout;

// Reset the timeout timer on user activity
function resetTimer() {
    clearTimeout(timeout);
    timeout = setTimeout(logout, timeoutPeriod); // Set new timeout after inactivity
}

// Function to log out the user
function logout() {
    alert("You have been logged out due to inactivity.");
    window.location.href = "/connect/logout.php"; // Redirect to logout endpoint or handle session termination here
}

// Listen for user activity events
document.addEventListener('mousemove', resetTimer);
document.addEventListener('keydown', resetTimer);

// Initialize the timer when the page loads
window.onload = resetTimer;