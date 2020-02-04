<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbKaryawan'])=="BLANK") {
		$pesanError[] = "Data <b>Kode Karyawan</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTanggal'])=="") {
		$pesanError[] = "Data <b>Tanggal Lembur</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtKeterangan'])=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}	
		
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbKaryawan	= $_POST['cmbKaryawan'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtKeterangan	= $_POST['txtKeterangan'];

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
		
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$userLogin	= $_SESSION['SES_LOGIN'];
		$mySql  = "UPDATE lembur SET nik='$cmbKaryawan', 
					tanggal='$txtTanggal', keterangan='$txtKeterangan', kd_user='$userLogin'
					WHERE id='".$_POST['txtKode']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			 ?>
		  <script>
		    alert('Data berhasil diubah');
		    window.location="?page=Lembur-Data";
		  </script>
		  <?php
		}
		exit;
	}	
} // Penutup POST


if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM lembur WHERE id='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
		// Baca data
		$myData = mysql_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode		= $myData['id'];
		$dataKaryawan	= isset($_POST['cmbKaryawan']) ? $_POST['cmbKaryawan'] : $myData['nik'];
		$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : IndonesiaTgl($myData['tanggal']);
		$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : $myData['keterangan'];
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>UBAH DATA LEMBUR </b></div></th>
    </tr>
    <tr>
      <td height="38" colspan="3"><a href="?page=Lembur-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td><div align="right"><b>Tanggal Lembur </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtTanggal" type="text"  value="<?php echo $dataTanggal; ?>"  maxlength="12" />
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong> Karyawan </strong></div></td>
      <td><b>:</b></td>
      <td><select name="cmbKaryawan">
          <option value="BLANK">....</option>
          <?php
	  $dataSql = "SELECT * FROM karyawan ORDER BY nik";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataKaryawan == $dataRow['nik']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[nik]' $cek>[ $dataRow[nik] ] $dataRow[nm_karyawan]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><div align="right"><b>Keterangan </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtKeterangan" type="text" value="<?php echo $dataKeterangan; ?>" size="50" maxlength="100" /></td>
    </tr>
    
    <tr>
      <td width="561">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="510">
      <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
