<?php 

include 'config.php';

$orderItemID = $_GET['id'];
var_dump($orderItemID);
$sql = "UPDATE orderdetails SET status = 'Sedang dikirim' WHERE orderItemID = '$orderItemID'";
$updateStatusOrder = mysqli_query($conn, $sql);
header("location: seller-pesanan-customer.php?check=proses");

?>