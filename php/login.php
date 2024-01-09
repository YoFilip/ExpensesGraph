<?php
// Start the session
session_start();

// Check if email and password are set in the POST request
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    // Redirect to the login page if not set
    header('Location: ../sites/login_page.php');
    exit();
}

// Include database connection details
require_once "connect.php";

// Create a new database connection
$connection = new mysqli($host, $db_user, $db_password, $db_name);

// Check for database connection errors
if ($connection->connect_errno != 0) {
    echo "Error: " . $connection->connect_errno;
} else {
    // Sanitize and retrieve email and password from the POST request
    $email = htmlentities($_POST['email'], ENT_QUOTES, "UTF-8");
    $password = $_POST['password'];

    // Prepare and execute a SQL query to retrieve user information based on the email
    $stmt = $connection->prepare("SELECT id, user, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if there is a matching user
    if ($stmt->num_rows > 0) {
        // Bind the results to variables
        $stmt->bind_result($id, $username, $hashed_password);
        $stmt->fetch();

        // Verify the entered password with the hashed password in the database
        if (password_verify($password, $hashed_password)) {
            // Set session variables for the authenticated user
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['user'] = $username;

            // Unset any previous error session variable
            unset($_SESSION['error']);

            // Close the prepared statement and database connection
            $stmt->close();
            $connection->close();

            // Redirect to the dashboard on successful login
            header('Location: ../sites/dashboard.php');
        } else {
            // Set an error session variable for invalid email or password
            $_SESSION['error'] = 'Invalid email or password!';
            // Redirect to the login page
            header('Location: ../sites/login_page.php');
        }
    } else {
        // Set an error session variable for invalid email or password
        $_SESSION['error'] = 'Invalid email or password!';
        // Redirect to the login page
        header('Location: ../sites/login_page.php');
    }
}
?>
