<?php
session_start();
if (isset($_SESSION['id'])) {
    unset($_SESSION["id"]);
    unset($_SESSION["name"]);
    session_destroy();
    header("Location: index.php");
}
?>