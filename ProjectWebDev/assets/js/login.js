// login.js

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