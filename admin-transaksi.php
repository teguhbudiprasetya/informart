<?php
    include 'config.php';
    session_start();

    // NOTE total chart/keranjang display num
    if(!isset($_SESSION['idadmin'])){
        header('location:admin-login.php');
    }

    $sql = "SELECT product.kodeProduk AS productCode,tbl_order.transaksiID, orderdetails.orderItemID, t1.kodeUser AS PenjualID, t1.username AS sellerName, tbl_order.kodeUser AS PembeliID, t2.username AS PembeliName, t2.alamat AS alamatPembeli,
            product.namaProduk AS namaProduk, product.gambar AS gambar, product.kategori AS kategori ,tbl_order.tgl_beli AS tanggal, tbl_order.tgl_sampai, provinsi.namaProvinsi AS lokasi, orderdetails.detailsOngkir AS ongkir,
            orderdetails.qty AS qty, detailsproduct.warna AS warna, product.harga AS hargapayment,detailsproduct.ukuran AS ukuran ,orderdetails.harga AS hargasatuan ,orderdetails.detailsOngkir, 
            (orderdetails.qty*orderdetails.harga) AS harga FROM tbl_order INNER JOIN orderdetails USING(transaksiID) INNER JOIN detailsproduct 
            USING(kodeItem) INNER JOIN product USING(kodeProduk) INNER JOIN user AS t1 ON product.kodeUser = t1.kodeUser INNER JOIN provinsi USING(idProvinsi) INNER JOIN user AS t2 ON tbl_order.kodeUser = t2.kodeUser
            WHERE orderdetails.status = 'proses' ORDER BY orderdetails.orderItemID DESC";
    $proses = mysqli_query($conn, $sql);

    $sql = "SELECT product.kodeProduk AS productCode,tbl_order.transaksiID, orderdetails.orderItemID, t1.kodeUser AS PenjualID, t1.username AS sellerName, tbl_order.kodeUser AS PembeliID, t2.username AS PembeliName, t2.alamat AS alamatPembeli,
            product.namaProduk AS namaProduk, product.gambar AS gambar, product.kategori AS kategori ,tbl_order.tgl_beli AS tanggal, tbl_order.tgl_sampai, provinsi.namaProvinsi AS lokasi, orderdetails.detailsOngkir AS ongkir,
            orderdetails.qty AS qty, detailsproduct.warna AS warna, product.harga AS hargapayment,detailsproduct.ukuran AS ukuran ,orderdetails.harga AS hargasatuan ,orderdetails.detailsOngkir, 
            (orderdetails.qty*orderdetails.harga) AS harga FROM tbl_order INNER JOIN orderdetails USING(transaksiID) INNER JOIN detailsproduct 
            USING(kodeItem) INNER JOIN product USING(kodeProduk) INNER JOIN user AS t1 ON product.kodeUser = t1.kodeUser INNER JOIN provinsi USING(idProvinsi) INNER JOIN user AS t2 ON tbl_order.kodeUser = t2.kodeUser
            WHERE orderdetails.status = 'Sedang dikirim' ORDER BY orderdetails.orderItemID DESC";
    $deliv = mysqli_query($conn, $sql);

    $sql = "SELECT product.kodeProduk AS productCode,tbl_order.transaksiID, orderdetails.orderItemID, t1.kodeUser AS PenjualID, t1.username AS sellerName, tbl_order.kodeUser AS PembeliID, t2.username AS PembeliName, t2.alamat AS alamatPembeli,
            product.namaProduk AS namaProduk, product.gambar AS gambar, product.kategori AS kategori ,tbl_order.tgl_beli AS tanggal, tbl_order.tgl_sampai, provinsi.namaProvinsi AS lokasi, orderdetails.detailsOngkir AS ongkir,
            orderdetails.qty AS qty, detailsproduct.warna AS warna, product.harga AS hargapayment,detailsproduct.ukuran AS ukuran ,orderdetails.harga AS hargasatuan ,orderdetails.detailsOngkir, 
            (orderdetails.qty*orderdetails.harga) AS harga FROM tbl_order INNER JOIN orderdetails USING(transaksiID) INNER JOIN detailsproduct 
            USING(kodeItem) INNER JOIN product USING(kodeProduk) INNER JOIN user AS t1 ON product.kodeUser = t1.kodeUser INNER JOIN provinsi USING(idProvinsi) INNER JOIN user AS t2 ON tbl_order.kodeUser = t2.kodeUser
            WHERE orderdetails.status = 'selesai' ORDER BY orderdetails.orderItemID DESC";
    $done = mysqli_query($conn, $sql);
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
            .box-active:hover a{
                /* background-color: #007bff; */
                color: white;
                text-decoration: none;
            }
            .blue{
                color: #007bff;
            }
            #card{
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
            .box a ,#card a{
                text-decoration: none;
            }
            #card a{
                font-size: medium;
                margin-top: 10px;
                color:#96a9b3;
            }
            a{
                text-decoration: none;
            }
            #card a:hover{
                color: #007bff;
                text-decoration: none;
            }
            /* #toko-name{
            margin-bottom: -5px;
            font-size: 15px;
            } */
            .card-title{
                font-weight:600;
            }
            #toko-name{
                /* margin-bottom: -5px; */
                font-size: 15px;
            }
            #item-name{
            font-weight: 600;
            }
            .cart-item img{
                height: 150px;
            }
            table{
                font-size: small;
            }
        </style>
    </head>
    <body>
        <?php //include "nav.php"; ?>

        <div class="main pt-1">
            <div class="row">
                <div class="col-2 shadow vh-100">
                <ul class="mt-2">
                        <li>
                            <div class="box p-2">
                                <a href="admin-dashboard.php">    
                                    <i class="fa fa-tachometer blue" aria-hidden="true"></i>  &nbsp;Dashboard
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="box-active p-2 shadow-lg rounded">
                                <a class="box focus" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                &nbsp;Transaksi
                                </a>
                            </div>
                                <div class="collapse" id="collapseExample" >
                                        <div class="card card-body" id="card">
                                            <?php
                                            if($_GET['check'] == 'proses'){
                                            ?>
                                                <a href="" style="color: #007bff;">Proses</a>
                                                <a href="admin-transaksi.php?check=deliv">Sedang dikirim</a>
                                                <a href="admin-transaksi.php?check=done">Selesai</a>
                                            <?php }
                                            elseif($_GET['check'] == 'deliv'){?>
                                                <a href="admin-transaksi.php?check=proses" >Proses</a>
                                                <a href="" style="color: #007bff;">Sedang dikirim</a>
                                                <a href="admin-transaksi.php?check=done">Selesai</a>
                                            <?php
                                            }else{?>
                                                <a href="admin-transaksi.php?check=proses" >Proses</a>
                                                <a href="admin-transaksi.php?check=deliv">Sedang dikirim</a>
                                                <a style="color: #007bff;" href="">Selesai</a>
                                            <?php
                                            }
                                            ?>
                                        </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="admin-toko.php">
                                <i class="fa fa-home blue" aria-hidden="true"></i>
                                &nbsp;Daftar Toko
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="admin-customer.php">
                                <i class="fa fa-users blue" aria-hidden="true"></i>
                                &nbsp;Daftar Customer
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="admin-voucher.php">
                                <i class="fa fa-credit-card blue" aria-hidden="true"></i>
                                &nbsp;Daftar Voucher
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-9">
                    <div class="row pt-4 ml-4">
                        <div class="col-10">
                            <small class="h3 blue">Pembelian</small>
                            <br>
                            <?php
                            if($_GET['check'] == 'proses'){
                                ?>
                                <small style="color: #96a9b3;" class="font-italic">Pembelian > Proses</small>
                                <?php }
                            elseif($_GET['check'] == 'deliv'){?>
                                <small style="color: #96a9b3;" class="font-italic">Pembelian > Sedang dikirim</small>
                                <?php
                            }else{?>
                                <small style="color: #96a9b3;" class="font-italic">Pembelian > Selesai</small>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <hr>
                    
                    <div class="container p-2">
                        <?php 
                        if($_GET['check'] == 'proses'){
                        ?>
                        <!-- ANCHOR PROSES SECTION -->
                        <div class="cart-items">
                            <?php 
                            foreach($proses as $row){
                            ?>
                            <div class="cart-item row rounded shadow p-4">
                                <div class="col-2 mt-5">
                                    <a href="page-item.php?product=<?= $row["productCode"];?>"><img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt=""></a>
                                </div>
                                <div class="col-10">
                                    <small class="float-right font-italic"><?=$row['tanggal']?></small>
                                    <br>
                                    <small class="float-right btn-warning btn-sm">Proses</small>
                                    <p id="item-name"><?=$row['namaProduk'];?></p>
                                    <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                    <br>
                                    <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargasatuan'],0,',','.');?> x <?=$row['qty'];?></span></small>
                                    <br>
                                    <small class="float-right">Total harga: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['harga'] + $row['ongkir'] ,0,',','.');?></span></small>
                                    <small id="toko-name">Toko : <?=$row['sellerName'];?></small>
                                    <br>
                                    <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$row['lokasi'];?></small>
                                    <small class="float-right">Qty: <?=$row['qty'];?> | Warna: <?=$row['warna'];?> | Ukuran: <?=$row['ukuran'];?></small>
                                    <br>
                                </div>
                                <table class="table mt-4 text-sm">
                                    <tr>
                                        <td>ID Pembeli</td>
                                        <td><?=$row['PembeliID']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pembeli</td>
                                        <td><?=$row['PembeliName']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?=$row['alamatPembeli']?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                            <br>
                        </div> <!--ENDIV CART-ITEMS--> <!--//NOTE penutup proses section-->

                        <!-- ANCHOR DELIV SECTION  -->
                        <?php
                        }elseif($_GET['check'] == 'deliv'){?>
                            <div class="cart-items">
                            <?php 
                            foreach($deliv as $row){
                            ?>
                            <div class="cart-item row rounded shadow p-4">
                            <div class="col-2 mt-5">
                                    <a href="page-item.php?product=<?= $row["productCode"];?>"><img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt=""></a>
                                </div>
                                <div class="col-10">
                                    <small class="float-right font-italic"><?=$row['tanggal']?></small>
                                    <br>
                                    <small class="float-right btn-primary btn-sm">Sedang dikirim</small>
                                    <p id="item-name"><?=$row['namaProduk'];?></p>
                                    <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                    <br>
                                    <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargasatuan'],0,',','.');?> x <?=$row['qty'];?></span></small>
                                    <br>
                                    <small class="float-right">Total harga: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['harga'] + $row['ongkir'] ,0,',','.');?></span></small>
                                    <small id="toko-name">Toko : <?=$row['sellerName'];?></small>
                                    <br>
                                    <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$row['lokasi'];?></small>
                                    <small class="float-right">Qty: <?=$row['qty'];?> | Warna: <?=$row['warna'];?> | Ukuran: <?=$row['ukuran'];?></small>
                                    <br>
                                </div>
                                <table class="table mt-4 text-sm">
                                    <tr>
                                        <td>ID Pembeli</td>
                                        <td><?=$row['PembeliID']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pembeli</td>
                                        <td><?=$row['PembeliName']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?=$row['alamatPembeli']?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php } ?>
                            <br>
                        </div> <!--ENDIV CART-ITEMS--> <!--//NOTE penutup proses section-->

                        <!-- ANCHOR DONE SECTION  -->
                        <?php
                        } else {?>
                            <div class="cart-items">
                            <?php 
                            foreach($done as $row){
                                if($row['kategori'] == 'payment' OR $row['kategori'] == 'payment-saldo'){?>
                                <div class="cart-item row rounded shadow p-4">
                                    <div class="col-2 mt-5">
                                        <img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt="">
                                    </div>
                                    <div class="col-10">
                                        <small class="float-right font-italic"><?=$row['tanggal']?></small>
                                        <!-- <small class="float-right font-italic"><?=$row['tgl_sampai']?> |&nbsp;</small> -->
                                        <br>
                                        <small class="float-right btn-success btn-sm">Selesai</small>
                                        <p id="item-name"><?=$row['namaProduk'];?></p>
                                        <!-- <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                        <br>
                                        <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargasatuan'],0,',','.');?></span></small>
                                        <br> -->
                                        <small class="float-right h6">Total harga: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargapayment'],0,',','.');?></span></small>
                                        <!-- <small id="toko-name">Toko : <?=$row['sellerName'];?></small>
                                        <br>
                                        <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$row['lokasi'];?></small> -->
                                        <!-- <small class="float-right">Qty: <?=$row['qty'];?> </small> -->
                                        <br>
                                    </div>
                                    <table class="table mt-4 text-sm">
                                    <tr>
                                        <td>ID Pembeli</td>
                                        <td><?=$row['PembeliID']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pembeli</td>
                                        <td><?=$row['PembeliName']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?=$row['alamatPembeli']?></td>
                                    </tr>
                                </table>
                                </div>
                                <?php

                            }else{?>
                                <div class="cart-item row rounded shadow p-4">
                                <div class="col-2 mt-5">
                                    <a href="page-item.php?product=<?= $row["productCode"];?>"><img class="d-block w-100" src="assets/<?=$row['gambar'];?>" alt=""></a>
                                </div>
                                <div class="col-10">
                                    <small class="float-right font-italic"><?=$row['tanggal']?></small>
                                    <small class="float-right font-italic"><?=$row['tgl_sampai']?> |&nbsp;</small>
                                    <br>
                                    <small class="float-right btn-success btn-sm">Selesai</small>
                                    <p id="item-name"><?=$row['namaProduk'];?></p>
                                    <small class="float-right">Ongkos kirim: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['ongkir'],0,',','.');?></span></small>
                                    <br>
                                    <small class="float-right">Harga satuan: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['hargasatuan'],0,',','.');?> x <?=$row['qty'];?></span></small>
                                    <br>
                                    <small class="float-right">Total harga: <span style="color:#0275d8; font-weight:bold;"><?=number_format($row['harga'] + $row['ongkir'] ,0,',','.');?></span></small>
                                    <small id="toko-name">Toko : <?=$row['sellerName'];?></small>
                                    <br>
                                    <small><i class="fa fa-map-marker" style="color: #0275d8;" aria-hidden="true"></i> <?=$row['lokasi'];?></small>
                                    <small class="float-right">Qty: <?=$row['qty'];?> | Warna: <?=$row['warna'];?> | Ukuran: <?=$row['ukuran'];?></small>
                                    <br>
                                </div>
                                <table class="table mt-4 text-sm">
                                    <tr>
                                        <td>ID Pembeli</td>
                                        <td><?=$row['PembeliID']?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Pembeli</td>
                                        <td><?=$row['PembeliName']?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?=$row['alamatPembeli']?></td>
                                    </tr>
                                </table>
                                </div>
                            <?php
                            }?>
                           
                            <?php } ?>
                            <br>
                            </div> <!--ENDIV CART-ITEMS--> <!--//NOTE penutup proses section-->
                        <?php 
                        }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </body>
</html>