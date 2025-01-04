// checkout.js

document.addEventListener("DOMContentLoaded", () => {
    // Dark Mode Toggle
    const darkModeBtn = document.getElementById("dark-mode-btn");
    if (darkModeBtn) {
        darkModeBtn.addEventListener("click", () => {
            document.body.classList.toggle("dark-mode");
            // Save dark mode preference to localStorage
            const isDarkMode = document.body.classList.contains("dark-mode");
            localStorage.setItem("dark-mode", isDarkMode);
        });

        // Apply dark mode if previously enabled
        const isDarkMode = localStorage.getItem("dark-mode") === "true";
        if (isDarkMode) {
            document.body.classList.add("dark-mode");
        }
    }

    // Populate receipt with cart items and total
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    const total = localStorage.getItem("total") || "0.00";

    const purchasedItemsList = document.getElementById("purchased-items");
    if (purchasedItemsList) {
        cart.forEach(item => {
            const li = document.createElement("li");
            li.textContent = `${item.name} - RM${item.price.toFixed(2)}`;
            purchasedItemsList.appendChild(li);
        });

        const totalValue = document.getElementById("total-value");
        if (totalValue) {
            totalValue.textContent = `RM${total}`;
        }
    }

    // Payment Confirmation Modal
    const confirmPaymentBtn = document.querySelector(".btn-login");
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener("click", (e) => {
            e.preventDefault(); // Prevent form submission

            // Check if a payment method is selected
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!paymentMethod) {
                alert("Please select a payment method.");
                return;
            }

            // Show confirmation modal
            const modal = document.createElement("div");
            modal.classList.add("confirmation-modal");
            modal.innerHTML = `
                <div class="modal-content">
                    <h3>Confirm Payment</h3>
                    <p>Are you sure you want to proceed with the payment?</p>
                    <div class="modal-actions">
                        <button id="modal-cancel">Cancel</button>
                        <button id="modal-confirm">Confirm</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);

            // Handle modal actions
            const modalCancel = document.getElementById("modal-cancel");
            const modalConfirm = document.getElementById("modal-confirm");

            modalCancel.addEventListener("click", () => {
                document.body.removeChild(modal);
            });

            modalConfirm.addEventListener("click", () => {
                // Submit the form
                document.querySelector("form").submit();
            });
        });
    }

    // Add hover effects to payment options
    const paymentOptions = document.querySelectorAll(".payment-option");
    paymentOptions.forEach(option => {
        option.addEventListener("mouseenter", () => {
            option.style.transform = "scale(1.02)";
            option.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
        });

        option.addEventListener("mouseleave", () => {
            option.style.transform = "scale(1)";
            option.style.boxShadow = "none";
        });
    });
});