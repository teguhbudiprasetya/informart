<?php 
include 'config.php';
session_start();
 

if(isset($_SESSION['username'])){
	$userName = $_SESSION['username'];
}
// var_dump($userName);
$sql = "SELECT product.*, user.lokasi FROM product INNER JOIN user USING(kodeUser) LIMIT 6";
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
	body{
		font-family: 'Roboto';
	}
    #banner{
        box-shadow: 0px 0px 14px 1px gray;
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
  </style>
    
	<title></title>
</head>
<body>
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-sm shadow" style="height: 50px;">
	  <a class="navbar-brand mr-5" href="#">Informart</a>
	  <form action="katalog.php" class="ml-5" style="width: 70%; margin-top:15px;">
		<div class="input-group" method="GET" action="katalog.php">
			<input type="text" name="cari" class="form-control" placeholder="Cari barang disini!" aria-label="Cari barang disini!" aria-describedby="basic-addon2" required>
			<div class="input-group-append">
				<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> </button>
			</div>
		</div>
	  </form>
	  <div class="collapse navbar-collapse"  id="navbarText">
	    <ul class="navbar-nav ml-auto" style="margin-right: 100px;">
	      <li class="nav-item active " style="margin: 0px 10px;">
	        <a class="nav-link mt-1" href="cart.php"><i class="fa fa-shopping-cart aria-hidden='true' fa-lg"></i><span class="badge badge-primary">6</span></a>
	      </li>
		  <?php 
		  	if(!isset($userName)){ ?>
				<li class="nav-item" style="margin: 0px 5px; float:right;">
				  <button class="navbar-text btn btn-outline-primary btn-sm text-primary" href="#">Daftar</button>
				</li>
				<li class="nav-item" style="margin: 0px -90px 0px 0px;">
					<a class="navbar-text btn btn-primary btn-sm text-white" href="login.php">Masuk</a>
				</li>
				<?php } else{?>
				<li class="nav-item" style="margin: 0px 5px; float:right;">
					<button class="navbar-text btn btn-outline-primary btn-sm text-primary" href="#"><?= $userName?></button>
				</li>
				<li class="nav-item" style="margin: 0px -90px 0px 0px;">
				  <a class="navbar-text btn btn-primary btn-sm text-white" href="logout.php">Logout</a>
				</li>
			 <?php } ?>
	    </ul>
	  </div>
	</nav>
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
				<img class="d-block w-80" src="assets/jb1.jpg" alt="Los Angeles">
			</div>
			<div class="carousel-item">
				<img class="d-block w-80" src="assets/jb1.jpg" alt="Chicago">
			</div>
			<div class="carousel-item">
				<img class="d-block w-80" src="assets/jb1.jpg" alt="New York">
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
						<h4>Kategori Favorit <a class="ml-2" href="#">Lihat Semua</a></h4>
					</div>
					<div class="col">
						<h4>Beli & Bayar Tagihan <a class="ml-2" href="#">Lihat Semua</a></h4>
					</div>
				</div>
				<div id="submain-2" class="row mt-2">
					<div class="col">
						<div class="row">
							<div class="item-fav col">
								<a href="katalog.php?kategori=Baju+Wanita" name="baju_wanita"> <img src="assets/kategori-baju-wanita.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Baju+Pria"> <img src="assets/kategori-baju-pria.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Jam+Tangan"> <img src="assets/jam-tangan.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Topi"> <img src="assets/topi.jpg" alt=""> </a>
							</div>
						</div>
						<div class="row mt-4">
						<div class="item-fav col">
								<a href="katalog.php?kategori=Celana+Wanita"> <img src="assets/kategori-celana-wanita.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Celana+Pria"> <img src="assets/kategori-celana-pria.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Sepatu"> <img src="assets/sepatu.jpg" alt=""> </a>
							</div>
							<div class="item-fav col">
								<a href="katalog.php?kategori=Tas"> <img src="assets/tas.jpg" alt=""> </a>
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
											<input type="email" class="form-control" placeholder="">
											</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 141%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
											<select class="custom-select">
												<option selected hidden>Pilih nominal</option>
												<option value="1">10.000</option>
												<option value="2">15.000</option>
												<option value="3">20.000</option>
												<option value="4">50.000</option>
												<option value="5">100.000</option>
											</select>
											</div>
										</div>
										<div class="row mt-4 justify-content-end" style="width: 137%;">
											<div class="col-auto">
												<button type="submit" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
											</div>
										</div>
									</div>
									<div>
										<div class="row mt-2 justify-content-center" style="width: 158%;">
											<div class="col-4 align-self-center ml-3">
												No. Meter
											</div>
											<div class="col-7">
											<input type="email" class="form-control" placeholder="">
											</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 158%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
												<select class="custom-select">
												<option selected hidden>Pilih nominal</option>
												<option value="1">20.000</option>
												<option value="2">50.000</option>
												<option value="3">100.000</option>
												<option value="4">500.000</option>
												<option value="5">1.000.000</option>
											</select>
											</div>
										<div class="row mt-4 justify-content-end" style="width: 94.2%;">
											<div class="col-auto">
												<button type="submit" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
											</div>
										</div>
										</div>
									</div>
									<div>
									<div class="row mt-2 justify-content-center" style="width: 160%;">
											<div class="col-4 align-self-center ml-3">
												No. Kartu
											</div>
											<div class="col-7">
											<input type="email" class="form-control" placeholder="">
											</div>
										</div>
										<div class="row mt-2 justify-content-center" style="width: 160%;">
											<div class="col-4 align-self-center ml-3">
												Nominal
											</div>
											<div class="col-7">
												<select class="custom-select">
												<option selected hidden>Pilih nominal</option>
												<option value="1">20.000</option>
												<option value="2">50.000</option>
												<option value="3">100.000</option>
												<option value="4">500.000</option>
												<option value="5">1.000.000</option>
												</select>
											</div>
										<div class="row mt-4 justify-content-end" style="width: 94.2%;">
											<div class="col-auto">
												<button type="submit" class="btn btn-sm btn-primary" style="width: 50px;">Beli</button>
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
	</div>

	<!-- SECTION official store items -->
	<div id="main-2" class="container mt-4 mb-5">
		<div id="text-header" class="row">
			<div class="col">
				<h4>Official Store <a class="ml-2" href="#">Lihat Semua</a></h4>
			</div>
		</div>
		<div class="card-deck">
			<?php 
				foreach($product as $row):?>
			<a href="item.php?product=<?= $row["kodeProduk"];?>">
				<div class="card">
					<img class="card-img-top" src="assets/<?= $row["gambar"]?>" alt="Card image cap">
					<div class="card-body">
					<h5 class="card-title"><?= $row["namaProduk"]?></h5>
					<p class="card-text price-text">Rp. <?= $row["harga"]?></p>
					<p class="card-location"><i class="fa fa-map-marker" aria-hidden="true" style="color: red;"></i> &nbsp;<?= $row["lokasi"]?></p>
					<p class="card-rating"><i class="fa fa-star" aria-hidden="true" style="color: yellow;"></i> <?= $row["rating"]?> | <?= $row["terjual"]?></p>
					</div>
				</div>	
			</a>					
			<?php 
			endforeach ;
			?>
		</div>
	</div>

	<!-- SECTION official store brand -->
	<!-- <div id="main-2" class="container mt-4">
		<div id="text-header" class="row">
			<div class="col">
				<h4>Brand Official Store</h4>
			</div>
		</div>
		<div class="row brand-row">
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
		</div>
		<div class="row brand-row mt-3">
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			<div class="col brand-tag">
				<a href="#"> <img class="img-fluid" src="assets/logo-vans.png" alt="" style="margin-top: 7px;"></a>
			</div>
			
		</div>
	</div> -->



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
	</script>

</body>
</html>