// Dynamic Greeting Based on Time of Day
function setDynamicGreeting() {
    const greetingElement = document.getElementById("dynamic-greeting");
    if (greetingElement) {
        const now = new Date();
        const hours = now.getHours();

        let greeting;
        if (hours < 12) {
            greeting = "Good Morning!";
        } else if (hours < 18) {
            greeting = "Good Afternoon!";
        } else {
            greeting = "Good Evening!";
        }

        // Only set the greeting (e.g., "Good Morning!") without appending additional text
        greetingElement.textContent = greeting;
    } else {
        console.error('Element with ID "dynamic-greeting" not found.');
    }
}

// Smooth Scrolling for Internal Links
function enableSmoothScrolling() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
}

// Dark Mode Toggle
function setupDarkModeToggle() {
    const darkModeBtn = document.getElementById("dark-mode-btn");
    const darkModeIcon = document.getElementById("dark-mode-icon");

    darkModeBtn.addEventListener("click", () => {
        const isDarkMode = document.body.classList.toggle("dark-mode");
        document.querySelector("header").classList.toggle("dark-mode");
        document.querySelector("footer").classList.toggle("dark-mode");
        document.querySelector("#hero").classList.toggle("dark-mode");
        document.querySelector("#products").classList.toggle("dark-mode");
        document.querySelector("#testimonials").classList.toggle("dark-mode");

        // Toggle between sun and moon icons
        if (isDarkMode) {
            darkModeIcon.classList.remove("fa-moon");
            darkModeIcon.classList.add("fa-sun");
        } else {
            darkModeIcon.classList.remove("fa-sun");
            darkModeIcon.classList.add("fa-moon");
        }
    });
}

// Initialize Functions
document.addEventListener("DOMContentLoaded", () => {
    setDynamicGreeting();
    enableSmoothScrolling();
    setupDarkModeToggle();
});