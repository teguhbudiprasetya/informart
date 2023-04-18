<?php
    include 'config.php';
    session_start();

    $sql = "SELECT * FROM voucher WHERE voucherID > 0";
    $voucher = mysqli_query($conn, $sql);

    if(!isset($_SESSION['idadmin'])){
        header('location:admin-login.php');
    }

    if(isset($_POST['add'])){
        $voucherName = $_POST['vouchername'];
        $keterangan = $_POST['keterangan'];
        $potongan = $_POST['potongan'];
        if (strpos($potongan, '.') !== false) {
            $insertVoucher = "INSERT INTO voucher VALUES ('', '$voucherName', '$keterangan', '$potongan', 'bagi' )";
            mysqli_query($conn, $insertVoucher)or trigger_error("Query Failed! SQL: $insertVoucher - Error: ".mysqli_error($conn), E_USER_ERROR);
        }else{
            $insertVoucher = "INSERT INTO voucher VALUES ('', '$voucherName', '$keterangan', '$potongan', 'kurang' )";
            mysqli_query($conn, $insertVoucher)or trigger_error("Query Failed! SQL: $insertVoucher - Error: ".mysqli_error($conn), E_USER_ERROR);
        }
        header('refresh:0');
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
                            <div class="box-active rounded p-2 shadow">
                                <a href="">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                    &nbsp;Daftar Voucher
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-9">
                    <div class="row pt-4 ml-4">
                        <div class="col-12">
                            <small class="h3 blue">Voucher</small>
                            <button type="button" class="float-right btn btn-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">Tambah Voucher</button>

                        </div>
                    </div>
                    <hr>
                    
                    <div class="container p-4">
                        <div class="cart-items">
                            <?php 
                            foreach($voucher as $row){
                            ?>
                            <div class="cart-item row rounded shadow p-4">
                                <div class="col-2">
                                    <small style="font-weight: bold; font-size:15px;"><?=$row['voucherName']?></small>
                                </div>
                                <div class="col-7">
                                    <small><?=$row['keterangan']?></small>
                                </div>
                                <div class="col-2">
                                    <a href="delete-voucher.php?id=<?=$row['voucherID']?>" class="float-right btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </div>
                            <br>

                            <?php 
                        } ?>
                        </div>

                    </div> 
                </div>
            </div>
        </div>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title blue" id="staticBackdropLabel">Tambah Voucher</h5>
                <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <table class="w-100 p-2">
                    <form id="edit" method="POST" action="" enctype="multipart/form-data">
                        <tr>
                            <td class="head">
                                Nama Voucher
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="vouchername" value="" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Deskripsi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="keterangan" class="form-control" required></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Potongan
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="potongan" value="" required>
                            </td>
                        </tr>
                        
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" name="add" class="btn btn-primary">Simpan</button>
                <!-- <input type="submit" name="submit" value="Simpan"> -->
            </form>                
            </div>
        </div>
        </div>
        </div>
        
    </body>
</html>