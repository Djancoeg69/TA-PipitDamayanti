<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode User </b> tidak terbaca !";		
	}
	
	if (trim($_POST['txtUsername'])=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	
						
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtUsername= $_POST['txtUsername'];
	$txtPassword= $_POST['txtPassword'];
	$passlagi=$_POST['passlagi'];
	
	# VALIDASI NAMA, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM user WHERE username='$txtUsername' AND NOT(username='".$_POST['txtUsernameLm']."')";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "USERNAME <b> $txtUsername </b> SUDAH ADA, ganti dengan yang lain";
	}

	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";
			} 
		echo "</div> <br>"; 
	}
	else {
		# Cek Password baru
		if ($txtPassword=="" || $passlagi =="" || $txtPassword  !== $passlagi ) {
			$sqlSub = " password='".$_POST['txtPasswordLm']."'";
		?>
			<script>
			alert('Mohon periksa kembali data Anda');
			history.go(-1);
			</script>
			<?php
		}
					
		else {
			$sqlSub = "  password ='".md5($txtPassword)."'";
				?>
		  <script>
		    alert('Password sukses diganti');
		    window.location="?page=User-Data";
		  </script>
		  <?php	
		}
		
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$mySql  = "UPDATE user SET username='$txtUsername', 
					 $sqlSub  WHERE kd_user='".$_POST['txtKode']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=User-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode  = isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM user WHERE kd_user='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
		// Baca data
		$myData = mysql_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode	= $myData['kd_user'];
		$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : $myData['username'];
		$dataUsernameLm	= $myData['username'];
		$dataPasswordLm	= $myData['password'];
		
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><div align="left"><b>GANTI PASSWORD</b></div></th>
    </tr>
    <tr>
      <td height="33" colspan="3"><a href="?page=User-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td colspan="3"> <input name="textfield" type="text" style="visibility: hidden " disabled="disabled"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td width="558"><div align="right"><b>Username</b></div></td>
      <td width="5"><b>:</b></td>
      <td width="554"><input name="txtUsername" type="text"  readonly="readonly" value="<?php echo $dataUsername; ?>" size="30" maxlength="20" />
      <input name="txtUsernameLm" type="hidden" value="<?php echo $dataUsernameLm; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Password Baru</b></div></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="30" maxlength="100" />
      <input name="txtPasswordLm" type="hidden" value="<?php echo $dataPasswordLm; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Ulangi Password Baru </b></div></td>
      <td><b>:</b></td>
      <td><input name="passlagi" type="password" id="passlagi" size="30" maxlength="100" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " /></td>
    </tr>
  </table>
</form>
