<?php 
session_start();
if(isset($_SESSION['idadmin'])){
    session_destroy();
    header("Location:admin-login.php");
}else{
    session_destroy();
    header("Location: index.php");
}
 
 
?>