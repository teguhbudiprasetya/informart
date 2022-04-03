<?php 
 
include 'config.php';
session_start();
 
if (isset($_SESSION['username'])) {
    header("Location: index.php");
}
 
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['iduser'] = $row['kodeUser'];
        $_SESSION['username'] = $row['username'];
        header("Location: index.php");
    } 
    else {
        // $sql2 = "SELECT * FROM tbluser WHERE username='$username' AND password='$password'";
        // $result = mysqli_query($conn, $sql2);
        // if ($result->num_rows > 0) {
        //     $row = mysqli_fetch_assoc($result);
        //     $_SESSION['iduser'] = $row['iduser'];
        //     $_SESSION['namauser'] = $row['nama'];
        //     header("Location: index.php");
        // }
            // else{
                echo "<script>alert('username atau password Anda salah. Silahkan coba lagi!')</script>";
            // }
            
        }
}
if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
 
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    if (!$result->num_rows > 0) {
        $sql = "INSERT INTO user (username, email, password) VALUES ('$username','$email','$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "<script>alert('Register berhasil!')</script>";
            // header("Location: login.php");
        } 
        else {
            echo "<script>alert('Gagal register!')</script>";
            
        }
    }
    else{
        echo "<script>alert('Username sudah terdaftar')</script>";
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
    <title>Sign Up & Log In | Informart</title>
    <style>
        #header-brand, h4{
            color: #0275d8;
        }
        #frame-masuk, #frame-daftar{
            height: 400px;
            width: 300px;
            border-radius: 10px;
            box-shadow: 1px 1px 5px 1px #d2d4d2;
            background-color: white;
        }
        #frame-daftar{
            display: none;
        }
        img{
            width: 80%;
        }
        .white{
            color: #0275d8;
        }
        span{
            color: #0275d8;
        }
        #frame-masuk a, #frame-daftar a{
            text-decoration: none;
        }
        #hidden{
            visibility: hidden;
        }
    </style>
</head>

<body>
    <a href="index.php">Home</a>
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col text-center mb-5">
                <h2 id="header-brand" class="white">Informart</h2>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-7 text-center">
                <img src="assets/cart-bg.png" alt="">
                <h4 class="white">Jual Beli Mudah, Hanya di Informart</h4>
                <small class="white">Gabung dan rasakan kemudahan bertransaksi di Informart</small>
            </div>
            <div class="col-5 self">
                <div id="frame-masuk" class="ml-5">
                    <div class="row justify-content-center text-center">
                        <div class="col">
                            <h4 class="mt-3">Masuk</h4>
                            <small >Belum punya akun? <a class="changeColorBtn-1" href="#">Daftar sekarang</a></small>
                        </div>
                    </div>
                    <div class="row ml-2" style="width: 95%;">
                        <div class="col mt-5">
                            <form action="" method="POST">
                            <small>Username atau email</small>
                            <input type="text" class="form-control form-control-sm mb-2" name="username" placeholder="" required>
                            <small>Password</small>
                            <input type="password" class="form-control form-control-sm" name="password" placeholder="" required>
                            <div class="mt-4" id="hidden">asad</div>
                            <button type="submit" name="login" class="btn btn-primary btn-lg btn-block mt-5">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="frame-daftar" class="ml-5">
                    <div class="row justify-content-center text-center">
                        <div class="col">
                            <h4 class="mt-3">Daftar</h4>
                            <small >Sudah punya akun? <a class="changeColorBtn-2" href="#">Masuk sekarang</a></small>
                        </div>
                    </div>
                    <div class="row ml-2" style="width: 95%;">
                        <div class="col mt-5">
                            <form action="login.php" method="POST">
                            <small>Username</small>
                            <input type="text" class="form-control form-control-sm mb-2" name="username" placeholder="" required>
                            <small>Email</small>
                            <input type="email" class="form-control form-control-sm mb-2" name="email" placeholder="" required>
                            <small>Password</small>
                            <input type="password" class="form-control form-control-sm" name="password" placeholder="" required>
                            <!-- <div class="mt-4" id="hidden">asad</div> -->
                            <button type="submit" name="signup" class="btn btn-primary btn-lg btn-block mt-3 mb-1">Masuk</button>
                            <div style="text-align: center;">
                                <small style="font-size:11px;">Dengan mendaftar, saya menyetujui Syarat dan Ketentuan serta Kebijakan Privasi</small>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.body.style.backgroundColor = '#F6F6F6';
        const btnMasuk = document.querySelector('.changeColorBtn-1');
        const btnDaftar = document.querySelector('.changeColorBtn-2');
        // const frame = document.getElementById('frame');
        // frame.style.backgroundColor = 'white';
        const textColor = document.querySelectorAll('small');
        const textColorWhite = document.querySelectorAll('.white');
        const frameMasuk = document.querySelector('#frame-masuk');
        const frameDaftar = document.querySelector('#frame-daftar');
        btnMasuk.addEventListener('click', function onClick(event) {
            document.body.style.backgroundColor = '#4891FF';
            
            for (let i = 0; i < textColor.length; i++) {
                textColor[i].style.color = "#686464";
            }
            for (let i = 0; i < textColorWhite.length; i++) {
                textColorWhite[i].style.color = "white";
            }
            frameDaftar.style.display = 'block';
            frameMasuk.style.display = 'none';
        });
        btnDaftar.addEventListener('click', function onClick(event) {
            document.body.style.backgroundColor = '#F6F6F6';
            frameMasuk.style.display = 'block';
            frameDaftar.style.display = 'none';
            for (let i = 0; i < textColorWhite.length; i++) {
                textColorWhite[i].style.color = "#0275d8";
            }
        });
    </script>
</body>
</html>