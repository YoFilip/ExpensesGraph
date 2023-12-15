<?php
require_once "connect.php";
$connection = new mysqli($host, $db_user, $db_password, $db_name);

if (isset($_POST['id'])) {
    $id = $connection->real_escape_string($_POST['id']);
    $sql = "DELETE FROM expenses WHERE id = '$id'";
    $result = $connection->query($sql);
}
?>
