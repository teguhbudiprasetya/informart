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

    $sql = "SELECT product.namaProduk user.username, user.lokasi, cart.qty, cart.warna, cart.ukuran 
    FROM cart INNER JOIN detailsproduct USING(kodeItem) INNER JOIN product USING(kodeProduk) INNER JOIN user USING(kodeUser) WHERE kodeUser = $userID";
    $item = mysqli_fetch_assoc(mysqli_query($conn, $sql));
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
                <div class="cart-item row">
                    <div class="col-2">
                        <img class="d-block w-100" src="assets/erigo.jpg" alt="">
                    </div>
                    <div class="col-auto">
                        <p id="item-name">Cloth Jacket Erigo XY231B</p>
                        <p id="toko-name" class="mt-4">Erigo Official Store</p>
                        <small><i class="fa fa-map-marker" aria-hidden="true"></i> Jawa Timur</small>
                    </div>
                </div>
                <hr>
                <div class="cart-item row">
                    <div class="col-2">
                        <img class="d-block w-100" src="assets/kategori-celana-wanita.jpg" alt="">
                    </div>
                    <div class="col-auto">
                        <p id="item-name">Cloth Jacket Erigo XY231B</p>
                        <p id="toko-name" class="mt-4">Erigo Official Store</p>
                        <small><i class="fa fa-map-marker" aria-hidden="true"></i> Jawa Timur</small>
                    </div>
                </div>
                <hr>
            </div> <!--ENDIV CART-ITEMS-->
        </div>
            
        <!-- </div> -->
        <div class="col-4">
            <div class="frame">
                <h6 id="jenis" style="font-weight: 900;">Pilih Jenis</h6>  
                <form action="">
                <label for="">Voucher</label>
                <select class="custom-select mb-2">
                    <option value="1" selected>S</option>
                    <option value="2">M</option>
                    <option value="3">L</option>
                    <option value="4">XL</option>
                    <option value="5">XXL</option>
                </select>
                <button type="submit" class="btn btn-outline-primary btn-sm btn-block mt-2 mb-2">Pilih Voucher</button>
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
                        100.000
                        </p>
                        <p id="discount-price">
                        0
                        </p>
                        <p id="deliv-price">
                        10.000
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-5">
                        <p style="font-weight: bold;">Total Harga</p>
                        <p style="margin-top: 10px;">Sisa Saldo</p>
                    </div>
                    <div class="col-7 text-right">
                        <p id="total-price" style="font-weight: bold;">
                        110.000
                        </p>
                        <p id="sisa-saldo" style="margin-top: 10px;">
                        2000
                        </p>
                    </div>
                </div>
                <form action="">
                <button id="bayar" type="submit">Bayar</button>
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