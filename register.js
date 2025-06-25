// Get references to the form and message box elements
const registerForm = document.getElementById('registerForm');
const messageBox = document.getElementById('messageBox');
const messageText = document.getElementById('messageText');

// Function to display messages in the custom message box
function showMessage(message, type = 'error') {
    messageText.textContent = message;
    messageBox.classList.remove('success', 'error'); // Remove previous types
    messageBox.classList.add(type); // Add the current type
    messageBox.classList.add('show'); // Make it visible

    // Hide the message after 3 seconds
    setTimeout(() => {
        messageBox.classList.remove('show');
    }, 3000);
}

// Add an event listener for the form submission
registerForm.addEventListener('submit', function(event) {
    // *** IMPORTANT CHANGE: Removed event.preventDefault() here ***
    // This allows the form to submit to register.php

    // Get input values
    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    // Basic client-side validation
    if (name === '' || email === '' || password === '' || confirmPassword === '') {
        showMessage('All fields are required!');
        event.preventDefault(); // Prevent submission if client-side validation fails
        return; // Stop execution if any field is empty
    }

    if (password.length < 6) {
        showMessage('Password must be at least 6 characters long.');
        event.preventDefault(); // Prevent submission if client-side validation fails
        return;
    }

    if (password !== confirmPassword) {
        showMessage('Passwords do not match!');
        event.preventDefault(); // Prevent submission if client-side validation fails
        return;
    }

    // If client-side validation passes, the form will now submit to register.php
    // The PHP script will then handle the database insertion and redirection.
    // No need for client-side success message or redirection here.
});

// Display messages based on URL parameters (from PHP redirects)
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'registration_failed') {
        showMessage('Registration failed. Please try again.', 'error');
        // Clear the URL parameter to avoid showing the message on refresh
        history.replaceState(null, '', window.location.pathname);
    }
};
