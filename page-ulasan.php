<?php 
include 'config.php';
session_start();
 


if(isset($_SESSION['username'])){
    $orderdetailsID = $_GET['id'];
	$userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];

    // NOTE total chart/keranjang display num
    // $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    // $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    // $cartStack = $cart['COUNT(id)'];

    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE kodeUser = $userID"));
    $now = date('Y-m-d');

    $sql = "SELECT product.kodeProduk AS productCode, tbl_order.transaksiID, user.kodeUser AS PenjualID, user.username AS sellerName, tbl_order.kodeUser, 
    product.namaProduk AS namaProduk, product.gambar AS gambar, tbl_order.tgl_beli AS tanggal,provinsi.namaProvinsi AS lokasi, orderdetails.status ,orderdetails.detailsOngkir AS ongkir,
    orderdetails.qty AS qty, detailsproduct.warna AS warna, detailsproduct.ukuran AS ukuran ,orderdetails.harga AS hargasatuan ,orderdetails.detailsOngkir, 
    (orderdetails.qty*orderdetails.harga) AS harga FROM tbl_order INNER JOIN orderdetails USING(transaksiID) INNER JOIN detailsproduct 
    USING(kodeItem) INNER JOIN product USING(kodeProduk) INNER JOIN user ON product.kodeUser = user.kodeUser INNER JOIN provinsi USING(idProvinsi) 
    WHERE orderdetails.orderItemID = $orderdetailsID";

    $items = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $transaksiID = $items['transaksiID'];
    // var_dump($updateRating);die();
    // print($transaksiID);

    $alamat = mysqli_fetch_assoc(mysqli_query($conn,"SELECT alamat FROM user WHERE kodeUser = $userID"));

    // $_SESSION['rating'] = 0;

    if(isset($_POST['submit'])){
        $_SESSION['rating'] += 1;
        $kodeProduk = $items['productCode'];
        $sql = "SELECT rating, terjual FROM product WHERE kodeProduk = '$kodeProduk'";
        $rateSold = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        
        $temp = $rateSold['rating'] * ($rateSold['terjual'] - 1);
        $temp = $temp + $_POST['rating'];
        $finalRating = $temp/$rateSold['terjual'];
        $updateRating = "UPDATE product SET rating = '$finalRating' WHERE kodeProduk = '$kodeProduk'";
        mysqli_query($conn, $updateRating)or trigger_error("Query Failed! SQL: $updateRating - Error: ".mysqli_error($conn), E_USER_ERROR);
        $updateStatusOrderDetails = "UPDATE orderdetails SET status = 'selesai' WHERE orderdetails.orderItemID = $orderdetailsID";
        mysqli_query($conn, $updateStatusOrderDetails)or trigger_error("Query Failed! SQL: $updateStatusOrderDetails - Error: ".mysqli_error($conn), E_USER_ERROR);
        
        $sql = "SELECT status FROM orderdetails WHERE orderdetails.transaksiID = '$transaksiID' ORDER BY status";
        $pickStatus = mysqli_query($conn, $sql);
        foreach ($pickStatus as $row) {
            if($row['status'] == 'proses'){
                $check = false;
                break;
            }else{
                $check = true;
            }
        }
        if($check == 'true'){
            $updateStatusOrder = "UPDATE tbl_order SET status = 'selesai', tgl_sampai = '$now' WHERE transaksiID = '$transaksiID'";
            mysqli_query($conn, $updateStatusOrder)or trigger_error("Query Failed! SQL: $updateStatusOrder - Error: ".mysqli_error($conn), E_USER_ERROR);
        }
        // header('location: ')
        header("Refresh:0");
    }

}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Katalog | Informart</title>
<style>
    /* Make the image fully responsive */
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	body{
		font-family: 'Roboto';
        padding: 20px 35px 20px 35px;
    }
    .tabs {
    position:absolute;
    width: 94%;
    /* background-color: gainsboro; */
    }
    /* .tab-header{
        background-color: #0275d8;
    } */
    .tab-indicator {
    /* position:absolute; */
    width: 100%;
    height:5px;
    background: #0275d8;
    }

    .tabs .tab-body {
    position:relative;
    border-top:1px solid #ddd;
    }

    td{
        margin-top: 20px;
    }
