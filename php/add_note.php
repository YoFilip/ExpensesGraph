<?php
    session_start();

    require_once "connect.php";


    $conn = new mysqli($host, $db_user, $db_password, $db_name) or die("Błąd połaczenia z bazą: ". $conn->errno);

    $content = $_POST['content'];
    $title = $_POST['title'];

    $query = "INSERT INTO notepad(user_id, content, title, date) VALUES(".$_SESSION['id'].", '$content', '$title', '". date("Y-m-d") ."')";

    $res = $conn->query($query);

    if($res){
        header("location: ../sites/notepad.php");
    }else{
        echo "Wystąpił błąd z dodaniem notatki do bazy: ". $res->errno;
        echo "<a href='note_pad.php'>Wróć do strony z notatkami</a>";
    }

?>