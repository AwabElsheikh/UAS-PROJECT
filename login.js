// Get references to the form and message box elements
const loginForm = document.getElementById('loginForm');
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
loginForm.addEventListener('submit', function(event) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;

    // Basic client-side validation
    if (email === '' || password === '') {
        showMessage('Email and password are required!');
        event.preventDefault(); // Prevent submission if validation fails
        return;
    }

    // No event.preventDefault() here if you want the form to submit to PHP naturally.
    // The PHP script (login.php) will handle authentication and redirection.
});

// Display messages based on URL parameters (from PHP redirects)
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'registration_success') {
        showMessage('Registration successful! Please login.', 'success');
        // Clear the URL parameter to avoid showing the message on refresh
        history.replaceState(null, '', window.location.pathname);
    } else if (status === 'password_incorrect') {
        showMessage('Incorrect password.', 'error');
        history.replaceState(null, '', window.location.pathname);
    } else if (status === 'email_not_found') {
        showMessage('No account found with that email.', 'error');
        history.replaceState(null, '', window.location.pathname);
    } else if (status === 'login_failed') {
        showMessage('Login failed. Please try again.', 'error');
        history.replaceState(null, '', window.location.pathname);
    }
};
