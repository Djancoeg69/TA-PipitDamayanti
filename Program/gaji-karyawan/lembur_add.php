<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbKaryawan'])=="BLANK") {
		$pesanError[] = "Data <b>Karyawan</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtKeterangan'])=="") {
		$pesanError[] = "Data <b>Keterangan</b> tidak boleh kosong !";		
	}	
		
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbKaryawan	= $_POST['cmbKaryawan'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtKeterangan	= $_POST['txtKeterangan'];
	
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtKeterangan			= $_POST['txtKeterangan']; 
	$txtKeterangan			= strtoupper($txtKeterangan); //Huruf menjadi BESAR
	$cmbKaryawan			= $_POST['cmbKaryawan'];
	$cmbKaryawan			= strtoupper($cmbKaryawan);//huruf besar
	
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
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
	$userLogin	= $_SESSION['SES_LOGIN'];
	$mySql  	= "INSERT INTO lembur (nik, tanggal, keterangan, kd_user)
					VALUES ('$cmbKaryawan', '$txtTanggal', '$txtKeterangan', '$userLogin')";
	$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
	if($myQry){
		 ?>
		  <script>
		    alert('Data berhasil ditambahkan');
		    window.location="?page=Lembur-Data";
		  </script>
		  <?php
	}
	exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKaryawan	= isset($_POST['cmbKaryawan']) ? $_POST['cmbKaryawan'] : '';
$dataTanggal	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>TAMBAH DATA LEMBUR </b></div></th>
    </tr>
    <tr>
      <td height="36" colspan="3"><a href="?page=Lembur-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td><div align="right"><b>Tanggal Lembur </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtTanggal" type="text"  value="<?php echo $dataTanggal; ?>" maxlength="12" readonly="readonly" /></td>
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
      <td width="559">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="512">
      <input type="submit" name="btnSimpan" class="konten_tombol" value="Simpan" />
      <input type="reset" name="reset" id="reset" class="konten_tombol"  value="Batal" /></td>
    </tr>
  </table>
</form>
