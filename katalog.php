<?php 
include 'config.php';
session_start();
 


if(isset($_SESSION['username'])){
	$userName = $_SESSION['username'];
}
if(isset($_GET['cari'])){
    $cari = $_GET['cari'];
    $sql = "SELECT product.*, user.lokasi FROM product INNER JOIN user USING(kodeUser) WHERE namaProduk LIKE '%".$cari."%'";
    $product = mysqli_query($conn, $sql);
    if(!$product){
        echo "<script>
        alert('GAgal')
        </script>
        ";
    }
}elseif(isset($_GET['kategori'])){
    $kategori = $_GET['kategori'];
    $sql = "SELECT product.*, user.lokasi FROM product INNER JOIN user USING(kodeUser) WHERE kategori LIKE '%".$kategori."%'";
    $product = mysqli_query($conn, $sql);
    if(!$product){
        echo "<script>
        alert('GAgal')
        </script>
        ";
    }

}
// echo "<script>
//         alert(".var_dump($product).")
//         </script>
//         ";

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
    width: 100px;
    height:5px;
    background: #0275d8;
    }

    .tabs .tab-body {
    position:relative;
    border-top:1px solid #ddd;
    }


    .card-deck{
		/* margin: 0 -5px; */
		margin: 15px 0 0 -15px;
        color: black;
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
    .frame{
    padding: 30px 20px 10px 20px;
    box-shadow: 1px 1px 5px 1px #d2d4d2;
    width: 90%;
    height: 320px;
    border-radius: 10px;   
    /* margin-right: 20px; */
    }
    .frame button{
        margin-top: 33px;
        margin-left: -20px;
        width: 118%;
        height: 45px;
        border: none;
        background-color: #0275d8;
        border-radius: 0 0 10px 10px;
        color: white;
        font-weight: 100;
    }
    .frame button:hover{
        background-color:#0275e8;

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
</style>
    
	<title></title>
</head>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-sm shadow" style="height: 50px;">
	  <a class="navbar-brand mr-5" href="index.php">Informart</a>
	  <form action="katalog.php" class="ml-5" style="width: 70%; margin-top:15px;">
		<div class="input-group">
        <input type="text" name="cari" class="form-control" placeholder="Cari barang disini!" value="<?php if(isset($cari)){ echo $cari;} ?>" aria-label="Cari barang disini!" aria-describedby="basic-addon2" required>
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
    <div class="row justify-content-center">
        <div class="col-3">
            <h5>Filter</h5>
            <div class="frame">
                <h6 id="jenis" style="font-weight: 900;">Pilih Jenis</h6>  
                <label for="">Lokasi</label>
                <form action="">
                <select class="custom-select mb-2">
                    <option value="1" selected>Jakarta Pusat</option>
                    <option value="2">Jakarta Barat</option>
                    <option value="3">Jakarta Timur</option>
                    <option value="4">Jakarta Utara</option>
                    <option value="5">Jakarta Selatan</option>
                </select>
                <label for="">Harga Minimum</label>
                <input type="number" class="form-control">
                <label for="">Harga Maksimum</label>
                <input type="number" class="form-control">
                
                <button type="submit">Cari</button>
                </form>
            </div>
        </div>

        <div class="col-9">
            <div class="tabs">
                <div class="tab-header">
                        <h5 class="ml-3">Produk</h5>
                </div>

                <div class="tab-indicator"></div>
                    <div class="tab-body">
                        <div class="active">
                            <!-- SECTION produk tab -->
                            <!-- <a href="item.php" style="margin-top: 50px; background-color:blue;">hayoo</a> -->
                            <div class="card-deck">
                            <?php 
                                
                                if(mysqli_num_rows($product) > 0){
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
                                }
                                else{ ?>
                                    <h4 class="ml-3">Pencarian anda tidak dapat ditemukan!</h4 class="ml-3">
                                <?php }
                            ?>				
					
		                    </div> <!-- card deck-->
                        </div> <!-- active-->
                    </div> <!-- div body-->
                </div> <!-- div indicator-->
            </div> <!--Payment-sec -->
        </div> <!--div col-9 -->
    </div>

	<script>
	</script>

</body>
</html>