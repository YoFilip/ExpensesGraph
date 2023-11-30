<?php
    session_start();
    session_unset();

    echo "<script>localStorage.removeItem('loggedIn');</script>";
    header('Location: index.html');
?>
