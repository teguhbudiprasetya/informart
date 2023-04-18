<?php 

include 'config.php';

$kodeItem = $_GET['id'];
$checkRows = mysqli_query($conn, "SELECT * FROM detailsproduct WHERE kodeProduk = (SELECT kodeProduk FROM detailsproduct WHERE kodeItem = '$kodeItem')");
$getKodeProduk = mysqli_fetch_assoc($checkRows);
if($checkRows -> num_rows > 1){
    $sql = "DELETE FROM detailsproduct WHERE kodeItem = $kodeItem";
    $deleteProduct = mysqli_query($conn, $sql);
    header("location: seller-barang-penjualan.php");
}else{
    $kodeProduk = $getKodeProduk['kodeProduk'];
    $sql = "DELETE FROM product WHERE kodeProduk = $kodeProduk";
    $deleteProduct = mysqli_query($conn, $sql);
    header("location: seller-barang-penjualan.php");
}

?>