</style>
    
	<title></title>
</head>
<body>
    <div class="row justify-content-center">
        <div class="col-3">
           
        </div>

        <div class="col-6 ">
            <div class="tabs">
                <div class="tab-header">
                        <h5 class="">Ulasan Produk</h5>
                </div>

                <div class="tab-indicator"></div>
                    <div class="tab-body">
                        <div class="active p-1">
                        <div class="cart-items">
                            <div class="cart-item row rounded shadow p-4">
                                <div class="col-2 mt-5">
                                    <a href="page-item.php?product=<?=$items["productCode"];?>"><img class="d-block w-100" src="assets/<?=$items['gambar'];?>" alt=""></a>
                                </div>
                                <div class="col-10">
                                    <small class="float-right font-italic"><?=$items['tanggal']?></small>
                                    <br>
                                    <?php 
                                    if($items['status'] != 'selesai'){
                                        echo "<small class='float-right btn-primary btn-sm'>Sedang dikirim</small>";
                                    }else{
                                        echo "<small class='float-right btn-success btn-sm'>Selesai</small>";
                                        
                                    }
                                    ?>
                                    <!-- <small class="float-right btn-primary btn-sm">Sedang dikirim</small> -->
                                    <p id="item-name"><?=$items['namaProduk'];?></p>
                                    <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($items['ongkir'],0,',','.');?></span></small>
                                    <br>
                                    <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($items['hargasatuan'],0,',','.');?> x <?=$items['qty'];?></span></small>
                                    <br>
                                    <small class="float-right">Total harga: <span style="color:#0275d8; font-weight:bold;"><?=number_format($items['harga']+$items['ongkir'],0,',','.');?></span></small>
                                    <small id="toko-name">Toko : <?=$items['sellerName'];?></small>
                                    <br>
                                    <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$items['lokasi'];?></small>
                                    <small class="float-right">Qty: <?=$items['qty'];?> | Warna: <?=$items['warna'];?> | Ukuran: <?=$items['ukuran'];?></small>
                                    <br>
                                </div>
                                <small class="mt-3 ml-3" style="width: 95%;">Alamat:<br> <?=$alamat['alamat']?></small>
                                <?php if($items['status'] != 'selesai'){?>
                                <form action="#" method="POST" style="width: 100%;">
                                    <!-- <input type="number" name="kodeProduk" value="<?=$items["productCode"];?>" style="display: none;"> -->
                                    <input type="range" id="rating" name="rating" class="form-control" value="0" max="5" step="0.5" list="tickmarks" onchange="updateTextInput(this.value);">
                                    <datalist id="tickmarks">
                                        <option value="0"></option>
                                        <option value="0.5"></option>
                                        <option value="1"></option>
                                        <option value="1.5"></option>
                                        <option value="2"></option>
                                        <option value="2.5"></option>
                                        <option value="3"></option>
                                        <option value="3.5"></option>
                                        <option value="4"></option>
                                        <option value="4.5"></option>
                                        <option value="5"></option>
                                    </datalist>
                                    <div class="text-center">
                                        <small class="h4"><i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i></small>
                                        <small  id="inputRate" class="text-center h4">0</small>
                                    </div>
                                    <br>
                                    <button type="submit" name="submit" class="btn btn-success btn-sm text-center" style="width: 100%;">Selesai</button>
                                </form>
                                <?php
                                }else{
                                    echo "<button class='btn btn-dark btn-sm text-center mt-5' style='width: 100%;' readonly>Selesai diulas</button>";
                                    echo "<a href='page-pesanan.php?check=done' class='btn btn-ligt  btn-sm text-center mt-1' style='width: 100%;' readonly>Kembali</a>";
                                }?>
                            </div>
                            <br>
                        </div> <!--ENDIV CART-ITEMS--> <!--//NOTE penutup proses section-->
                        </div> <!-- #SECTION active-->
                    </div> <!-- #SECTION div body-->
                </div> <!-- #SECTION div indicator-->
        </div> <!-- #SECTION div col-9 -->
        <div class="col-3">
                            
        </div>
    </div>

	<script>
        const rate = document.getElementById('inputRate');
        function updateTextInput(val) {
            rate.innerHTML=val;
        }
	</script>

</body>
</html>