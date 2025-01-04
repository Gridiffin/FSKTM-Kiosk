// login.js

// Dark Mode Toggle (consistent with index.html)
function setupDarkModeToggle() {
    const darkModeBtn = document.getElementById("dark-mode-btn");

    darkModeBtn.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        document.querySelector("header").classList.toggle("dark-mode");
        document.querySelector("footer").classList.toggle("dark-mode");
    });
}

// Input Field Focus Effects
function setupInputFocusEffects() {
    const inputs = document.querySelectorAll("input[type='email'], input[type='password']");

    inputs.forEach(input => {
        input.addEventListener("focus", () => {
            input.style.borderColor = "#8a7faf"; // Light purple
            input.style.boxShadow = "0 0 5px rgba(138, 127, 175, 0.5)";
        });

        input.addEventListener("blur", () => {
            input.style.borderColor = "#ccc";
            input.style.boxShadow = "none";
        });
    });
}

// Initialize Functions
document.addEventListener("DOMContentLoaded", () => {
    setupDarkModeToggle();
    setupInputFocusEffects();
});