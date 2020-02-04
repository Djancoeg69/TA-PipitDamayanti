<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

// Membaca data dari Form Filter
$dataTahun = isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y');
$dataBulan = isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m');
?>
<h2> DATA POTONGAN </h2>
<form id="form2" name="form2" method="post" action="">
  <a href="?page=Laporan" class="konten_tombol">&laquo; Kembali</a>
</form>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="111"><strong>Periode Bulan </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="365"><select name="cmbBulan">
          <?php
	$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
					 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
					 "08" => "Agustus", "09" => "September", "10" => "Oktober",
					 "11" => "November", "12" => "Desember");

	  foreach($namaBulan as $bulanKe => $bulanNM) {
	  	if ($bulanKe == $dataBulan) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bulanKe' $cek>$bulanKe - $bulanNM</option>";
	  }
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		$tahunAwal = 2013;
	  for($thn= $tahunAwal; $thn <= date('Y'); $thn++) {
	  	if ($thn == $dataTahun) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$thn' $cek>$thn</option>";
	  }
	  ?>
          </select>
          <input name="btnTampil" type="submit" class="konten_tombol" value=" Tampilkan " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="33" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="104" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="111" bgcolor="#CCCCCC"><strong>NIK </strong></td>
    <td width="165" bgcolor="#CCCCCC"><strong>Nama Karyawan </strong></td>
    <td width="134" bgcolor="#CCCCCC"><strong> Potongan (Rp) </strong></td>
    <td width="222" bgcolor="#CCCCCC"><strong>Nama Potongan</strong></td>
  </tr>
	<?php
	$mySql = "SELECT potongan.*, karyawan.nik, karyawan.nm_karyawan FROM potongan
				LEFT JOIN karyawan ON potongan.nik=karyawan.nik 
				WHERE LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'
				ORDER BY potongan.id_potongan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td> <?php echo IndonesiaTgl($myData['tanggal']); ?> </td>
    <td> <?php echo $myData['nik']; ?> </td>
    <td> <?php echo $myData['nm_karyawan']; ?> </td>
    <td> <?php echo format_angka($myData['besar_potongan']); ?> </td>
    <td> <?php echo $myData['nama_potongan']; ?> </td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/potongan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>