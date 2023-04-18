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
	$gifselling = mysqli_fetch_assoc(mysqli_query($conn,"SELECT status FROM user WHERE kodeUser = $userID"));

	$sql = "SELECT saldo FROM user WHERE kodeUser = $userID";
	$saldo = mysqli_fetch_assoc(mysqli_query($conn, $sql));
	$now = date('Y-m-d');
	if(isset($_GET['payment'])){
		$nomer = $_GET['notelp'];
		$nominal = $_GET['telpprice'];
		$sql = "SELECT harga FROM product INNER JOIN detailsproduct USING(kodeProduk) WHERE kodeItem = $nominal";
		$harga = mysqli_fetch_assoc(mysqli_query($conn,$sql));
		// var_dump($harga);die();
		$harga = (int)$harga['harga'];
	}
	if(isset($_POST['belipayment'])){
		$sql = "SELECT harga, kodeProduk FROM product INNER JOIN detailsproduct USING(kodeProduk) WHERE kodeItem = $nominal";
		$harga = mysqli_fetch_assoc(mysqli_query($conn,$sql));
		// var_dump($harga);die();
		$kodeProduk = (int)$harga['kodeProduk'];
		$harga = (int)$harga['harga'];
		// var_dump($harga,$kodeProduk);die();
		$sql = "INSERT INTO tbl_order VALUES ('', $userID, 'selesai', '$now', '$now', $harga, 0, 0 )";
		$insertOrder = mysqli_query($conn,$sql)or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
		if($insertOrder){
			$sql = mysqli_query($conn, "SELECT max(transaksiID) AS last FROM tbl_order");
            // $last = $sql2['last'];
            $last = mysqli_fetch_object($sql);
            $next = (int)$last->last;

			$inserdetails = "INSERT INTO orderdetails VALUES ('', $nominal, 1, $harga, $next, 0, 0, 'selesai',0)";
            mysqli_query($conn, $inserdetails)or trigger_error("Query Failed! SQL: $inserdetails - Error: ".mysqli_error($conn), E_USER_ERROR);

			$TransaksiPembeli = "UPDATE user SET transaksi = transaksi + 1 WHERE kodeUser = '$userID'";
            mysqli_query($conn, $TransaksiPembeli)or trigger_error("Query Failed! SQL: $TransaksiPembeli - Error: ".mysqli_error($conn), E_USER_ERROR);

			$productSold = "UPDATE product SET terjual = terjual + 1 WHERE kodeProduk = '$kodeProduk'";
			mysqli_query($conn, $productSold)or trigger_error("Query Failed! SQL: $productSold - Error: ".mysqli_error($conn), E_USER_ERROR);
			
			echo    "<script>
                                alert('Pembelian berhasil!');
								window.location.replace('index.php');
                        </script>";
			
		}
	}
}
// var_dump($userName);
$sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE product.kategori != 'payment' AND product.kategori != 'payment-saldo' ORDER BY product.terjual DESC LIMIT 6";
$product = mysqli_query($conn, $sql);



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
    <title>Home | Informart</title>
	
