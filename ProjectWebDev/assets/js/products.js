// products.js

// Dark Mode Toggle
function setupDarkModeToggle() {
    const darkModeBtn = document.getElementById("dark-mode-btn");

    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        document.querySelector("header").classList.toggle("dark-mode");
        document.querySelector("footer").classList.toggle("dark-mode");
    });
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