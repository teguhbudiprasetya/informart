<?php 
include 'config.php';
session_start();
 

    

	$userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];
    $now = date('Y-m-d');
    
    // NOTE total chart/keranjang display num
    $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $cartStack = $cart['COUNT(id)'];
    // echo var_dump($cartStack);
    
    $sql = "SELECT cart.kodeUser AS PembeliID, cart.detailsOngkir AS ongkir ,product.kodeUser AS PenjualID, product.kodeProduk AS productCode ,product.namaProduk AS namaProduk, product.gambar AS gambar, user.username AS sellerName, provinsi.namaProvinsi AS lokasi, cart.id AS ID ,cart.qty AS qty, cart.warna AS warna, cart.ukuran AS ukuran
    FROM cart JOIN detailsproduct USING(kodeItem) JOIN product USING(kodeProduk) JOIN user ON product.kodeUser JOIN provinsi ON user.idProvinsi = provinsi.idProvinsi = user.kodeUser WHERE cart.kodeUser = $userID";
    $item = mysqli_query($conn, $sql);
    
    $sql = "SELECT sum(cart.qty * product.harga) AS TotalPayment FROM cart INNER JOIN detailsproduct USING(kodeItem) INNER JOIN product USING(kodeProduk) WHERE cart.kodeUser = $userID";
    $totalPayment = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    
    $sql = "SELECT sum(detailsOngkir) AS TotalOngkir FROM cart WHERE kodeUser = $userID";
    $totalOngkir = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $sql = "SELECT saldo FROM user WHERE kodeUser = $userID";
    $saldo = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $saldo = (int)($saldo['saldo']);

    $sql = "SELECT * FROM voucher";
    $voucher = mysqli_query($conn, $sql);
    
    
    
    
    if(isset($_GET['voucherButton'])){
        $potongan = $_GET['voucher'];
        // var_dump($potongan);
        // var_dump($potongan);
        $sql = "SELECT * FROM voucher WHERE voucherID = $potongan";
        $disc = mysqli_fetch_object(mysqli_query($conn, $sql));
        $totalDisc = $disc->potongan;
        if($disc->jenis == 'bagi'){
            $totalPrice = $totalPayment['TotalPayment'] + $totalOngkir['TotalOngkir'];
            $totalPriceFix = $totalPrice-($totalPrice * $totalDisc);
            
        }else{
            $totalPriceFix = ($totalPayment['TotalPayment'] + $totalOngkir['TotalOngkir']) - $totalDisc;
            // $totalPrice -= $totalPrice * $voucher;

        }

        $discSelected = $disc->voucherName;
        
        // $totalPrice = $totalPayment['TotalPayment'] + $totalOngkir['TotalOngkir'];
        // echo "<script>
        // var value = localStorage.getItem(price); 
        // jQuery.post('example.php', {myKey: value}, function(data) 
        // { 
        // alert('Do something with example.php response'); 
        // }).fail(function() 
        // { 
        // alert('Damn, something broke'); 
        // }); 
        // </script>";
    }else{
        // $voucher = 0.1;
        $totalPriceFix = $totalPayment['TotalPayment'] + $totalOngkir['TotalOngkir'];
        // $totalPrice -= $totalPrice * $voucher;
        // echo "<script>localStorage.setItem('price', '$totalPrice')</script>";
    }
    
    if(isset($_POST['bayar'])){
        // session_start();
        // $totalPrice = "<script>localStorage.getItem(price)</script>";
        // $potongan = $_GET['voucher'];
        // if(isset($potongan)){
            // }
            // $date = date('Y-m-d');
            // var_dump($potongan);
            $ongkir = $totalOngkir['TotalOngkir'];
            // var_dump($totalPriceFix, (int)$userID, (int)$ongkir, (int)$potongan);
            if($saldo >= $totalPriceFix){
            // $now = date('Y-m-d');
            
            if(isset($potongan)){
                $sql = "INSERT INTO tbl_order VALUES ('', $userID, 'bayar', '$now', '', $totalPriceFix, $ongkir, $potongan )";
            }else{
                $sql = "INSERT INTO tbl_order VALUES ('', $userID, 'bayar', '$now', '', $totalPriceFix, $ongkir, 0 )";
            }
            
            $insertOrder = mysqli_query($conn,$sql)or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
            $sql = mysqli_query($conn, "SELECT max(transaksiID) AS last FROM tbl_order");
            // $last = $sql2['last'];
            $last = mysqli_fetch_object($sql);
            $next = (int)$last->last;

            if($insertOrder){
                $sql = "SELECT cart.*, product.harga, user.kodeUser AS kodepenjual FROM cart INNER JOIN detailsproduct
                USING(kodeItem) INNER JOIN product ON detailsproduct.kodeProduk =  product.kodeProduk INNER JOIN user 
                ON product.kodeUser = user.kodeUser WHERE cart.kodeUser = $userID";
                $inputdetails = mysqli_query($conn, $sql);
                foreach($inputdetails as $row){
                    $inserdetails = "INSERT INTO orderdetails VALUES ('', $row[kodeItem], $row[qty], $row[harga], $next, $row[detailsOngkir], $row[idEkspedisi], $row[kodepenjual])";
                    mysqli_query($conn, $inserdetails)or trigger_error("Query Failed! SQL: $inserdetails - Error: ".mysqli_error($conn), E_USER_ERROR);
                    
                    $minusStock = "UPDATE detailsproduct SET stok = stok - $row[qty] WHERE kodeItem = $row[kodeItem]";
                    mysqli_query($conn, $minusStock)or trigger_error("Query Failed! SQL: $minusStock - Error: ".mysqli_error($conn), E_USER_ERROR);
                    
                    $ratingPenjual = "UPDATE user SET transaksi = transaksi + 1 WHERE kodeUser = $row[kodepenjual]";
                    mysqli_query($conn, $ratingPenjual)or trigger_error("Query Failed! SQL: $ratingPenjual - Error: ".mysqli_error($conn), E_USER_ERROR);

                }
                echo    "<script>
                                alert('Pembelian berhasil!');
                        </script>";
            }
            else{
                echo "gagal!";
            }
                // header("location: cart.php");
        }else{
            echo    "<script>
                            alert('Saldo anda tidak cukup untuk pembelian ini, silahkan TopUp saldo!')
                    </script>";
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
    <title>Cart | Informart</title>
<style>
    /* Make the image fully responsive */
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	body{
		font-family: 'Roboto';
        padding: 125px 0px 20px 105px;
    }
    ::-webkit-scrollbar {
    display: none;
    }
    #container{
        width: 95%;
    }
    .frame{
        padding: 30px 20px 10px 20px;
        box-shadow: 1px 1px 5px 1px #d2d4d2;
        width: 100%;
        height: 400px;
        border-radius: 10px;
    }
    .cart-item img{
        height: 90px;
    }
    #toko-name{
        margin-bottom: -5px;
        font-size: 15px;
    }
    #item-name{
    font-weight: 600;
    }
    .frame p{
        font-size: small;
        margin-top: -10px;
    }
    .frame #bayar{
    margin-top: 0px;
    margin-left: -20px;
    width: 112.5%;
    height: 45px;
    border: none;
    background-color: #0275d8;
    border-radius: 0 0 10px 10px;
    color: white;
    font-weight: 100;
    }
    .frame #bayar:hover{
        background-color:#0275e8;

    }
    #bayar{
    font-weight: 900;
    }

