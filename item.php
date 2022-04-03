<?php 
include 'config.php';
session_start();
 


if(isset($_SESSION['username'])){
	$userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];

    // NOTE total chart/keranjang display num
    $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $cartStack = $cart['COUNT(id)'];
}
// $item = ;
$sql = "SELECT * FROM product WHERE kodeProduk = '$_GET[product]'";
$item = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$itemCode = $item["kodeProduk"];
$itemName = $item["namaProduk"];
$itemSold = $item["terjual"];
$itemRating = $item["rating"];
$itemPrice = $item["harga"];
$itemPict = $item["gambar"];
$itemWeight = $item["berat"];
$itemDesc = $item["deskripsi"];
$itemCategori = $item["kategori"];
$userCode = $item["kodeUser"];


$sql = "SELECT sum(stok) FROM detailsproduct WHERE kodeProduk = $itemCode ";
$stok = mysqli_fetch_assoc(mysqli_query($conn, $sql));

$sql = "SELECT * FROM user WHERE kodeUser = $userCode";
$user = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$profilPict = $user["foto"];
$profilName = $user["username"];
$profilLocation = $user["lokasi"];


$sql = "SELECT AVG(rating), sum(terjual) FROM product WHERE kodeUser = $userCode";
$profileRateSold = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$profileTransaction = $profileRateSold["sum(terjual)"];
$profileRating = $profileRateSold["AVG(rating)"];

$sql = "SELECT * FROM detailsproduct WHERE kodeProduk = $itemCode";
$detailsproduct = mysqli_query($conn, $sql);
$selectionSize = mysqli_fetch_assoc($detailsproduct);
$Size = $selectionSize['ukuran'];
// var_dump($selectionSize);
// echo "<script>alert($selectionSize['ukuran'])</script>";



$sql = "SELECT * FROM detailsproduct WHERE kodeProduk = $itemCode";
$InfoStock = mysqli_query($conn, $sql);


if(isset($_POST['submit'])){
    $ukuran = $_POST['ukuran'];
    $warna = $_POST['warna'];
    $jumlah = $_POST['jumlah'];
    // echo $jumlah;
    // $checkout = "SELECT * FROM ";
    $sql = "SELECT stok FROM detailsproduct WHERE kodeProduk = $itemCode AND ukuran = '$ukuran' AND warna = '$warna'";
    $productStock = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    // echo $productStock['stok'];
    $sql = "SELECT kodeItem FROM detailsproduct WHERE kodeProduk = $itemCode AND ukuran = '$ukuran' AND warna = '$warna'";
    $kode = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $kodeItem = $kode['kodeItem'];
    if(isset($userID)){
        if($productStock['stok'] >= $jumlah){
            
            $sql = "INSERT INTO cart VALUES('', $userCode, $kodeItem, '$jumlah', '$warna', '$ukuran')";
            $insertCart = mysqli_query($conn, $sql);
            if($insertCart){
            echo    "<script>
                        alert('Berhasil masuk keranjang!')
                    </script>";
            header("location: cart.php");
            }
            else{
                echo    "<script>
                            alert('Gagal membeli!')
                        </script>";
            }

        } else{
            echo    "<script>
                            alert('Stok kurang!')
                        </script>";
        }
    }else{
        echo    "<script>
                    alert('Anda belum login, silahka login terlebih dahulu!')
                </script>";
    }
}

// $ukuran = "<script>document.write(localStorage.getItem('ukuran'))</script>";
// echo $ukuran;
// $warna = "<script>document.write(localStorage.getItem('warna'))</script>";
// echo $warna;
// var_dump($warna);

// // $phpVar = "<script>document.writeln(javascriptVar);</script>";
// // if(isset(localStorage.getItem('ukuran')) && isset(localStorage.getItem('warna'))){

// // }
// if($ukuran != 'null'){
//     $sql = "SELECT stok FROM detailsproduct WHERE kodeProduk = $itemCode AND ukuran = $ukuran AND warna = $warna";
//     $productStock = mysqli_fetch_assoc(mysqli_query($conn, $sql));
// }
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
    <title><?= $itemName; ?> | Informart</title>
