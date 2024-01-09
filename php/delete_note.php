<?php
// Include database connection details
require_once "connect.php";

// Start the session
session_start();

// Create a new database connection or display an error message if unsuccessful
$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Database connection error:".$conn->errno);

// Get the note ID from the form
$note_id = $_POST['btn'];

// Query to delete the note with the specified ID and user ID
$query = "DELETE FROM notepad WHERE id = '$note_id' AND user_id = " . $_SESSION['id'];

// Execute the delete query
$res = $conn->query($query);

// Check if the deletion was successful
if ($res) {
    // Redirect the user to the notepad page on success
    header("location: ../sites/notepad.php");
} else {
    // Display an error message on failure
    echo "An error occurred while deleting the note: " . $res->errno;
    echo "<a href='../sites/notepad.php'>Return to the notepad page</a>";
}

// Update the IDs of the notes with IDs greater than the deleted note
$query = "UPDATE notepad SET id = id - 1 WHERE id > '$note_id'";
$conn->query($query);

// Set the AUTO_INCREMENT value for the table to the last note ID
$queryHelp = $note_id - 1;
$query = "ALTER TABLE notepad AUTO_INCREMENT = $queryHelp";
$conn->query($query);

?>
