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

    if(isset($_POST['edit'])){
        $newFullName = $_POST['fullname'];
        $newUserName = $_POST['username'];
        $newEmail = $_POST['email'];
        $newTelepon = $_POST['telepon'];
        $newPassword = $_POST['password'];
        $newAlamat = $_POST['alamat'];
        $newProvinsi = $_POST['provinsi'];
        $newProvinsi = (int)$newProvinsi;
        // var_dump($newAlamat,$newEmail,$newPassword,$newProvinsi,$newUserName);die();
        $checkEmail = mysqli_query($conn, "SELECT * FROM user WHERE email = '$newEmail' AND kodeUser != $userID");
        // var_dump($checkEmail);die();
        if(exist($checkEmail)){
            $sql = "UPDATE user SET fullname ='$newFullName', username ='$newUserName', email ='$newEmail', telepon ='$newTelepon', password ='$newPassword', alamat ='$newAlamat', idProvinsi =$newProvinsi WHERE kodeUser = $userID";
            mysqli_query($conn, $sql);
            echo    "<script>
                            alert('Data profile berhasil diubah');
                            window.location.replace('page-profil.php');
                    </script>";
        }
    }
    
    if(isset($_POST['submitfile'])){
        if(uploadProfil($userID)){
            echo "<script>
                alert('Berhasil mengubah foto profil');
                window.location.replace('page-profil.php');
                </script>";
        }else{
            echo "<script>
                alert('Gagal mengubah foto profil');
                window.location.replace('page-profil.php');
                </script>";
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
        <?php include "nav.php"; ?>

        <div class="main pt-1">
            <div class="row mt-5">
                <div class="col-2 shadow vh-100">
                    <ul class="mt-2">
                        <li>
                            <a href="page-topup.php" class="btn btn-success mb-2" style="width: 100%; text-align:left;">Rp. <?=number_format($saldo['saldo'],0,',',',')?> </a>
                        </li>
                        <li>
                            <div class="box-active rounded p-2 shadow">
                            <i class="fa fa-user-o" aria-hidden="true"></i>  &nbsp;Profile
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
                <div class="col-10">
                    <div class="row pt-4 ml-4">
                        <div class="col-10">
                            <small class="h3 blue">Profile</small>
                        </div>
                        <div class="col-2">                   
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">Edit</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row p-2">
                        <div class="col-3 mt-4 ml-4 pt-5">
                            <img id="profilpict" src="assets/profil/<?=$p['foto']?>" class="w-100">
                            <label id="changeprofil" class="custom-file-upload btn btn-primary">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <!-- <input id="upfile" type="file" name="berkas"/> -->
                                    <input type="file" name="berkas" id="berkas">
                                    <button class="btn" id="submitfile" type="submit" name="submitfile"><i class="fa fa-check-square" aria-hidden="true" style="color: white;"></i></button>
                                    <!-- <input id="submitfile" name="submitfile" type="submit" value="<i class="fa fa-check-square" aria-hidden="true"></i>"> -->
                                </form>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </label>
                        </div>
                        <div class="col-8 mb-5">
                            <table id="info">
                                <form action="" enctype="multipart/form-data">
                                <tr>
                                    <td class="head">
                                        Nama Lengkap
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['fullname']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Username
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['username']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Email
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['email']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Telepon
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['telepon']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Password
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['password']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Alamat
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <!-- <input  type="text" value="<?=$p['alamat']?>" readonly> -->
                                        <div class="text">
                                            <small>
                                            <?=$p['alamat']?>
                                            </small>
                                        </div>

                                    </td>
                                </tr>
                                <tr>
                                    <td class="head">
                                        Provinsi
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="text">
                                            <small>
                                            <?=$p['provinsi']?>
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                                </form>
                            </table>
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
                <h5 class="modal-title blue" id="staticBackdropLabel">Edit profile</h5>
                <!-- <span aria-hidden="true">&times;</span> -->
                </button>
            </div>
            <div class="modal-body">
                <table>
                    <form id="edit" method="POST" action="" enctype="multipart/form-data">
                        <tr>
                            <td class="head">
                                Nama lengkap
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="fullname" value="<?=$p['fullname']?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Username
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="username" value="<?=$p['username']?>" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Email
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="email" name="email" value="<?=$p['email']?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Telepon
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="number" name="telepon" value="<?=$p['telepon']?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Password
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input class="form-control" type="text" name="password" minlength="8" value="<?=$p['password']?>" style="width:450px;">
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Alamat
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <textarea class="form-control" name="alamat" id="" cols="30" rows="5"><?=$p['alamat']?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td class="head">
                                Provinsi
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php $provinsi = mysqli_query($conn, "SELECT * FROM provinsi"); ?>
                                    <select class="form-control" name="provinsi" id="">
                                        <?php foreach($provinsi as $prov) { ?>
                                            <?php if($prov['idProvinsi'] != 35){?>
                                                <option value="<?=$prov['idProvinsi']?>"><?=$prov['namaProvinsi']?></option>
                                            <?php }
                                        }?>
                                    </select>
                            </td>
                        </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                <button type="submit" name="edit" class="btn btn-primary">Simpan</button>
                <!-- <input type="submit" name="submit" value="Simpan"> -->
            </form>                
            </div>
        </div>
        </div>
        </div>
        <script type="text/javascript">
            document.getElementById('submitfile').onclick = function() {
                confirm('Apakah kamu yakin?');
            };
        </script>
    </body>
</html>