</style>
    
	<title></title>
</head>
<body>
    <?php include "nav.php"; ?>

        <div id="container" class="row">
                <div class="col-7 ml-5">
                    <h5>Keranjang</h5>
                    <hr>
                    <!-- ANCHOR CART ITEMS -->
                    <div class="cart-items">
                        <?php 
                        foreach($item as $row){
                        ?>
                        <div class="cart-item row">
                            <div class="col-2">
                                <a href="item.php?product=<?= $row["productCode"];?>"><img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt=""></a>
                            </div>
                            <div class="col-10">
                                <p id="item-name"><?=$row['namaProduk'];?></p>
                                <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                <p id="toko-name" class="mt-4"><?=$row['sellerName'];?></p>
                                <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$row['lokasi'];?></small>
                                <small class="float-right">Qty: <?=$row['qty'];?> | Warna: <?=$row['warna'];?> | Ukuran: <?=$row['ukuran'];?> | <a href="cart-hapus.php?id=<?=$row['ID']?>"><i class="fa fa-trash" aria-hidden="true" ></i></a></small>

                            </div>
                        </div>
                        <hr>
                        <?php } ?>
                    </div> <!--ENDIV CART-ITEMS-->
                </div>
                    
                <!-- </div> -->
                <div class="col-4">
                    <div class="frame">
                        <h6 id="jenis" style="font-weight: 900;">Pilih Jenis</h6>  
                        <form action="" method="GET">
                        <label for="">Voucher</label>
                        <select name="voucher" class="custom-select mb-2">
                            <?php 
                            if(isset($discSelected)){?>
                                <option selected hidden value readonly="<?=$discSelected;?>"><?=$discSelected;?></option>
                            <?php foreach($voucher as $row){
                                    if($row['voucherID'] != 0){

                            ?>
                            <option value="<?=$row['voucherID'];?>"><?=$row['voucherName'];?></option>
                            <?php }
                                }
                            }else{
                                foreach($voucher as $row){ 
                                    if($row['voucherID'] != 0){?>
                            
                                        <option value="<?=$row['voucherID'];?>"><?=$row['voucherName'];?></option>
                                <?php }
                                    }
                            }
                            ?>
                        </select>
                        <button name="voucherButton" type="submit" class="btn btn-outline-primary btn-sm btn-block mt-2 mb-2">Pilih Voucher</button>
                        </form>
                        <hr>
                        <div class="row">
                            <div class="col-5">
                                <p>Total Harga Barang</p>
                                <p>Total Diskon Barang</p>
                                <p>Total Ongkos Kirim</p>
                            </div>
                            <div class="col-7 text-right">
                                <p id="items-price">
                                
                                <?=number_format($totalPayment['TotalPayment'],0,',','.');?>
                                </p>
                                <p id="discount-price">
                                0
                                </p>
                                <p id="deliv-price">
                                <?=number_format($totalOngkir['TotalOngkir'],0,',','.');?>
                            </p>
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-5">
                                <p style="font-weight: bold;">Total Harga</p>
                                <p style="margin-top: 10px;">Saldo</p>
                            </div>
                            <div class="col-7 text-right">
                                <p id="total-price" style="font-weight: bold;">
                                <?=number_format($totalPriceFix,0,',','.');?>
                            </p>
                            <p id="saldo" style="margin-top: 10px;">
                                <?=number_format($saldo,0,',','.');?>
                                </p>
                            </div>
                        </div>
                        <form action="" method="POST">
                        <button id="bayar" name="bayar" type="submit" onclick="return confirm('Apakah anda yakin?')">Bayar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            

	<script>
		let tabs = document.querySelector(".tabs");
		let tabHeader = tabs.querySelector(".tab-header");
		let tabBody = tabs.querySelector(".tab-body");
		let tabIndicator = tabs.querySelector(".tab-indicator");
		let tabHeaderNodes = tabs.querySelectorAll(".tab-header > div");
		let tabBodyNodes = tabs.querySelectorAll(".tab-body > div");

		for(let i=0;i<tabHeaderNodes.length;i++){
		tabHeaderNodes[i].addEventListener("click",function(){
			tabHeader.querySelector(".active").classList.remove("active");
			tabHeaderNodes[i].classList.add("active");
			tabBody.querySelector(".active").classList.remove("active");
			tabBodyNodes[i].classList.add("active");
			tabIndicator.style.left = `calc(calc(95px) * ${i})`;
		});
		}
	</script>

</body>
</html>