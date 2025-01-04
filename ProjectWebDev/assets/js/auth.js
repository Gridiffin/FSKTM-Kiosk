// Function to check login status
function checkLoginStatus() {
    const email = sessionStorage.getItem('email'); // Get email from sessionStorage
    const loginLink = document.getElementById('login-link');
    const registerLink = document.querySelector('.nav-link[href="./registration.html"]'); // Select the Register link

    if (email) {
        // User is logged in
        loginLink.textContent = 'Profile'; // Change "Login" to "Profile"
        loginLink.href = 'profile.html?email=' + encodeURIComponent(email);

        // Hide the Register button
        if (registerLink) {
            registerLink.style.display = 'none';
        }
    } else {
        // User is not logged in
        loginLink.textContent = 'Login'; // Keep "Login" as is
        loginLink.href = 'login.html'; // Set the link to the login page

        // Show the Register button
        if (registerLink) {
            registerLink.style.display = 'inline'; // or 'block' depending on your CSS
        }
    }
}

// Run the check when the page loads
document.addEventListener('DOMContentLoaded', checkLoginStatus);