<style>
    /* Make the image fully responsive */
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	body{
		font-family: 'Roboto';
    }
    ::-webkit-scrollbar {
    display: none;
    }

	.tabs {
  position:absolute;
  width: 94%;
  /* background-color: gainsboro; */
    }
    .tabs .tab-header {
    /* background:#f5f5f5; */
    padding:5px;
    display:flex;
    }
    .tab-header{
        border-radius: 10px 10px 0 0;
    }
    .tabs .tab-header > div {
    position:relative;
    width:90px;
    text-align:center;
    /* padding:10px; */
    z-index:2;
    font-weight:600;
    color:#888;
    cursor:pointer;
    transition:all 300ms ease-in-out;
    }
    .tabs .tab-header > div.active {
    color:#387be2;
    }
    .tabs .tab-indicator {
    position:absolute;
    width:90px;
    height:5px;
    background: #0275d8;
    top:30px;
    left:0px;
    /* border-radius:20px; */
    transition:all 300ms ease-in-out;
    }
    .tab-body{
        /* border-radius: 0 0 10px 10px; */
        /* width: 400px; */
        /* background-color: grey; */
        border-bottom: 1px solid #ddd;
    }
    .tabs .tab-body {
    position:relative;
    /* padding:20px; */
    /* background:black; */
    border-top:1px solid #ddd;
    height:170px;
    overflow-y: scroll;
    overflow-x: hidden;
    }

    .tabs .tab-body > div {
    position:absolute;
    opacity:0;
    top:-100%;
    }
    .tabs .tab-body > div.active {
    transform:translateY(0px);
    top:1px;
    opacity:1;
    }
    .tabs .tab-body h1 {
    color:#222;
    /* margin-bottom:10px; */
    }
    .tabs .tab-body p {
    color:#555;
    font-size:15px;
    }


    #display-item{
        /* margin-top: 150px; */
        /* background-color: grey; */
        /* width: 130%; */
        padding: 70px 60px;
    }
    #demo{
        height: 400px;
        /* background-color: #222; */
        overflow: hidden;
    }
    .frame{
        padding: 30px 20px 10px 20px;
        box-shadow: 1px 1px 5px 1px #d2d4d2;
        width: 100%;
        /* height: 320px; */
        border-radius: 10px;
    }
    #payment-sec{
        border-top: 1px solid #ddd;
        /* border-bottom: 1px solid #ddd; */
        /* margin-left: -5px; */
        /* background-color: #0275d8; */
    }
    label{
        font-size: 15px;
        margin-bottom: 0px;
    }
    #jenis{
        font-size: large;
    }
    button{
        font-weight: 900;
    }
    #main-1{
        padding: 0px 5px 10px 10px;
    }
    .item-name{
        font-weight: 600;
    }

    .item-section p{
        font-size: small;
        /* font-weight: bold; */
    }
    .item-price{
        font-weight: bold;
    }
    .detail p{
        margin: 0;
    }
    #toko img{
        height: 70px;
        width: 70px;
        border-radius: 50%;
    }
    #toko{
        width: 150%;
    }
    #toko small{
        font-weight: bold;
        font-size: medium;
    }
    #toko p{
        font-size: small;
        margin: 0;
    }
    .main-ongkir{
        margin-top: -15px;
    }
    .pengiriman{
        margin-top: 250px;
        /* background-color: #0275d8; */
    }
    .pengiriman h5{
        font-weight: bold;
    }
    .custom-select-focus{
    box-shadow: none;
    }
    .no-border{
        border: 0;
        width: 150px;
        background: none;
        margin-top: 6px;
        margin-left: -10px;
    }
    .pengiriman select, #ongkir{
        color: #0275d8 ;
        font-weight: bold;
    }
</style>
    
	<title></title>
</head>
<body>
    <?php include "nav.php"; ?>
