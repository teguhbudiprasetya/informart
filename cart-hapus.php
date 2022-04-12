<?php 

include 'config.php';

$cartID = $_GET['id'];

$sql = "DELETE FROM cart WHERE id = $cartID";
$deleteCart = mysqli_query($conn, $sql);
header("location: cart.php");

?>