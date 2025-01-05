// products.js

// Dark Mode Toggle
const darkModeBtn = document.getElementById("dark-mode-btn");
const darkModeIcon = document.getElementById("dark-mode-icon");

if (darkModeBtn) {
    darkModeBtn.addEventListener("click", () => {
        const isDarkMode = !document.body.classList.contains("dark-mode");
        document.body.classList.toggle("dark-mode", isDarkMode);
        document.querySelector("header").classList.toggle("dark-mode", isDarkMode);
        document.querySelector("footer").classList.toggle("dark-mode", isDarkMode);

        // Toggle between sun and moon icons
        darkModeIcon.classList.toggle("fa-moon", !isDarkMode);
        darkModeIcon.classList.toggle("fa-sun", isDarkMode);

        // Save dark mode preference to localStorage
        localStorage.setItem("dark-mode", isDarkMode);
    });

    // Apply dark mode on page load
    const isDarkMode = localStorage.getItem("dark-mode") === "true";
    if (isDarkMode) {
        document.body.classList.add("dark-mode");
        document.querySelector("header").classList.add("dark-mode");
        document.querySelector("footer").classList.add("dark-mode");
        darkModeIcon.classList.remove("fa-moon");
        darkModeIcon.classList.add("fa-sun");
    }
}
// Handle checkout button click
function handleCheckout() {
    // Check if the user is logged in by checking the session
    fetch('/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedIn) {
                // User is logged in, redirect to checkout.html
                window.location.href = './checkout.html';
            } else {
                // User is not logged in, redirect to registration.html
                window.location.href = './registration.html';
            }
        })
        .catch(error => {
            console.error('Error checking session:', error);
            alert('An error occurred. Please try again.');
        });
}

// Initialize Functions
document.addEventListener("DOMContentLoaded", () => {
    setupDarkModeToggle();

    // Add event listener to the checkout button
    const checkoutButton = document.getElementById("checkout-button");
    if (checkoutButton) {
        checkoutButton.addEventListener("click", handleCheckout);
    }
});