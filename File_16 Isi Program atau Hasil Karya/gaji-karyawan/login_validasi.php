<?php 

if(isset($_POST['btnLogin'])){
	
	
	# Baca variabel form
	$txtUser 	= $_POST['txtUser'];
	
	$txtPassword=$_POST['txtPassword'];
	
	
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
			
		
		// Tampilkan lagi form login
		include "login.php";
	
	
		# LOGIN CEK KE TABEL USER LOGIN
		$loginSql = "SELECT * FROM user WHERE binary username='".$txtUser."' 
					AND password='".md5($txtPassword)."'";
		$loginQry = mysql_query($loginSql, $koneksidb)  
					or die ("Query Salah : ".mysql_error());

		# JIKA LOGIN SUKSES
		if (mysql_num_rows($loginQry) >=1) {
			$loginData = mysql_fetch_array($loginQry);
			$_SESSION['SES_LOGIN'] 	= $loginData['kd_user']; 
			$_SESSION['SES_USER'] 	= $loginData['username']; 
			
			//login Administrator
				$_SESSION['SES_ADMIN'] = "admin";
			
			
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?page=Halaman-Utama'>";
		}
		else {
			 ?>
		<script>
		alert('Gagal Login, Cek username dan password');
		history.go(-1);
		</script>
		<?php
		}
	}
 // End POST
?>
 