<style>
    /* Make the image fully responsive */
	@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
	
	::-webkit-scrollbar {
    display: none;
    }
	.modal{
		display: block;
	}
	body{
		font-family: 'Roboto';
    	
	}
    #banner{
		box-shadow: 0px 0px 10px 0.2px #d2d4d2;
        /* box-shadow: 0px 0px 14px 1px gray; */
		border-radius: 20px;
		margin-top:80px;
    }
    .carousel-inner img {
		width: 100%;
		height: 240px;
		border-radius: 20px;
	}


	#main-1{
		/* background-color: black; */
		border-style: solid;
		border-color: white;
		border-radius: 20px;
		box-shadow: 0px 0px 10px 0.2px #d2d4d2;
		height: 290px;
	}
	#main-2{
		/* background-color: black; */
		border-style: solid;
		border-color: white;
		/* width: 250%; */
		/* border-radius: 20px;
		box-shadow: 0px 0px 10px 0.2px #d2d4d2; */
		/* height: 250px; */
	}
	#text-header h4{
		font-weight: 900;
	}
	#text-header h4 a{
		font-size: medium;
		text-decoration: none;
	}
	#insert-box{
		width: 95%;
		height: 240px;
		/* background-color: grey; */
	}
	#payment-sec{
		height: 200px;
		border-radius: 10px;
		font-weight: 600;
		box-shadow: 1px 1px 5px 1px #d2d4d2;

	}
	.item-fav{
		height: 90px;
		/* width: 20px; */
		/* border: 1px solid black; */
		margin: 0px 20px;
		border-radius: 15px;
		padding: 0;
	}
	.item-fav a img{
		border-radius: 15px;
		height: 90px;
		box-shadow: 1px 1px 5px 1px #d2d4d2;
	}
	
	.card-deck{
		/* margin: 0 -5px; */
		margin: -15px 10px 0 0;
	}
	.card-deck a{
		text-decoration: none;
		color: black;
	}
	.card{
		box-shadow: 1px 1px 5px 1px #d2d4d2;
		height: 260px;
		margin: 20px;
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
	.brand-row{
		width: 100%;
		/* background: grey; */
		
	}
	.brand-tag{
		/* background-image: url("assets/logo-vans.png"); */
		box-shadow: 1px 1px 5px 1px #d2d4d2;
		height: 60px;
		/* border: 1px solid black; */
		/* margin-top: ; */
		margin: 0px 22px;
		border-radius: 10px;
	}
	.img-fluid{
		max-width: 100%;
		height: auto;
	}


	.tabs {
	position:absolute;
	width: 95%;
	}
	.tabs .tab-header {
	background:#f5f5f5;
	padding:5px;
	display:flex;
	}
	.tab-header{
		border-radius: 10px 10px 0 0;
	}
	.tabs .tab-header > div {
	position:relative;
	width:calc(100%/3);
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
	width:calc(calc(100%/3) - 5px);
	height:35px;
	background:#d9e5f9;
	top:0px;
	left:10px;
	border-radius:20px;
	transition:all 300ms ease-in-out;
	}
	.tab-body{
		border-radius: 0 0 10px 10px;
		/* background-color: grey; */
	}
	.tabs .tab-body {
	position:relative;
	/* padding:20px; */
	/* background:black; */
	border-top:1px solid #ddd;
	height:180px;
	overflow:hidden;
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
	.chevron-down {
    position:fixed;
	bottom: 0;
	right: -380;
    /* top:100vh; */
    /* transform:translateY(100%); */
    /* width:20px; */
	}
	.chevron-down img{
	width:24%;
	}
  </style>
    
	<title></title>
</head>
<body>
	<?php include "nav.php"; ?>

    <div id="banner" class="container">
		<div id="demo" class="row carousel slide " data-ride="carousel">

			<!-- SECTION Indicators -->
			<ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
			</ul>

			<!-- SECTION The slideshow -->
			<div class="carousel-inner">
			<div class="carousel-item active">
				<img class="d-block w-80" src="assets/Banner Web DPW 1.png">
			</div>
			<div class="carousel-item">
				<img class="d-block w-80" src="assets/Banner Web DPW 2.png">
			</div>
			<div class="carousel-item">
				<img class="d-block w-80" src="assets/Banner Web DPW 3.png">
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
    </div>
	<!-- SECTION Kategori dan payment box -->
	<div id="main-1" class="container mt-4">
		<div id="insert-box" class="row justify-content-center mt-3 ml-4">
			<div class="col">
				<div id="text-header" class="row">
					<div class="col">
						<h4>Kategori</h4>
					</div>
					<div class="col">
						<h4>Beli & Bayar Tagihan</h4>
					</div>
				</div>
				<div id="submain-2" class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Baju+Wanita" name="baju_wanita"> <img src="assets/kategori-baju-wanita.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Baju+Pria"> <img src="assets/kategori-baju-pria.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Jaket"> <img class="w-100" src="assets/jaket.png" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Topi"> <img src="assets/topi.jpg" alt=""> </a>
							</div>
						</div>
						<div class="row mt-4">
						<div class="item-fav col">
								<a href="page-katalog.php?kategori=Celana+Wanita"> <img src="assets/kategori-celana-wanita.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Celana+Pria"> <img src="assets/kategori-celana-pria.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Sepatu"> <img src="assets/sepatu.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="page-katalog.php?kategori=Tas"> <img src="assets/tas.jpg" alt=""> </a>
							</div>
						</div>
					</div>

					<!-- SECTION Paymment section -->
					<div class="col">
						<div id="payment-sec" class="tabs border border-primary">
								<div class="tab-header">
									<div class="active">Pulsa</div>
									<div>Token PLN</div>
									<div>E-Money</div>
								</div>
								<div class="tab-indicator"></div>
								<div class="tab-body">
									<div class="active">
										<div class="row mt-2 justify-content-center" style="width: 141%;">
											<div class="col-4 align-self-center ml-3">
												Nomor Telepon
											</div>
											<div class="col-7">
													<form action="index.php?type=payment"  method="GET" enctype="multipart/form-data">
													<input type="number" name="notelp" class="form-control" placeholder="" required>
												</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 141%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
											<select class="custom-select" name="telpprice" required>
												<!-- <option selected hidden>Pilih nominal</option> -->
												<option value="18">10.000</option>
												<option value="19">15.000</option>
												<option value="20">20.000</option>
											</select>
											</div>
										</div>
										<div class="row mt-2 justify-content-end" style="width: 137%;">
											<div class="col-auto">
												<?php if(!isset($userID)){ ?>
													<!-- <a id="trigger-login-gif" href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button class="trigger-login-gif btn btn-sm btn-primary" name="payment" style="width: 50px;">Beli</button>
												<?php }else{ ?>
													<!-- <a href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button type="submit" name="payment" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
												<?php } ?>
												<!-- <button type="submit" name="payment" class="btn btn-sm btn-primary" style="width: 50px;" data-toggle="modal" data-target="#staticBackdrop">Beli</button> -->
												<!-- <button type="submit" name="paymentsubmit2" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button> -->
											</div>
											</form>
										</div>
									</div>
									<div>
										<div class="row mt-2 justify-content-center" style="width: 158%;">
											<div class="col-4 align-self-center ml-3">
												No. Meter
											</div>
											<div class="col-7">
												<form action="index.php?type=payment" method="GET" enctype="multipart/form-data">
												<input type="number" name="notelp" class="form-control" placeholder="" required>
											</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 158%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
												<select name="telpprice" class="custom-select" required>
												<!-- <option selected hidden>Pilih nominal</option> -->
												<option value="21">50.000</option>
												<option value="22">100.000</option>
											</select>
											</div>
										<div class="row mt-2 justify-content-end" style="width: 94.2%;">
											<div class="col-auto">
												<?php if(!isset($userID)){ ?>
													<!-- <a id="trigger-login-gif" href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button class="trigger-login-gif btn btn-sm btn-primary" name="payment" style="width: 50px;">Beli</button>
												<?php }else{ ?>
													<!-- <a href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button type="submit" name="payment" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
												<?php } ?>
												<!-- <button type="submit" name="payment" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button> -->
											</div>
											</form>
										</div>
										</div>
									</div>
									<div>
									<div class="row mt-2 justify-content-center" style="width: 160%;">
											<div class="col-4 align-self-center ml-3">
												No. Kartu
											</div>
											<div class="col-7">
												
											<form action="index.php?type=payment" method="GET" enctype="multipart/form-data">
											<input type="num" name="notelp" class="form-control" placeholder="" required>
											</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 160%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
												<select class="custom-select" name="telpprice" required>
												<!-- <option selected hidden>Pilih nominal</option> -->
												<option value="23">20.000</option>
												<option value="24">50.000</option>
												</select>
											</div>
										<div class="row mt-2 justify-content-end" style="width: 94.2%;">
											<div class="col-auto">
												<?php if(!isset($userID)){ ?>
													<!-- <a id="trigger-login-gif" href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button class="trigger-login-gif btn btn-sm btn-primary" style="width: 50px;">Beli</button>
												<?php }else{ ?>
													<!-- <a href="#" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a> -->
													<button type="submit" name="payment" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
												<?php } ?>
											</div>
											</form>
										</div>
										</div>
									</div>
								</div>
								</div>
						</div>
					</div>
				</div>
		
		</div>
	</div>

	<!-- SECTION official store items -->
	<div id="main-2" class="container mt-4 mb-5">
		<div id="text-header" class="row">
			<div class="col">
				<h4>Barang terlaris <a class="ml-2" href="page-katalog.php">Lihat Semua</a></h4>
			</div>
		</div>
		<div class="card-deck">
			<?php 
				foreach($product as $row):?>
			<a href="page-item.php?product=<?= $row["kodeProduk"];?>">
				<div class="card">
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
		</div>
	</div>
	<?php 	
		// var_dump($gifselling);
		if(!isset($userID) OR $gifselling['status'] != 'seller'){?>
				<div class="row chevron-down">
					<div class="col-md-12">
						<?php if(!isset($userID)){ ?>
							<a id="trigger-login-gif" href=""><img class="" src="assets/Mari jual barangmu.gif"/></a>
						<?php }else{ ?>
							<a href="page-jual-barang.php?check=new" class=""><img class="" src="assets/Mari jual barangmu.gif" alt="Transformative Thinking" /></a>
						<?php } ?>
					</div>
				</div>
	<?php }?>

	<?php
	if(isset($_GET['payment'])){
	?>
	<!-- Modal -->
	<div class="modal fade show in" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title blue" id="staticBackdropLabel">Pembayaran</h5>
                <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <form id="edit" method="POST" action="" enctype="multipart/form-data">
                        <tr>
                            <td class="head">
                                Nomer Telepon
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="fullname" value="<?=$nomer?>" readonly>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Nominal
                            </td>
                        </tr>
                        <tr>
                            <td>
								<?php
								?>
                                <input class="form-control" type="text" name="username" value="<?=number_format($harga,0,',','.')?>" readonly>
                            </td>
                        </tr>
                </table>
				<p class="mt-3">Saldo : <?=$saldo['saldo'];?></p>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button> -->
				<a href="index.php" class="btn btn-danger">Batal</a>
                <button type="submit" name="belipayment" class="btn btn-primary">Beli</button>
                <!-- <input type="submit" name="submit" value="Simpan"> -->
            </form>                
            </div>
        </div>
		<?php 
		}?>
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
			tabIndicator.style.left = `calc(calc(calc(calc(100%/3) - 5px) * ${i}) + 10px)`;
		});
		}
		let triggerloginGIF = document.querySelectorAll(".trigger-login-gif");
		for(let i=0;i<tabHeaderNodes.length;i++){
			triggerloginGIF[i].addEventListener('click', function onClick(event) {
				alert("Login terlebih dahulu!");
				// triggerloginGIF.onsubmit(false);
				<?php
				// header('location: index.php');
				?>
			});
		}
		let triggerloginGIF2 = document.querySelector("#trigger-login-gif");
		
			triggerloginGIF2.addEventListener('click', function onClick(event) {
				alert("Login terlebih dahulu!");
			});
		

	</script>

</body>
</html>