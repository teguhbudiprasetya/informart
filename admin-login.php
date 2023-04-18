<?php 
 
include 'config.php';
session_start();

if (isset($_SESSION['idadmin'])) {
    header("Location: admin-dashboard.php");
}
 
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    $sql = "SELECT * FROM user WHERE (username='$username' AND password='$password')";
    $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    // var_dump($result);die();
    if ($result['kodeUser'] == '0') {
        $_SESSION['idadmin'] = $result['kodeUser'];
        $_SESSION['adminname'] = $result['username'];
        // var_dump($result, $_SESSION['idadmin']);die();
        header('location: admin-dashboard.php');
    } 
    else{
        // print('Halo bandung');die();
        echo "<script>alert('username atau password anda salah.')</script>";
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
        body{
            background-color: #0275d8;
        }
        #header-brand a{
            text-decoration: none;
            color: #d2d4d2;
        }
        #frame-masuk, #frame-daftar{
            height: 400px;
            width: 300px;
            border-radius: 10px;
            box-shadow: 1px 1px 3px 1px #d2d4d2;
            background-color: white;
        }
        /* #frame-daftar{ */
            /* display: none; */
        /* } */
        img{
            width: 80%;
        }
        .white{
            color: #d2d4d2;
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
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col text-center mb-5">
                <h2 id="header-brand" class="white"><a href="index.php">Informart</a></h2>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-7 text-center">
                <img src='assets/forgot-password.png' style='width:300px;'>
                <h4 class="white">Selamat datang Admin Master</h4>
                <small class="white">Operasikanlah website ini dengan bijak</small>
            </div>
            <div class="col-5 self">
                <div id="frame-masuk" class="ml-5">
                    <div class="row justify-content-center text-center">
                        <div class="col">
                            <h4 class="mt-3">Masuk</h4>
                            
                        </div>
                    </div>
                    <div class="row ml-2" style="width: 95%;">
                        <div class="col mt-5">
                            <form action="" method="POST">
                                <small>Username atau email</small>
                                <input type="text" class="form-control form-control-sm mb-2" name="username" placeholder="" required>
                                <small>Password</small>
                                <input type="password" class="form-control form-control-sm mb-2" name="password" placeholder="" required>
                                <br>
                                <button type="submit" name="login" class="btn btn-primary btn-lg btn-block mt-5 mb-2">Masuk</button>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    </script>
</body>
</html>