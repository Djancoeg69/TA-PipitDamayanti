<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

// Membaca data dari Form
$filterSql="";
$dataBagian	= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : 'ALL'; 

// Filter data saat tombol Tampil diklik
if(isset($_POST['btnTampil'])) {
	if($_POST['cmbBagian']=="ALL") {
		$filterSql	= "";
	}
	else {
		$filterSql	= " WHERE karyawan.kd_bagian='$dataBagian'";
	}
}
?>
<h2> DATA KARYAWAN </h2>
<form id="form2" name="form2" method="post" action="">
  <a href="?page=Laporan" class="konten_tombol">&laquo; Kembali</a>
</form>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table-list" width="400" border="0" cellpadding="2" cellspacing="1">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
  </tr>
  <tr>
    <td width="84"><strong>Pilih Bagian  </strong></td>
    <td width="5"><strong>:</strong></td>
    <td width="295">
	<select name="cmbBagian">
      <option value="ALL">....</option>
      <?php
	  $dataSql = "SELECT * FROM bagian ORDER BY kd_bagian";
	  $dataQry = mysql_query ($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataBagian == $dataRow['kd_bagian']) {
			$cek = "selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
	  }
	  $sqlData ="";
	  ?>
    </select>
    <input name="btnTampil" type="submit" class="konten_tombol" value=" Tampilkan " /></td>
  </tr>
</table>
</form>

<table class="table-list" width="968" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="33" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="103" bgcolor="#CCCCCC"><strong>Nik</strong></td>
    <td width="169" bgcolor="#CCCCCC"><strong>Nama Karyawan </strong></td>
    <td width="132" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
    <td width="96" bgcolor="#CCCCCC"><strong> Kelamin</strong></td>
    <td width="86" bgcolor="#CCCCCC"><strong>G Darah </strong></td>
    <td width="103" bgcolor="#CCCCCC"><strong>Agama</strong></td>
    <td width="205" bgcolor="#CCCCCC"><strong>Alamat Tinggal </strong></td>
  </tr>
	<?php
	$mySql = "SELECT karyawan.*, bagian.nm_bagian FROM karyawan
				LEFT JOIN bagian ON karyawan.kd_bagian=bagian.kd_bagian
				$filterSql
				ORDER BY karyawan.nik ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['nik']; ?></td>
    <td><?php echo $myData['nm_karyawan']; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td><?php echo $myData['kelamin']; ?></td>
    <td><?php echo $myData['gol_darah']; ?></td>
    <td><?php echo $myData['agama']; ?></td>
    <td><?php echo $myData['alamat_tinggal']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/karyawan.php?KdBagian=<?php echo $dataBagian; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>