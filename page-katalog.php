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

if(isset($_GET['cari'])){ #NOTE Buka fitur katalog menggunakan button cari
    $cari = $_GET['cari'];
    $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE namaProduk LIKE '%".$cari."%' OR kategori LIKE '%".$cari."%'";
    $product = mysqli_query($conn, $sql);
    if(!$product){
        echo "<script>
        alert('GAgal')
        </script>
        ";
    }
}
elseif(isset($_GET['kategori'])){ #NOTE Buka fitur katalog menggunakan kategori button di homepage
    $kategori = $_GET['kategori'];
    $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE kategori LIKE '%".$kategori."%'";
    $product = mysqli_query($conn, $sql);
    if(!$product){
        echo "<script>
        alert('GAgal')
        </script>
        ";
    }
}else{
    $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE product.kategori != 'payment' AND product.kategori != 'payment-saldo' ORDER BY product.terjual DESC";
    $product = mysqli_query($conn, $sql);
}

if(isset($_POST['submit'])){ //NOTE box filter
    $minPrice = $_POST['inputMin'];
    $maxPrice = $_POST['inputMax'];
    $provinsi = $_POST['provinsi'];
    if($minPrice > $maxPrice){
        echo "<script>
            alert('Harga minimum tidak dapat lebih besar dari harga maksimal')
            </script>
            ";
    }else{
        if (!isset($_GET['cari']) AND !isset($_GET['kategori'])) {
            if($provinsi == '0'){
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE (product.harga >= $minPrice AND product.harga <= $maxPrice) AND product.kategori != 'payment' AND product.kategori != 'payment-saldo' ORDER BY product.terjual DESC";
                $product = mysqli_query($conn, $sql)or trigger_error("Query Failed! SQL: $product - Error: ".mysqli_error($conn), E_USER_ERROR);
            }else{
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE (product.harga >= $minPrice AND product.harga <= $maxPrice) AND provinsi.idProvinsi = $provinsi AND product.kategori != 'payment' AND product.kategori != 'payment-saldo' ORDER BY product.terjual DESC";
                $product = mysqli_query($conn, $sql)or trigger_error("Query Failed! SQL: $product - Error: ".mysqli_error($conn), E_USER_ERROR);
            }
        }
        elseif(isset($_GET['cari'])){
            if($provinsi == '0'){
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE (namaProduk LIKE '%".$cari."%' OR kategori LIKE '%".$cari."%') AND (product.harga >= $minPrice AND product.harga <= $maxPrice)";
                $product = mysqli_query($conn, $sql);
                if(!$product){
                    echo "<script>
                    alert('GAgal')
                    </script>
                    ";
                }
            }else{
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE (namaProduk LIKE '%".$cari."%' OR kategori LIKE '%".$cari."%') AND (product.harga >= $minPrice AND product.harga <= $maxPrice) AND provinsi.idProvinsi = $provinsi";
                $product = mysqli_query($conn, $sql);
                if(!$product){
                    echo "<script>
                    alert('GAgal')
                    </script>
                    ";
                }
            }
            
        }
        elseif(isset($_GET['kategori'])){
            if($provinsi == '0'){
                // $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE (namaProduk LIKE '%".$cari."%' OR kategori LIKE '%".$cari."%') AND (product.harga >= $minPrice AND product.harga <= $maxPrice)";
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE kategori LIKE '%".$kategori."%' AND (product.harga >= $minPrice AND product.harga <= $maxPrice)";
                $product = mysqli_query($conn, $sql);
                if(!$product){
                    echo "<script>
                    alert('GAgal')
                    </script>
                    ";
                }
            }
            else{
                $kategori = $_GET['kategori'];
                $sql = "SELECT product.*, provinsi.namaProvinsi AS lokasi FROM product INNER JOIN user USING(kodeUser) INNER JOIN provinsi USING(idProvinsi) WHERE kategori LIKE '%".$kategori."%' AND (product.harga >= $minPrice AND product.harga <= $maxPrice) AND provinsi.idProvinsi = $provinsi";
                $product = mysqli_query($conn, $sql);
                if(!$product){
                    echo "<script>
                    alert('GAgal')
                    </script>
                    ";
                }
            }
        }
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
    <?php include "nav.php"; ?>
    <div class="row justify-content-center">
        <div class="col-3">
            <h5>Filter</h5>
            <div class="frame">
                <h6 id="jenis" style="font-weight: 900;">Pilih Jenis</h6>  
                <label for="">Lokasi</label>
                <form action="#" method="POST">
                    <select class="custom-select mb-2" name="provinsi">
                        <option value="0" selected>All</option>
                        <?php 
                            $provinsi = mysqli_query($conn, "SELECT * FROM provinsi");
                            foreach($provinsi as $lokasi){ ?>
                                <option value="<?=$lokasi['idProvinsi']?>"><?=$lokasi['namaProvinsi']?></option>
                            <?php 
                            }
                        ?>
                    </select>

                    <label for="">Harga Minimum</label>
                    <input id="multi1" class="form-control-range" value='1' min='10000' max="500000" step="10000" name="rangeInput" type="range" onchange="updateTextInputMin(this.value);" />
                    <input type="number" class="form-control" value="10000" id="inputMin" name="inputMin" readonly>
                    <label for="">Harga Maksimum</label>
                    <input id="multi2" class="form-control-range" value='500000' min='10000' max="500000" step="10000" name="rangeInput" type="range" onchange="updateTextInputMax(this.value);" />
                    <input type="number" value="500000" class="form-control" id="inputMax" name="inputMax" readonly>
                    
                    <button type="submit" name="submit">Cari</button>
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
                            <div class="card-deck">
                            <?php 
                                
                                if(mysqli_num_rows($product) > 0){
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
                                }
                                else{ ?>
                                    <h4 class="ml-3">Pencarian anda tidak dapat ditemukan!</h4 class="ml-3">
                            <?php }
                            ?>				
					
		                    </div> <!-- #SECTION card deck-->
                        </div> <!-- #SECTION active-->
                    </div> <!-- #SECTION div body-->
                </div> <!-- #SECTION div indicator-->
            </div> <!-- #SECTION Payment-sec -->
        </div> <!-- #SECTION div col-9 -->
    </div>

	<script>
        const range1 = document.getElementById('inputMin');
        const range2 = document.getElementById('inputMax');
        function updateTextInputMin(val) {
            range1.value=val;
        }
        function updateTextInputMax(val) { 
            range2.value=val; 
        }
	</script>

</body>
</html>