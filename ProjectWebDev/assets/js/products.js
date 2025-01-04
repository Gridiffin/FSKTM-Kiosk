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

// Initialize Functions
document.addEventListener("DOMContentLoaded", () => {
    setupDarkModeToggle();
});