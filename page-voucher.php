<?php
    include 'config.php';
    session_start();

    $userName = $_SESSION['username'];
    $userID = $_SESSION['iduser'];
    // NOTE total chart/keranjang display num
    $sql = "SELECT COUNT(id) FROM cart WHERE kodeUser = $userID";
    $cart = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $cartStack = $cart['COUNT(id)'];	
    $sql = "SELECT * FROM voucher WHERE voucherID > 0";
    $voucher = mysqli_query($conn, $sql);

    $sql = "SELECT saldo FROM user WHERE kodeUser = $userID";
    $saldo = mysqli_fetch_assoc(mysqli_query($conn, $sql));

    $sql = "SELECT status FROM user WHERE kodeUser = $userID";
    $statusSeller = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $statusSeller = $statusSeller['status'];
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
                            <div class="box-active shadow-lg rounded p-2">
                                <a class="box focus">
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
                            <small class="h3 blue">Voucher</small>
                            <br>
                            <!-- <small style="color: #96a9b3;" class="font-italic">Pesanan > Proses</small> -->

                        </div>
                    </div>
                    <hr>
                    
                    <div class="container p-2">
                        <div class="cart-items">
                            <?php 
                            foreach($voucher as $row){
                            ?>
                            <div class="cart-item row rounded shadow p-4">
                                <div class="col-2">
                                    <small style="font-weight: bold; font-size:15px;"><?=$row['voucherName']?></small>
                                </div>
                                <div class="col-10">
                                    <small><?=$row['keterangan']?></small>
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
    </body>
</html>