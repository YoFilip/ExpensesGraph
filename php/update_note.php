<?php
// Include database connection details
require_once "connect.php";

// Start the session
session_start();

// Create a new database connection or display an error message if unsuccessful
$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Database connection error: ".$conn->errno);

// Retrieve data from the POST request
$note_id = $_POST['btnId'];
$content = $_POST['content'];
$title = $_POST['title'];

// Prepare and execute the SQL query to update the notepad record
$query = "UPDATE notepad SET content ='$content', title = '$title' WHERE id = '$note_id'";
$res = $conn->query($query);

// Check if the update was successful
if ($res) {
    // Redirect to the notepad page on success
    header("location: ../sites/notepad.php");
} else {
    // Display an error message on failure
    echo "An error occurred while updating the note: " . $res->errno;
    echo "<a href='../sites/notepad.php'>Return to the notepad page</a>";
}

// Close the database connection
$conn->close();
?>
