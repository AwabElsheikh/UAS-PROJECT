<?php
// Enable detailed error reporting for debugging (can be removed in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start a session to manage user login state
session_start();

// Include database configuration file
// This file (db_config.php) should contain your database connection details
// and should NOT have session_start() within it.
require_once 'db_config.php';

// Initialize variables to store form data and error messages
$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";

// Process form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Validate Name ---
    // Use isset() to check if the array key exists before accessing it
    if (!isset($_POST["name"]) || empty(trim($_POST["name"]))) {
        $name_err = "Please enter your name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // --- Validate Email ---
    if (!isset($_POST["email"]) || empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Invalid email format.";
    } else {
        // Prepare a select statement to check if email already exists
        $sql = "SELECT id FROM users WHERE email = ?";

        // Ensure $conn is a valid mysqli object before calling prepare
        if ($conn instanceof mysqli && $stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $email_err = "This email is already registered.";
                } else {
                    $email = trim($_POST["email"]);
                }
            } else {
                // Error executing email check, redirect with failure status
                header("location: register.html?status=registration_failed");
                exit();
            }

            // Close statement
            $stmt->close();
        } else {
            // Error preparing email check, redirect with failure status
            header("location: register.html?status=registration_failed");
            exit();
        }
    }

    // --- Validate Password ---
    if (!isset($_POST["password"]) || empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // --- Validate Confirm Password ---
    // Use isset() to check if the array key exists before accessing it
    if (!isset($_POST["confirmPassword"]) || empty(trim($_POST["confirmPassword"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirmPassword"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Passwords did not match.";
        }
    }

    // Check input errors before inserting into database
    if (empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        // Ensure $conn is valid before trying to prepare statement
        if ($conn instanceof mysqli && $stmt = $conn->prepare($sql)) {
            // Bind parameters
            $stmt->bind_param("sss", $param_name, $param_email, $param_password);

            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Registration successful, redirect to login page
                header("location: login.html?status=registration_success"); // RE-ENABLED
                exit(); // RE-ENABLED
            } else {
                // Error inserting data, redirect with failure status
                header("location: register.html?status=registration_failed"); // RE-ENABLED
                exit(); // RE-ENABLED
            }

            // Close statement
            $stmt->close();
        } else {
            // Error preparing insert statement, redirect with failure status
            header("location: register.html?status=registration_failed"); // RE-ENABLED
            exit(); // RE-ENABLED
        }
    } else {
        // Validation errors present, redirect with failure status
        header("location: register.html?status=registration_failed"); // RE-ENABLED
        exit(); // RE-ENABLED
    }
} else {
    // Form not submitted via POST or initial page load.
    // If you want to show a message for direct access, you can add it here.
}

// Close connection if it's a valid object
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
?>
