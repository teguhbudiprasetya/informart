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

    $sellerID = $_GET['id'];

    $sql = "SELECT * FROM user WHERE kodeUser = $sellerID";
    $tokoProfile = mysqli_fetch_assoc(mysqli_query($conn,$sql));
    $sellerName = $tokoProfile['username'];
    $sellerPict = $tokoProfile['foto'];
    // $sellerName = $tokoProfile['transaksi'];
    $sumPenjualan = $tokoProfile['penjualan'];
    $rating = $tokoProfile['rating'];
    $idProvinsi = $tokoProfile['idProvinsi'];

    $sql = "SELECT DISTINCT kategori FROM product WHERE kodeUser = $sellerID ORDER BY kategori ASC";
    $kategori = mysqli_query($conn, $sql);

    if(isset($_GET['kategori'])){
        $kategoriSelected = $_GET['kategori'];
        $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE product.kodeUser = $sellerID AND product.kategori = '$kategoriSelected'";
        $product = mysqli_query($conn, $sql);
    }else{
        $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE product.kodeUser = $sellerID ORDER BY product.terjual DESC";
        $product = mysqli_query($conn, $sql);
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
        padding: 95px 35px 20px 35px;
    }
    

    #profilepict{
        /* height: 120px; */
        height: 80px;
        width: 90px;
        border-radius: 50%;
    }
    .frame{
    padding: 30px 20px 10px 20px;
    /* padding: 3px; */
    box-shadow: 1px 1px 5px 1px #d2d4d2;
    /* width: 90%; */
    /* height: 320px; */
    border-radius: 10px;   
    /* margin-right: 20px; */
    }
    label{
        font-size: 15px;
        margin-bottom: 0px;
    }
    #jenis{
        font-size: large;
    }
    ol{
        margin-left: -40px;
    }
    li{
        list-style-type: none;
    }
    .frame ol li a{
        text-decoration: none;
        font-size: medium;
        color: #96a9b3;
    }
    .frame ol li a:hover{
        color: #007bff;
    }

    .card-deck{
		/* margin: 0 -5px; */
		/* margin: -21px 0 0 -15px; */
        margin-top: -50px;
        color: black;
        width: 1000px;
	}
	.card-deck a{
		text-decoration: none;
		color: black;
	}
	.card{
		box-shadow: 1px 1px 5px 1px #d2d4d2;
		height: 260px;
		/* margin: 20px; */
		/* padding: 20px; */
		border-radius: 15px;
	}
	.card img{
		border-radius: 15px 15px 0px 0px;
		/* z-index: 0; */
		height: 140px;
		width: 150px;
	}
	.card-body{
		z-index: 1;
		padding: 7px;
	}
	.card-title{
		font-size: 14px;
	}
	.price-text{
		margin-top: -5px;
		font-size: 15px;
		font-weight: bolder;
	} 
	.card-location{
		font-size: 13px;
	}
	.card-rating{
		font-size: 13px;
		margin-top: -15px;
	}
    .frame{
        margin-top: -23px;
    }
</style>
    
	<title></title>
</head>
<body>
    <?php include "nav.php"; ?>
    <div class="row justify-content-center">
        <div class="col-1">
        </div>

        <div class="col-10">
            <div class="row">
                <div class="col-1">
                    <a href="page-toko.php?id=<?=$sellerID?>">    
                        <img id="profilepict" src="assets/profil/<?=$sellerPict?>" alt="">
                    </a>
                </div>
                <div class="col-auto pl-3">
                    <div class="ml-2">
                        <h5><?=$sellerName?></h5>
                        <!-- <small class="toko-name"><?=$profilName;?> &nbsp;</small> <button class="btn btn-outline-primary btn-sm" style="height: 40%;">Ikuti</button> -->
                        <small class=""><i class="fa fa-cart-arrow-down" aria-hidden="true"></i> <?=$sumPenjualan?> Transaksi</small>
                        <br>
                        <small><i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i> <?=$rating?> rata-rata ulasan</small>
                    </div>
                </div>
            </div>
            <hr color="#007bff" style="height:5px; border:none;">
            <br>

            <div class="row justify-content-center pt-2">
                <div class="col-2">
                <!-- <h5>Filter</h5> -->
                    <div class="frame">
                        <h6 id="jenis" style="font-weight: 900;">Katalog</h6>  
                        <!-- <label for="">Katalog</label> -->
                        <ol>
                            <?php
                            foreach($kategori as $row){
                                if(isset($_GET['kategori'])){
                                    if($_GET['kategori'] == $row['kategori']){
                                        echo"<li><a href='page-toko.php?id=$sellerID&kategori=$row[kategori]' style='color:#007bff''>$row[kategori]</a></li>";
                                    }else{
                                        echo"<li><a href='page-toko.php?id=$sellerID&kategori=$row[kategori]'>$row[kategori]</a></li>";
                                    }
                                }else{
                                    echo"<li><a href='page-toko.php?id=$sellerID&kategori=$row[kategori]'>$row[kategori]</a></li>";
                                }
                            }
                            ?>
                            <!-- <li><a href="#">Jaket</a></li>
                            <li><a href="#">Jaket</a></li>
                            <li><a href="#">Jaket</a></li>
                            <li><a href="#">Jaket</a></li> -->
                        </ol>
                        
                        </div>
                </div>
                <div class="col-10">
                    <div class="card-deck">
                    <?php 
                        
                        
                        foreach($product as $row):?>
                            <a href="page-item.php?product=<?= $row["kodeProduk"];?>">
                            <div class="card mt-4">
                                <img class="card-img-top" src="assets/<?= $row["gambar"]?>" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $row["namaProduk"]?></h5>
                                    <p class="card-text price-text">Rp <?=number_format($row["harga"],0,',','.')?></p>
                                    <p class="card-location"><i class="fa fa-map-marker" aria-hidden="true" style="color: red;"></i> &nbsp;<?= $row["lokasi"]?></p>
                                    <p class="card-rating"><i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i> <?= $row["rating"]?> | <i class="fa fa-cart-arrow-down" aria-hidden="true"> &nbsp;</i><?= $row["terjual"]?></p>
                                </div>
                            </div>	
                            </a>					
                        <?php 
                        endforeach ; 
                        ?>
            
                    </div> <!-- #SECTION card deck-->
                </div>
            </div>

        </div> <!-- #SECTION div col-9 -->
        <div class="col-1">
                            
        </div>
    </div>

	<script>
	</script>

</body>
</html>