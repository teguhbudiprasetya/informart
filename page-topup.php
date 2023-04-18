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

    $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE kodeUser = $userID"));
    $now = date('Y-m-d');

    if(isset($_POST['topup'])){
        // $nomer = $_POST['notelp'];
		$id = $_POST['saldo'];
		$sql = "SELECT harga, kodeProduk FROM product INNER JOIN detailsproduct USING(kodeProduk) WHERE kodeItem = $id";
		$topUp = mysqli_fetch_assoc(mysqli_query($conn,$sql));
		// var_dump($topUp);die();
		$harga = (int)$topUp['harga'];
        $kodeProduk = (int)$topUp['kodeProduk'];
		$sql = "INSERT INTO tbl_order VALUES ('', $userID, 'selesai', '$now', '$now', $harga, 0, 0 )";
		$insertOrder = mysqli_query($conn,$sql)or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($conn), E_USER_ERROR);
		if($insertOrder){
			$sql = mysqli_query($conn, "SELECT max(transaksiID) AS last FROM tbl_order");
            // $last = $sql2['last'];
            $last = mysqli_fetch_object($sql);
            $next = (int)$last->last;

            $TopSaldo = "UPDATE user SET saldo = saldo + ($harga*2) WHERE kodeUser = $userID";
            mysqli_query($conn, $TopSaldo)or trigger_error("Query Failed! SQL: $inserdetails - Error: ".mysqli_error($conn), E_USER_ERROR);

			$inserdetails = "INSERT INTO orderdetails VALUES ('', $id, 1, $harga, $next, 0, 0, 'selesai',0)";
            mysqli_query($conn, $inserdetails)or trigger_error("Query Failed! SQL: $inserdetails - Error: ".mysqli_error($conn), E_USER_ERROR);

			// $TransaksiPembeli = "UPDATE user SET transaksi = transaksi + 1 WHERE kodeUser = $userID";
            // mysqli_query($conn, $TransaksiPembeli)or trigger_error("Query Failed! SQL: $TransaksiPembeli - Error: ".mysqli_error($conn), E_USER_ERROR);

			$productSold = "UPDATE product SET terjual = terjual + 1 WHERE kodeProduk = $kodeProduk";
			mysqli_query($conn, $productSold)or trigger_error("Query Failed! SQL: $productSold - Error: ".mysqli_error($conn), E_USER_ERROR);
			
			echo    "<script>
                                alert('Pembelian berhasil!');
								window.location.replace('page-topup.php');
                        </script>";
			
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
    <?php include "nav.php"; ?>
    <div class="row justify-content-center">
        <div class="col-3">
            <!-- <h5>Filter</h5>
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
            </div> -->
        </div>

        <div class="col-6 ">
            <div class="tabs">
                <div class="tab-header">
                        <h5 class="ml-3">Top Up Saldo</h5>
                </div>

                <div class="tab-indicator"></div>
                    <div class="tab-body">
                        <div class="active p-1">
                            <table class="table">
                                <tr>
                                    <td>Nama</td>
                                    <td>: <?=$data['fullname']?> </td>
                                </tr>
                                <tr>
                                    <td>Saldo</td>
                                    <td class="font-weight-bold">: Rp. <?=number_format($data['saldo'],0,',','.')?> </td>
                                </tr>
                            </table>
                            <hr color="#0275d8" style="height:5px">
                            <form action="page-topup.php" method="POST">
                            <table class="table">
                                
                                <tr>
                                    <td>Top Up Saldo</td>

                                    <td><input type="radio" value="25" name="saldo"> 500.000 </td>
                                    <td><input type="radio" value="26" name="saldo"> 1.000.000 </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="p-0">
                                        <input type="submit" name="topup" class="btn btn-primary" style="width: 100%;" value="Top Up">
                                    </td>
                                    <!-- <td class="font-weight-bold">: Rp. <?=number_format($data['saldo'],0,',','.')?> </td> -->
                                </tr>
                            </table>
                            </form>
                        </div> <!-- #SECTION active-->
                    </div> <!-- #SECTION div body-->
                </div> <!-- #SECTION div indicator-->
        </div> <!-- #SECTION div col-9 -->
        <div class="col-3">
                            
        </div>
    </div>

	<script>
	</script>

</body>
</html>