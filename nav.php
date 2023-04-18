<style>
	.dropdown-toggle::after {
                display: none;
                
            }
</style>
<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light shadow-sm shadow" style="height: 50px;">
	  <a class="navbar-brand mr-5" href="index.php" style="font-weight: bold; color:#007bff;">Informart</a>
	  <form action="page-katalog.php" class="ml-5" style="width: 70%; margin-top:15px;">
		<div class="input-group">
			<?php 
				if(isset($_GET['cari'])){?>
					<input type="text" name="cari" class="form-control" value="<?=$_GET['cari']?>" aria-label="Cari barang disini!" aria-describedby="basic-addon2" required>
					<?php }
					elseif(isset($_GET['kategori'])){?>
					<input type="text" name="cari" class="form-control" value="<?=$_GET['kategori']?>" aria-label="Cari barang disini!" aria-describedby="basic-addon2" required>
					<?php
					}
				else{?>
					<input type="text" name="cari" class="form-control" placeholder="Cari barang disini!" aria-label="Cari barang disini!" aria-describedby="basic-addon2" required>
				<?php
				}
			?>			
			<div class="input-group-append">
				<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> </button>
			</div>
		</div>
	  </form>
	  <div class="collapse navbar-collapse"  id="navbarText">
	    <ul class="navbar-nav ml-auto" style="margin-right: 100px;">
	      <li class="nav-item active " style="margin: 0px 10px;">
          <?php 
            if(isset($cartStack)){?>
                <a class="nav-link mt-1" href="page-cart.php"><i class="fa fa-shopping-cart aria-hidden='true' fa-lg"></i><span class="badge badge-primary"><?=$cartStack;?></span></a>
                <?php 
            } else{
                if(!isset($userName)){ ?>
				<button id="trigger-login" class="nav-link btn "><i class="fa fa-shopping-cart aria-hidden='true' fa-lg"></i><span class="badge badge-primary">0</span></button>
				<?php
				}else{ ?>
					<a class="nav-link mt-1" href="page-cart.php"><i class="fa fa-shopping-cart aria-hidden='true' fa-lg"></i><span class="badge badge-primary">0</span></a>
				<?php }
			} ?>
        </li>
        <?php 
		  	if(!isset($userName)){ ?>
				<li class="nav-item" style="margin: 0px 5px; float:right;">
				  <a class="navbar-text btn btn-outline-primary btn-sm text-primary" href="page-login.php?login=daftar">Daftar</a>
				</li>
				<li class="nav-item" style="margin: 0px -90px 0px 0px;">
					<a class="navbar-text btn btn-primary btn-sm text-white" href="page-login.php?login=masuk">Masuk</a>
				</li>
				<?php } else{?>
				<li class="nav-item" style="margin: 0px 5px; float:right;">
					<!-- <a style="width: 60px; overflow:hidden;" class="navbar-text btn btn-outline-primary btn-sm text-primary" href="#"><?= $userName?></a> -->
					<div class="dropdown show">
						<a style="background-color:white; overflow:hidden; max-width:60px;" class="navbar-text btn btn-outline-primary btn-sm text-primary" href="page-profil.php">
							<?=$userName?>
						</a>
					</div>
				</li>
				<li class="nav-item" style="margin: 0px -90px 0px 0px;">
				  <a class="navbar-text btn btn-primary btn-sm text-white" href="logout.php">Logout</a>
				</li>
			 <?php } ?>
        </ul>
      </div>
    </nav>
	<script>
		const triggerlogin = document.querySelector('#trigger-login');
		triggerlogin.addEventListener('click', function onClick(event) {
            alert("Login terlebih dahulu!");
        });
	</script>