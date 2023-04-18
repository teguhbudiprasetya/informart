<?php 

include 'config.php';

$kodeVoucher = $_GET['id'];
mysqli_query($conn, "DELETE FROM voucher WHERE voucherID = $kodeVoucher");
header('location:admin-voucher.php');