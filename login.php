<?php
// Enable basic error reporting (can be adjusted or removed in production)
ini_set('display_errors', 0); // Changed to 0 to not display errors on screen
ini_set('display_startup_errors', 0); // Changed to 0
error_reporting(E_ALL);

// Start a session to manage user login state
session_start();

// Check if the user is already logged in, if yes then redirect to dashboard
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: dashboard.php");
    exit;
}

// Include database configuration file
require_once 'db_config.php';

// Initialize variables to store form data and error messages
$email = $password = "";
$email_err = $password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter your email.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check for input errors before authenticating
    if (empty($email_err) && empty($password_err)) {

        // Prepare a select statement
        $sql = "SELECT id, name, email, password FROM users WHERE email = ?";

        if ($conn instanceof mysqli && $stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if email exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $name, $email_from_db, $hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, start a new session
                            session_regenerate_id();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["name"] = $name;
                            $_SESSION["email"] = $email_from_db;

                            // Redirect user to dashboard page
                            header("location: dashboard.php?status=login_success");
                            exit();
                        } else {
                            // Password is not valid
                            $password_err = "The password you entered was not valid.";
                            header("location: login.html?status=password_incorrect");
                            exit();
                        }
                    }
                } else {
                    // Email doesn't exist
                    $email_err = "No account found with that email.";
                    header("location: login.html?status=email_not_found");
                    exit();
                }
            } else {
                header("location: login.html?status=login_failed");
                exit();
            }

            // Close statement
            $stmt->close();
        } else {
            header("location: login.html?status=login_failed");
            exit();
        }
    } else {
        header("location: login.html?status=login_failed");
        exit();
    }
} else {
    // Form not submitted via POST or initial page load
}

// Close connection if it's a valid object
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
