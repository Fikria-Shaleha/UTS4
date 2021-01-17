<?php
	//ini Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "dblatihan";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

	//ini kalo tombol save diklik tar muncul apa hayooo
	if(isset($_POST['bsimpan']))
	{
		//ntar dia diedit ato disimpen baru? ini kodingannya
		if($_POST['bsimpan'] == "edit")
		{
			//ini data yg mau diedit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
											 	no_pemesanan = '$_POST[tno_pemesanan]',
											 	nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
											 	jns_pemesanan = '$_POST[tjenis_AR]'
											 WHERE id_pemesanan = '$_GET[id]'
										   ");
			if($edit) //kalo edit/updatenya berhasil yuhuuu
			{
				echo "<script>
						alert('Yosha! Edit data sukses!');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Yah, edit datanya gagal nih');
						document.location='index.php';
				     </script>";
			}
		}
		else
		{
			//Data bakal disimpen yg baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (no_pemesanan, nama, alamat, jns_pemesanan)
										  VALUES ('$_POST[tno_pemesanan]', 
										  		 '$_POST[tnama]', 
										  		 '$_POST[talamat]', 
										  		 '$_POST[tjenis_AR]')
										 ");
			if($simpan) //kalo simpen sukses
			{
				echo "<script>
						alert('Yuhuu! Simpan data sukses >_<');
						document.location='index.php';
				     </script>";
			}
			else
			{
				echo "<script>
						alert('Walah walah, simpan datanya gagal');
						document.location='index.php';
				     </script>";
			}
		}


		
	}


	//diuji dulu, bisa gak diedit/ update sama apus? makanya klik
	if(isset($_GET['hal']))
	{
		//kalo edit/update data
		if($_GET['hal'] == "edit")
		{
			//terus tampilin data yg bakal diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_pemesanan = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//kalo datanya ketemu, ntar dimasukin kedalam variabel, gangerti juga si wkwk intinya gitu
				$vno_pemesanan = $data['no_pemesanan'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];
				$vjns_pemesanan = $data['jns_pemesanan'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//oke priper tu apus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_pemesanan = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Oke, data sudah dihapus ya ^_^');
						document.location='index.php';
				     </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>HIMAWARI AUGMENTED REALITY</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">

	<h1 class="text-center">HIMAWARI AUGMENTED REALITY</h1>
	<h2 class="text-center">HIMA COMPANY</h2>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Pemesanan Augmented Reality
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Nomor Pemesanan</label>
	    		<input type="text" name="tno_pemesanan" value="<?=@$vno_pemesanan?>" class="form-control" placeholder="Masukkan nomor pemesanan disini" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Nama</label>
	    		<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Masukkan nama anda disini" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Alamat</label>
	    		<textarea class="form-control" name="talamat"  placeholder="Masukkan Alamat anda disini"><?=@$valamat?></textarea>
	    	</div>
	    	<div class="form-group">
	    		<label>Jenis Pemesanan</label>
	    		<select class="form-control" name="tjenis_AR">
	    			<option value="<?=@$vjns_pemesanan?>"><?=@$vjns_pemesanan?></option>
	    			<option value="Bangunan 3D AR">Bangunan 3D AR</option>
	    			<option value="Luar Angkasa 3D AR">Luar Angkasa 3D AR</option>
	    			<option value="Bawah Laut 3D AR">Bawah Laut 3D AR</option>
	    		</select>
	    	</div>

	    	<button type="submit" class="btn btn-success" name="bsimpan">Save</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Reset</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->

	<!-- Awal Card Tabel -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    Data Pembeli
	  </div>
	  <div class="card-body">
	    
	    <table class="table table-bordered table-striped">
	    	<tr>
	    		<th>No.</th>
	    		<th>Nomor Pemesanan</th>
	    		<th>Nama</th>
	    		<th>Alamat</th>
	    		<th>Jenis Pemesanan</th>
	    		<th>Action</th>
	    	</tr>
	    	<?php
	    		$no = 1;
	    		$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_pemesanan desc");
	    		while($data = mysqli_fetch_array($tampil)) :

	    	?>
	    	<tr>
	    		<td class="text-center"><?=$no++;?></td>
	    		<td><?=$data['no_pemesanan']?></td>
	    		<td><?=$data['nama']?></td>
	    		<td><?=$data['alamat']?></td>
	    		<td><?=$data['jns_pemesanan']?></td>
	    		<td>
	    			<a href="index.php?hal=edit&id=<?=$data['id_pemesanan']?>"class="btn btn-warning"> Update </a>
	    			<a href="index.php?hal=hapus&id=<?=$data['id_pemesanan']?>" 
	    			   onclick="return confirm('beneran mau dihapus nih?')" class="btn btn-danger" > Delete </a>
	    		</td>
	    	</tr>
	    <?php endwhile; //di end dari perulangan while huhuu ?>
	    </table>

	  </div>
	</div>
	<!-- Akhir Card Tabel -->

</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>