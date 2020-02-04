<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";

// Membaca data dari Form Filter
$dataTahun = isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y');
$dataBulan = isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m');
?>
<h2> DATA LEMBUR </h2>
<form id="form2" name="form2" method="post" action="">
  <p><a href="?page=Laporan" class="konten_tombol">&laquo; Kembali</a></p>
</form>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
     <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>   
    <tr>
      <td width="114"><strong>Periode Bulan </strong></td>
      <td width="10"><strong>:</strong></td>
      <td width="362"><select name="cmbBulan">
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

<table class="table-list" width="640" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="37" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="107" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="121" bgcolor="#CCCCCC"><strong>NIK </strong></td>
    <td width="175" bgcolor="#CCCCCC"><strong>Karyawan </strong></td>
    <td width="284" bgcolor="#CCCCCC"><strong>Keterangan </strong></td>
  </tr>
  <?php
	$mySql 	= "SELECT lembur.*, karyawan.nik, karyawan.nm_karyawan FROM lembur
				LEFT JOIN karyawan ON lembur.nik=karyawan.nik 
				WHERE LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'
				ORDER BY lembur.id ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
    <td><?php echo $kolomData['nik']; ?></td>
    <td><?php echo $kolomData['nm_karyawan']; ?></td>
    <td><?php echo $kolomData['keterangan']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/lembur.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>