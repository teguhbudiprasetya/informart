<?php 
    session_start();
    include "config.php";

    $userID = $_SESSION['iduser'];
    $date = date('Y-m-d');

    $sql = "SELECT ";

?>