<?php
    include 'config.php';
    session_start();

    $userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];
    // NOTE total chart/keranjang display num
    $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $cartStack = $cart['COUNT(id)'];	
	$gifselling = mysqli_fetch_assoc(mysqli_query($conn,"SELECT status FROM user WHERE kodeUser = $userID"));

    $sql = "SELECT saldo FROM user WHERE kodeUser = $userID";
    $saldo = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $sql = "SELECT user.*, provinsi.namaProvinsi AS provinsi FROM user INNER JOIN provinsi USING(idProvinsi) WHERE kodeUser = $userID";
    $profile = mysqli_query($conn, $sql);
    $p = mysqli_fetch_assoc($profile);

    $sql = "SELECT status FROM user WHERE kodeUser = $userID";
    $statusSeller = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $statusSeller = $statusSeller['status'];

    if($_GET['check'] == 'lama'){
        $sql = "SELECT * FROM product WHERE kodeUser = $userID";
        $items = mysqli_query($conn,$sql);
    }
    if(isset($_POST['cariProduk'])){
        $_SESSION['kodeProduk'] = $_POST['produk'];
        $kodeProduk = $_POST['produk'];
        $sql = "SELECT * FROM product WHERE kodeProduk = '$kodeProduk'";
        $itemSelected = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        // var_dump($itemSelected);die();
    }

    if(isset($_POST['submitNew'])){
        // $gambar = $_FILES['hay'];
        // var_dump($_POST['hay']);die();
        $namaProduk = $_POST['namaProduk'];
        $kategori = $_POST['kategori'];
        $berat = $_POST['berat'];
        $ukuran = $_POST['ukuran'];
        $warna = $_POST['warna'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        // var_dump($_FILES['berkas']);die();

        if(checkFotoProduk()){
            $insertProduct = "INSERT INTO product VALUES ('', '$namaProduk', '$berat','$kategori', '$deskripsi','', '$userID', '$harga', 0, 0)";
            mysqli_query($conn, $insertProduct)or trigger_error("Query Failed! SQL: $insertProduct - Error: ".mysqli_error($conn), E_USER_ERROR);
            $sql = mysqli_query($conn, "SELECT max(kodeProduk) AS last FROM product");
            $last = mysqli_fetch_object($sql);
            $kodeProduk = (int)$last->last;
            // var_dump($kodeProduk);die();
            uploadFotoProduk($kodeProduk);
            
            $insertDetailsProduct = "INSERT INTO detailsproduct VALUES ('', $kodeProduk, '$ukuran', '$warna', $stok)";
            mysqli_query($conn, $insertDetailsProduct)or trigger_error("Query Failed! SQL: $insertDetailsProduct - Error: ".mysqli_error($conn), E_USER_ERROR);

            echo"
            <script>
            alert('Produk berhasil ditambahkan!');
                </script>
            ";
        }
    }

    if(isset($_POST['submitOld'])){
        $kodeProduk = $_SESSION['kodeProduk'];
        $newUkuran = $_POST['ukuran'];
        $newWarna = $_POST['warna'];
        $newStok = $_POST['stok'];
        $checkDetailsProduct = mysqli_query($conn, "SELECT * FROM detailsproduct WHERE kodeProduk = '$kodeProduk' AND warna = '$newWarna' AND ukuran = '$newUkuran'");
        if(exist($checkDetailsProduct)){
            $insertNewDetailsProdcut = "INSERT INTO detailsproduct VALUES ('','$kodeProduk', '$newUkuran', '$newWarna', '$newStok')";
            mysqli_query($conn, $insertNewDetailsProdcut)or trigger_error("Query Failed! SQL: $insertNewDetailsProdcut - Error: ".mysqli_error($conn), E_USER_ERROR);

            echo"
            <script>
            alert('Produk berhasil ditambahkan!');
                </script>
            ";
        }else{
            echo"
            <script>
            alert('Data produk dengan ukuran dan warna tersebut sudah ada!');
                </script>
            ";
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
        <title>Profil</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
            body{
		        font-family: 'Roboto';
            }
            ::-webkit-scrollbar{
                display: none;
            }
            li{
                list-style-type:none;
                margin-left: -20px;
                margin-top: 5px ;
                font-size: large;
                /* font-weight: bold; */
            }
            .box{
                color: #96a9b3;
                margin-left: -2px;
            }
            .box a{
                color: #96a9b3;
                /* margin-left: -2px; */
            }
            .box a:hover{
                color: #007bff;
                /* margin-left: -2px; */
            }
            .box:hover{
                color: #007bff;
            }
            li:hover{
                cursor: pointer;
            }
            .box-active{
                color: #007bff;
                background-color: white;
            }
            .box-active:hover{
                background-color: #007bff;
                color: white;
            }
            .blue{
                color: #007bff;
            }
            .card-body{
                /* padding:0px 2px 2px 4px; */
                padding-top: 0;
                padding-bottom: 0;
                margin-left: 8px;
                border: none;
                border-color: #007bff;
            }
            .focus:focus{
            outline: 0 !important;
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0) !important;
            }
            .box a ,.card-body a{
                text-decoration: none;
            }
            .card-body a{
                font-size: medium;
                margin-top: 10px;
                color: #96a9b3;
            }
            .card-body a:hover{
                color: #007bff;
            }
            .row .col-9 input, .row .col-9 textarea, .row .col-9 select{
                outline: #007bff;
                border-color: #007bff;
            }
            form, form small{
                font-weight: 600;
            }
            </style>
    </head>
    <body>
        <?php include "nav.php"; ?>

        <div class="main pt-1">
            <div class="row mt-5">
                <div class="col-2 shadow vh-100">
                    <ul class="mt-2">
                        <li>
                            <a href="page-topup.php" class="btn btn-success mb-2" style="width: 100%; text-align:left;">Rp. <?=number_format($saldo['saldo'],0,',',',')?> </a>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="page-profil.php">
                                    <i class="fa fa-user-o blue" aria-hidden="true"></i>  &nbsp;Profile
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a class="box focus" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-shopping-basket blue" aria-hidden="true"></i>
                                &nbsp;Pembelian
                                </a>
                                    <div class="collapse" id="collapseExample" >
                                        <div class="card card-body">
                                            <a href="page-pesanan.php?check=proses">Proses</a>
                                            <a href="page-pesanan.php?check=deliv">Sedang dikirim</a>
                                            <a href="page-pesanan.php?check=done">Selesai</a>
                                        </div>
                                    </div>
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="page-voucher.php">
                                <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                &nbsp;Voucher
                                </a>
                            </div>
                        </li>
                        <?php
                        if($statusSeller == 'seller' OR $statusSeller == 'admin'){?>
                            <li>
                                <div class="box p-2">
                                    <a href="seller-barang-penjualan.php">
                                    <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                    &nbsp;Barang penjualan
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="box p-2">
                                    <a class="box focus" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none;">
                                    <i class="fa fa-shopping-basket blue" aria-hidden="true"></i>
                                    &nbsp;Pesanan
                                    </a>
                                </div>
                                <div class="collapse" id="collapseExample2" >
                                    <div class="card card-body">
                                        <a href="seller-pesanan-customer.php?check=proses">Proses</a>
                                        <a href="seller-pesanan-customer.php?check=deliv">Sedang dikirim</a>
                                        <a href="seller-pesanan-customer.php?check=done">Selesai</a>
                                    
                                    </div>
                                </div>
                            </li>
                        <?php 
                        }
                        ?>
                        <li>
                            <div class="box-active rounded p-2 shadow">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                                &nbsp;Jual Barang
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-10">
                    <div class="row pt-4 ml-4">
                        <div class="col-10">
                            <small class="h3 blue">Jual Barang</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row ml-4 pl-3">
                        
                        <div class="col-9 mb-5">
                            <a href="page-jual-barang.php?check=new" class="btn btn-secondary btn-sm" style="margin-left: -15px;">Baru
                            </a>
                            <a href="page-jual-barang.php?check=lama" class="btn btn-dark btn-sm">Lama
                            </a>
                            <br>
                            <small class="font-italic text-danger" style="margin-left: -15px;">Info</small><br>
                            <small class="font-italic" style="margin-left: -15px;">Baru : menambahkan produk baru</small><br>
                            <small class="font-italic" style="margin-left: -15px;">Lama : menambahkan jenis baru dari produk yang sudah ada</small><br>
                            <hr>
                            <?php
                            if($_GET['check'] == 'new'){
                            ?>
                            <div class="row mt-3" id="newProduk"> <!--ANCHOR NEW PRODUCT-->
                                <form action="" method="POST" enctype="multipart/form-data" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-3">
                                            Nama Produk
                                        </div>
                                        <div class="col-auto">
                                            Kategori
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3">
                                            <input type="text" name="namaProduk" class="form-control form-control-sm">     
                                        </div>
                                        <div class="col-auto">
                                            <select name="kategori" class="form-control form-control-sm">
                                                <option value="Jaket">Jaket</option>
                                                <option value="Baju Pria">Baju Pria</option>
                                                <option value="Baju Wanita">Baju Wanita</option>
                                                <option value="Celana Pria">Celana Pria</option>
                                                <option value="Celana Wanita">Celana Wanita</option>
                                                <option value="Sepatu">Sepatu</option>
                                                <option value="Topi">Topi</option>
                                                <option value="Tas">Tas</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-1">
                                            Berat
                                        </div>
                                        <div class="col-1">
                                            <input type="text" name="berat" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-1" style="margin-left: -25px;">
                                            <small>Kg</small>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-1">
                                            Ukuran
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="ukuran" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-1">
                                            Warna
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="warna" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-1">
                                            Stok
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="stok" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-1">
                                            Harga
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="harga" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-1">
                                            Deskripsi
                                        </div>
                                        <div class="col-8">
                                            <textarea name="deskripsi" id="" cols="100" rows="3" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row align-items-center mt-2">
                                        <div class="col-1">
                                            Gambar
                                        </div>
                                        <div class="col-8">
                                            <input class="btn btn-primary btn-sm" type="file" name="berkas">
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit" name="submitNew">Tambahkan produk</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                            }else{
                            ?>
                            <div class="row mt-3" id="oldProduk"> <!--ANCHOR OLD PRODUCT-->
                                <form action="" method="POST" style="width: 100%;">
                                    <div class="row">
                                        <div class="col-3">
                                            Cari Produk
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <form action="" method="POST">
                                            <div class="col-3">
                                                <select name="produk" class="form-control form-control-sm">
                                                    <?php 
                                                    foreach($items as $row){
                                                    echo "<option value='$row[kodeProduk]'>$row[kodeProduk] - $row[namaProduk]</option>";
                                                    }?>
                                                </select>
                                            </div>
                                            <div class="col-auto" style="margin-left: -50px; ">
                                                <button type="submit" name="cariProduk" class="btn btn-primary btn-sm">Cari</button>
                                            </div>
                                    </div>
                                </form>
                                
                                
                                <?php if(isset($_POST['cariProduk'])){?>
                                <div class="border border-primary p-3 rounded" style="width: 700px;">
                                    <div class="row">
                                        <div class="col-4">
                                                Nama Produk
                                            </div>
                                            <div class="col-4">
                                                Kategori
                                            </div>
                                            <div class="col-4">
                                                Harga
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <input type="text" name="namaProduk" class="form-control form-control-sm" value="<?=$itemSelected['namaProduk']?>" readonly>     
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="kategori" class="form-control form-control-sm" value="<?=$itemSelected['kategori']?>" readonly>     
                                            </div>
                                            <div class="col-4">
                                                <input type="text" name="harga" class="form-control form-control-sm" value="<?=$itemSelected['harga']?>" readonly>     
                                            </div>
                                        </div>
                                    <form action="" method="POST">
                                    <div class="row align-items-center mt-2">
                                        <div class="col-2">
                                            Ukuran
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="ukuran" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-2">
                                            Warna
                                        </div>
                                        <div class="col-2">
                                            <input type="text" name="warna" class="form-control form-control-sm" required>
                                        </div>
                                        <div class="col-2">
                                            Stok
                                        </div>
                                        <div class="col-2">
                                            <input type="number" name="stok" class="form-control form-control-sm" required>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit" name="submitOld">Tambahkan produk</button>
                                        </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>