<div id="display-item" class="row">
    <div id="demo" class="col-4 carousel slide " data-ride="carousel">

        <!-- SECTION Indicators -->
        <ul class="carousel-indicators">
            <li data-target="#demo" data-slide-to="0" class="active"></li>
            <li data-target="#demo" data-slide-to="1"></li>
            <li data-target="#demo" data-slide-to="2"></li>
        </ul>

        <!-- SECTION The slideshow -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="assets/<?=$itemPict;?>" alt="Los Angeles">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/<?=$itemPict;?>" alt="Chicago">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="assets/<?=$itemPict;?>" alt="New York">
            </div>
        </div>
        
        <!-- SECTION Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
            
    </div>
    
    <!-- SECTION Detail, Deskripsi, Toko -->
    <div id="main-1" class="col-5">
        <div class="item-section">
            <h4 class="item-name"><?= $itemName;?></h4>
            <p class="under-item-name">Terjual <?= $itemSold;?> | <i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i> <?= $itemRating;?> | 
            <a href=""><i class="fa fa-heart" aria-hidden="true" style="color: red;"></i></a> Wishlist</p>
            <h4 class="item-price mb-4">Rp. <?= $itemPrice;?></h4>
        </div>

        <!-- SECTION Deskripsi Item -->
        <!-- <div id="insert-box" class="row justify-content-center mt-3"> -->
        <!-- <div class="col"> -->
        <div id="payment-sec" class="tabs">
            <div class="tab-header">
                <div class="active">Detail</div>
                <div>Deskripsi</div>
                <div>Toko</div>
            </div>

            <div class="tab-indicator"></div>
                <div class="tab-body">
                    <div class="active">
                        <!-- SECTION detail tab -->
                        <div class="row mt-2 detail">
                            <div class="col-3">
                                <p>Berat</p>
                                <p>Kategori</p>
                                <p>Stok</p>
                            </div>
                            <div class="col-9">
                                <p>: <?= $itemWeight;?> Kilogram</p>
                                <p>:<a href=""> <?= $itemCategori;?></a></p>
                                <p>: <?= $stok['sum(stok)'];?></p>
                            </div>
                        </div>
                    </div>
                <!-- <div> -->
                        <!-- SECTION Deskripsi tab -->
                        <div id="deskripsi-scroll" class="row mt-2">
                            <div class="col">
                                <p style="text-align: justify;">
                                    <?= $itemDesc;  ?>
                                </p>
                            </div>
                        </div>
                    <!-- </div> -->
                        <!-- SECTION Deskripsi tab -->
                        <!-- <div> -->
                            <div id="toko" class="row mt-2">
                                <div class="col-2">
                                    <img class="ml-3" src="assets/<?=$profilPict;?>" alt="">
                                </div>
                                <div class="col-auto" style="margin-left: -25px;">
                                    <small class="toko-name"><?=$profilName;?> &nbsp;</small> <button class="btn btn-outline-primary btn-sm" style="height: 40%;">Ikuti</button>
                                    <p><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <?=$profileTransaction;?> Transaksi</p>
                                    <p><i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i><?= $profileRating;?> rata-rata ulasan</p>
                                    <?php //echo $profileRating;?>
                                    
                                </div>
                            </div>
                        <!-- </div> -->
            </div>
        </div> <!--Payment-sec -->

        <!-- SECTION Pengiriman -->
        <div class="pengiriman">
            <h5>Pengiriman</h5>
            <div class="main-ongkir">
                <form action="cart.php">
                    <p>
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        &nbsp; Dikirim dari
                        <select class="custom-select  mb-2 shadow-none no-border">
                            <option value="1" selected>Jakarta Barat</option>
                            <option value="2">Jawa Timur</option>
                            <option value="3">Jawa Barat</option>
                            <option value="4">Jawa Tengah</option>
                            <option value="5">Banten</option>
                        </select>
                    </p>
                    <p style="margin: -45px 0 0 13px;">
                        &nbsp; Dikirim ke
                        <select class="custom-select  mb-2 shadow-none no-border">
                            <option value="1" selected>Jakarta Barat</option>
                            <option value="2">Jawa Timur</option>
                            <option value="3">Jawa Barat</option>
                            <option value="4">Jawa Tengah</option>
                            <option value="5">Banten</option>
                        </select>
                    </p>
                    <p style="margin: -25px 0 0 0px;">
                        <i class="fa fa-truck" aria-hidden="true"></i>
                        Ekspedisi
                        <select class="custom-select  mb-2 shadow-none no-border">
                            <option value="1" selected>JNE Express</option>
                            <option value="2">J&T Express</option>
                            <option value="3">Tiki</option>
                        </select>
                    </p>
                    <h6>Biaya Ongkos Kirim</h6>
                    <p id="ongkir">Rp. 30.000</p>
                    <button class="btn btn-sm btn-primary">Cek Ongkir</button>
                </form>
            </div>
        </div>

    </div> 
            
        <!-- </div> -->
        <div class="col-3">


            <div class="frame">
                <h6 id="jenis" style="font-weight: 900;">Pilih Jenis</h6>  
                <form action="" method="POST">
                    <input type="text" value="-" name="ukuran" hidden>
                    <?php 
                    if($Size != '-'){
                        ?>
                    <label for="">Ukuran</label>
                    <select name="ukuran" id="ukuran" class="custom-select mb-2">
                        <option value="" hidden readonly></option>
                        <?php 
                        foreach($detailsproduct as $row):
                        ?>
                        <option value="<?=$row['ukuran'];?>"><?=$row['ukuran'];?></option>
                        <?php 
                        endforeach; ?>
                        </select>
                    <?php } ?>
                    <label for="">Warna</label>
                    <select name="warna" id="warna" class="custom-select">
                        <option value="" hidden readonly></option>
                    <?php 
                        foreach($detailsproduct as $row):
                        ?>
                        <option value="<?=$row['warna'];?>"><?=$row['warna'];?></option>
                        <?php 
                        endforeach;
                        ?>
                    </select>
                    <!-- <button type="submit" class="btn btn-outline-primary btn-sm btn-block mt-2 mb-2">Cek Stok</button> -->
                    <label for="">Jumlah</label>
                    <br>
                    <small id="stok"></small>
                    <input name="jumlah" type="number" class="form-control form-control-sm mb-2" placeholder="">
                    <button name="submit" type="submit" class="btn btn-primary btn-block mt-2 mb-2">Keranjang</button>
                </form>
            </div>
            <div class="frame mt-3">
                <h5>Stok Product</h5>
                <table class="table table-sm" style="width: 100%;">
                    <thead>
                        <tr>
                            <td>Ukuran</td>
                            <td>Warna</td>
                            <td>Stok</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($InfoStock as $row):
                        ?>
                        <tr>
                            <td><?=$row['ukuran'];?></td>
                            <td><?=$row['warna'];?></td>
                            <td><?=$row['stok'];?></td>
                        </tr>
                        <?php endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
    

	<script>
        // localStorage.clear();
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
        // let num = 0;
        // $(document).ready(function(){
        // $("select").change(function(){
        //     let size = document.querySelector('#ukuran');
        //     let color = document.querySelector('#warna');
        //     num++;
        //     if(num>=2){
        //     localStorage.setItem('ukuran',size.value);
        //     localStorage.setItem('warna',color.value);
        //     location.reload();
        //     }
        // });
        // });
	</script>

</body>
</html>