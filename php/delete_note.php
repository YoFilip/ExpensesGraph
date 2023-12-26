<?php
require_once "connect.php";

session_start();

$conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Błąd połączenia z bazą:".$conn->errno);

$note_id = $_POST['btn'];

$query = "DELETE FROM notepad WHERE id = '$note_id' AND user_id = ".$_SESSION['id'];

$res = $conn->query($query);

if($res){
    header("location: ../sites/notepad.php");
}else{
    echo "Wystąpił błąd z usunięciem notatki: ". $res->errno;
    echo "<a href='../sites/notepad.php'>Wróć do strony z notatkami</a>";
}

?>

