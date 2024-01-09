<?php
// Start the session
session_start();

// Include database connection details
require_once "connect.php";

// Create a new database connection or display an error message if unsuccessful
$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Database connection error: " . $conn->errno);

// Retrieve data from the form
$content = $_POST['content'];
$title = $_POST['title'];

// Build the SQL query to insert the note into the database
$query = "INSERT INTO notepad(user_id, content, title, date) VALUES(" . $_SESSION['id'] . ", '$content', '$title', '" . date("Y-m-d") . "')";

// Execute the query
$res = $conn->query($query);

// Check if the query was successful
if ($res) {
    // Redirect the user to the notepad page on success
    header("location: ../sites/notepad.php");
} else {
    // Display an error message on failure
    echo "An error occurred while adding the note to the database: " . $res->errno;
    echo "<a href='../sites/notepad.php'>Return to the notepad page</a>";
}

// Close the database connection
$conn->close();
?>
