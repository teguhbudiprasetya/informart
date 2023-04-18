<?php
    include 'config.php';
    session_start();

    $userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];
    // NOTE total chart/keranjang display num
    $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $cartStack = $cart['COUNT(id)'];	
    
    $sql = "SELECT product.kodeProduk, product.namaProduk, product.gambar, product.harga, product.kategori, product.terjual,detailsproduct.kodeItem, detailsproduct.ukuran, detailsproduct.warna, detailsproduct.stok FROM product INNER JOIN detailsproduct USING(kodeProduk) WHERE kodeUser = $userID";
    $items = mysqli_query($conn, $sql);
    // $items = mysqli_fetch_assoc($items);
    // var_dump($items['kodeProduk']);die();

    $sql = "SELECT saldo FROM user WHERE kodeUser = $userID";
    $saldo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $sql = "SELECT status FROM user WHERE kodeUser = $userID";
    $statusSeller = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $statusSeller = $statusSeller['status'];

    if(isset($_GET['item'])){
        $kodeItem = $_GET['item'];
        $sql = "SELECT product.kodeProduk, product.namaProduk, product.gambar, product.harga,detailsproduct.kodeItem, detailsproduct.ukuran, detailsproduct.warna, detailsproduct.stok, product.deskripsi FROM product INNER JOIN detailsproduct USING(kodeProduk) WHERE detailsproduct.kodeItem = $kodeItem";
        $itemEdit = mysqli_fetch_assoc(mysqli_query($conn, $sql));
        // var_dump($itemEdit);die();
    }

    if(isset($_POST['edit'])){
        $kodeItem = $_POST['kodeItem'];
        $kodeProduk = $_POST['kodeProduk'];
        $namaProduk = $_POST['namaProduk'];
        $gambar = $_FILES['berkas'];
        $ukuran = $_POST['ukuran'];
        $warna = $_POST['warna'];
        $stok = $_POST['stok'];
        $harga = $_POST['harga'];
        $deskripsi = $_POST['deskripsi'];
        
        // $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT kodeItem FROM kodeItem = $kodeItem"));
        // $kodeItem = $sql['kodeItem']

        if($gambar['error'] == 0){
            if(uploadFotoProduk($kodeProduk)){
                
                $updateProduct = "UPDATE product SET namaProduk = '$namaProduk', harga = '$harga', deskripsi = '$deskripsi' WHERE kodeProduk = '$kodeProduk'";
                mysqli_query($conn, $updateProduct)or trigger_error("Query Failed! SQL: $updateProduct - Error: ".mysqli_error($conn), E_USER_ERROR);
                
                $updatedetailsProduct = "UPDATE detailsproduct SET ukuran = '$ukuran', warna = '$warna', stok = '$stok' WHERE kodeItem = '$kodeItem'";
                mysqli_query($conn, $updatedetailsProduct)or trigger_error("Query Failed! SQL: $updatedetailsProduct - Error: ".mysqli_error($conn), E_USER_ERROR);

                echo "
                <script>
                    window.location.replace('seller-barang-penjualan.php');
                </script>
                ";
            }
        }else{
            
            $updateProduct = "UPDATE product SET namaProduk = '$namaProduk', harga = '$harga', deskripsi = '$deskripsi' WHERE kodeProduk = '$kodeProduk'";
            mysqli_query($conn, $updateProduct)or trigger_error("Query Failed! SQL: $updateProduct - Error: ".mysqli_error($conn), E_USER_ERROR);
            
            $updatedetailsProduct = "UPDATE detailsproduct SET ukuran = '$ukuran', warna = '$warna', stok = '$stok' WHERE kodeItem = '$kodeItem'";
            mysqli_query($conn, $updatedetailsProduct)or trigger_error("Query Failed! SQL: $updatedetailsProduct - Error: ".mysqli_error($conn), E_USER_ERROR);
            
            echo "
            <script>
                window.location.replace('seller-barang-penjualan.php');
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
        <title>Pesanan | Proses</title>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
 
            .modal{
                display: block;
            }
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
                margin-left: -2px;
            }
            .box a{
                color: #96a9b3;
            }
            .box:hover a{
                color: #007bff;
            }
            li:hover{
                cursor: pointer;
            }
            .box-active{
                background-color: white;
                margin-left: -5px;
            }
            .box-active a{
                color: #007bff;
            }
            .box-active:hover{
                background-color: #007bff;
                color: white;
            }
            .box-active:hover i{
                /* background-color: #007bff; */
                color: white;
            }
            .box-active:hover a{
                /* background-color: #007bff; */
                color: white;
                text-decoration: none;
            }
            .blue{
                color: #007bff;
            }
           
            .col-10 p{
                margin-bottom: 0px;
                /* font-size: small; */
            }

            #card{
                /* padding:0px 2px 2px 4px; */
                padding-top: 0;
                padding-bottom: 0;
                margin-left: 8px;
                border: none;
                border-color: #007bff;
            }
            .box a ,#card a{
                text-decoration: none;
            }
            #card a{
                font-size: medium;
                margin-top: 10px;
                color:#96a9b3;
            }
            #card a:hover{
                color: #007bff;
            }
            a{
                text-decoration: none;
            }
            .col-2 img{
                height: 140px;
            }
            .modal-body .head{
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
                                <a class="box focus" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" style="text-decoration: none;">
                                <i class="fa fa-shopping-basket blue" aria-hidden="true"></i>
                                &nbsp;Pembelian
                                </a>
                            </div>
                            <div class="collapse" id="collapseExample" >
                                <div class="card card-body" id="card">
                                    <a href="page-pesanan.php?check=proses">Proses</a>
                                    <a href="page-pesanan.php?check=deliv">Sedang dikirim</a>
                                    <a href="page-pesanan.php?check=done">Selesai</a>
                                
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a class="box focus" href="page-voucher.php">
                                <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                &nbsp;Voucher
                                </a>
                            </div>
                        </li>
                        <?php
                        if($statusSeller == 'seller' OR $statusSeller == 'admin'){?>
                            <li>
                                <div class="box-active shadow-lg rounded p-2">
                                    <a href="seller-barang-penjualan.php">
                                    <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                    &nbsp;Barang Penjualan
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
                                    <div class="card card-body" id="card">
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
                            <div class="box p-2">
                                <a href="page-jual-barang.php?check=new">
                                <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                &nbsp;Jual Barang
                                </a>
                            </div>
                        </li>   
                    </ul>
                </div>
                <div class="col-9">
                    <div class="row pt-4 ml-4">
                        <div class="col-10">
                            <small class="h3 blue">Barang Penjualan</small>
                            <br>
                            <!-- <small style="color: #96a9b3;" class="font-italic">Pesanan > Proses</small> -->

                        </div>
                    </div>
                    <hr>
                    
                    <div class="container p-2">
                        <div class="cart-items">
                            <?php 
                            foreach($items as $row){
                            ?>
                            <div class="cart-item row rounded shadow p-4">
                                <div class="col-2">
                                        <img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt="">
                                    </div>
                                    <div class="col-10">
                                        <!-- <br> -->
                                        <a href="delete-product.php?id=<?=$row['kodeItem']?>" class="float-right btn btn-danger btn-sm ml-1">Hapus</a>
                                        <a href="seller-barang-penjualan.php?item=<?=$row['kodeItem']?>" class="float-right btn btn-primary btn-sm">Edit</a>
                                        <!-- <br> -->
                                        <!-- <small class="float-right btn-primary btn-sm">Edit</small> -->
                                        <p id="item-name" class="font-weight-bold mb-3 h5"><?=$row['namaProduk'];?></p>
                                        <!-- <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                        <br>
                                        <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargasatuan'],0,',','.');?></span></small>
                                        <br> -->
                                        <table>
                                            <tr>
                                                <td>
                                                    <p class="head">Stok</p>
                                                </td>
                                                <td>
                                                    <p class="font-weight-bold" style="color: black;"> : <?=$row['stok'];?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="head">
                                                    <p>Ukuran</p>
                                                </td>
                                                <td>
                                                    <p class="font-weight-bold" style="color: black;"> : <?=$row['ukuran'];?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="head">
                                                    <p>Warna</p>
                                                </td>
                                                <td>
                                                    <p class="font-weight-bold" style="color: black;"> : <?=$row['warna'];?></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="head">
                                                    <p>Terjual</p>
                                                </td>
                                                <td>
                                                    <p class="font-weight-bold" style="color: black;"> : <?=$row['terjual'];?></p>
                                                </td>
                                            </tr>
                                        </table>
                                        <p class="float-right h6">Harga barang: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['harga'],0,',','.');?></span></p>
                                        <br>
                                    </div>
                                </div>
                            <br>
                            <?php } ?>
                            </div>

                        </div> 
                    </div>
                </div>
            </div>
        </div>
        
        <?php 
        if(isset($_GET['item'])){
        ?>
            <!-- Modal -->
            <div class="modal fade show in" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title blue" id="staticBackdropLabel">Edit profile</h5>
                            <!-- <span aria-hidden="true">&times;</span> -->
                            </button>
                        </div>
                        <div class="modal-body">
                            <table>
                                <form id="edit" method="POST" action="seller-barang-penjualan.php" enctype="multipart/form-data">
                                    <tr style="display:none;">
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="kodeProduk" value="<?=$itemEdit['kodeProduk']?>" required>
                                        </td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td>
                                            <input class="form-control form-control-sm" type="number" name="kodeItem" value="<?=$kodeItem?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="head">
                                            Nama Produk
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <input class="form-control form-control-sm" type="text" name="namaProduk" value="<?=$itemEdit['namaProduk']?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="head" width="70">
                                            Ukuran
                                        </td>
                                        <td width="50">
                                            <input class="form-control form-control-sm" type="text" name="ukuran" value="<?=$itemEdit['ukuran']?>" required>
                                        </td>
                                        <td class="head" >
                                            Warna
                                        </td>
                                        <td width="70">
                                            <input class="form-control form-control-sm" type="text" name="warna" value="<?=$itemEdit['warna']?>" required>
                                        </td>
                                        <td style="visibility: hidden;">
                                            sdadadjadjasdadas
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="head">
                                            Stok
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <input class="form-control form-control-sm" type="number" min="0" name="stok" value="<?=$itemEdit['stok']?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="head">
                                            Gambar
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <input class="btn btn-primary btn-sm" type="file" name="berkas">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="head">
                                            Harga
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <input class="form-control form-control-sm" type="number" name="harga" min="0" value="<?=$itemEdit['harga']?>" style="width:450px;" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" class="head">
                                            Deskripsi
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">
                                            <textarea class="form-control form-control-sm" name="deskripsi" id="" cols="30" rows="5" required><?=$itemEdit['deskripsi']?></textarea>
                                        </td>
                                    </tr>
                                
                            </table>
                        </div>
                        <div class="modal-footer">
                            <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button> -->
                            <a href="seller-barang-penjualan.php" class="btn btn-danger">Batal</a>
                            <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                            <!-- <input type="submit" name="submit" value="Simpan"> -->
                        </form>                
                        </div>
                    </div>
                </div>
            </div><!--End Model ANCHOR-->
        <?php
        }
        ?>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
            $("#staticBackdrop").modal('show');
        </script>
    </body>
</html>