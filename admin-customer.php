<?php
    include 'config.php';
    session_start();

    $adminName = $_SESSION['adminname'];
    $adminID = $_SESSION['idadmin'];
    $now = date('Y-m-d');
    // var_dump($now);die();
    
    $sql = "SELECT * FROM user WHERE status =''";
    $toko = mysqli_query($conn, $sql);
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

            table{
                color: white;
            }
            .container .row img{
                height: 100px;
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
                            <div class="box p-2">
                                <a href="admin-dashboard.php">    
                                    <i class="fa fa-tachometer blue" aria-hidden="true"></i>  &nbsp;Dashboard
                                </a>
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
                            <div class="box-active rounded p-2 shadow">
                                <i class="fa fa-users blue" aria-hidden="true"></i>
                                &nbsp;Daftar Customer
                            </div>
                        </li>
                        <li>
                            <div class="box p-2">
                                <a href="admin-voucher.php?check=new">
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
                        </div>
                    </div>
                    <hr>

                    <?php
                    foreach ($toko as $row) {?>
                        <div class="container p-3 shadow rounded ml-4" style="width: 90%; background-color: #007bff;">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <img id="profilpicture" class="w-75" src="assets/profil/<?=$row['foto']?>" alt="">
                                </div>
                                <div class="col-8">
                                    <table class="">
                                        <tr>
                                            <td width="150px">Username</td>
                                            <td>: <?=$row['username']?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama lengkap</td>
                                            <td>: <?=$row['fullname']?></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>: <?=$row['telepon']?></td>
                                        </tr>
                                        <tr>
                                            <td>Transaksi</td>
                                            <td>: <?=$row['transaksi']?> kali</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>: <?=$row['alamat']?> kali</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>    
                        </div>
                        <br>
                        <?php
                        }
                        ?>


                </div>
            </div>
        </div>


    </body>
</html>