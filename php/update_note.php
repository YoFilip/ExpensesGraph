<?php
    require_once "connect.php";

    session_start();

    $conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Błąd z połączeniem: ".$conn->errno);

    $note_id = $_POST['btnId'];
    $content = $_POST['content'];
    $title = $_POST['title'];

    $query = "UPDATE notepad SET content ='$content', title = '$title' WHERE id = '$note_id'";

    $res = $conn->query($query);

    if($res){
        header("location: ../sites/notepad.php");
    }else{
        echo "Wystąpił błąd ze zmianą notatki: ". $res->errno;
        echo "<a href='../sites/notepad.php'>Wróć do strony z notatkami</a>";
    }


?>