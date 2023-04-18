<?php
    include 'config.php';
    session_start();

    if(!isset($_SESSION['idadmin'])){
        header('location:admin-login.php');
    }

    $adminName = $_SESSION['adminname'];
    $adminID = $_SESSION['idadmin'];
    $now = date('Y-m-d');
    // var_dump($now);die();
    
    $sql = "SELECT COUNT(transaksiID) AS total FROM tbl_order WHERE tgl_beli LIKE '%$now%'";
    $transaksiToday = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $sql = "SELECT COUNT(kodeItem) AS total FROM detailsproduct";
    $sumProduct = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $sql = "SELECT COUNT(kodeUser) AS total FROM user WHERE status = 'seller'";
    $sumToko = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    $sql = "SELECT COUNT(kodeUser) AS total FROM user WHERE status = ''";
    $sumCustomer = mysqli_fetch_assoc(mysqli_query($conn, $sql));
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
            .white{
                color: white;
            }
            img{
                margin-top: -48px;
            }
            input[readonly]{
                border-left: 0;
                border-top: 0;
                border-right: 0;
                border-color: #26c6da;
                padding-bottom: 5px;
                /* width: 700px; */
                width: 700px;
            }
            input:focus{
                outline: none;
            }     
            .head{
                color: #7f757c;
                /* margin-bottom: 200px; */
                padding-top: 25px;
            }
            td :not(.head, small) {
                /* border-color: #26c6da; */
                border-bottom-style: solid;
                border-width: 2px;
                border-bottom-color: #007bff;
            }
            .text{
                padding: 6px 0 5px 0;
                color: #96a9b3;
                width: 700px;
            }
            td small{
                font-size: 16px;
            }
            #info td{
                width: 250px;
                
                /* background-color: #007bff; */
            }

            #changeprofil{
                position: absolute;
                /* margin: 0; */
                left: 15;
                /* width: 20px; */
                padding:0;
                /* bottom: 120;
                 */
                 /* height: 20px; */
                 top:0;
                 display: none;
            }
            #profilpict:hover ~ #changeprofil{
                display: inline-block;
            }
            #changeprofil:hover{
                display: inline-block;
            }
            input[type="file"] {
                display: none;
            }
            
            .fa-pencil-square-o{
                margin-top: -17px;
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
        </style>
    </head>
    <body>
        <!-- <?php //include "nav.php"; ?> -->

        <div class="main pt-1">
            <div class="row">
                <div class="col-2 shadow vh-100">
                    <ul class="mt-2">
                        <li>
                            <div class="box-active rounded p-2 shadow">
                            <i class="fa fa-tachometer" aria-hidden="true"></i>  &nbsp;Dashboard
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a class="box focus" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                <i class="fa fa-shopping-basket blue" aria-hidden="true"></i>
                                &nbsp;Transaksi
                                </a>
                                    <div class="collapse" id="collapseExample" >
                                        <div class="card card-body">
                                            <a href="admin-transaksi.php?check=proses">Proses</a>
                                            <a href="admin-transaksi.php?check=deliv">Sedang dikirim</a>
                                            <a href="admin-transaksi.php?check=done">Selesai</a>
                                        </div>
                                    </div>
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
                <div class="col-10">
                    <div class="row pt-4 ml-4">
                        <div class="col-12">
                            <small class="h3 blue">Dashboard</small>
                            <a href="logout.php" class="btn btn-sm btn-danger float-right mr-5">Logout</a>
                        </div>
                    </div>
                    <hr>

                    <div class="row p-4 justify-content-center shadow-lg rounded ml-4" style="width: 90%; background-color: #007bff">
                        <div class="col-3 white border-right border-light">
                            <h6>Transaksi Hari Ini</h6>
                            <div style="height:4px; width:180px; margin-top:-5px;"></div>
                            <h1> <i class="fa fa-money" aria-hidden="true"></i> &nbsp;<?=$transaksiToday['total']?></h1>
                        </div>
                        <div class="col-3 white border-right border-light">
                            <h6>Jumlah Produk</h6>
                            <div style="height:4px; width:180px; margin-top:-5px;"></div>
                            <h1> <i class="fa fa-archive" aria-hidden="true"></i> &nbsp;<?=$sumProduct['total']?></h1>
                        </div>
                        <div class="col-3 white border-right border-light">
                            <h6>Jumlah Toko</h6>
                            <div style="height:4px; width:180px; margin-top:-5px;"></div>
                            <h1> <i class="fa fa-home" aria-hidden="true"></i> &nbsp;<?=$sumToko['total']?></h1>
                        </div>
                        <div class="col-3 white">
                            <h6>Jumlah Pelanggan</h6>
                            <div style="height:4px; width:180px; margin-top:-5px;"></div>
                            <h1> <i class="fa fa-users" aria-hidden="true"></i> &nbsp;<?=$sumCustomer['total']?></h1>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </body>
</html>