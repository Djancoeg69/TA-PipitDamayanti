<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
?>
<html>
<head>
<title>:: Data Potongan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA POTONGAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Bulan</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $namaBulan[$dataBulan]; ?> , <?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />

<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="30" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="81" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="92" bgcolor="#CCCCCC"><b>NIK </b></td>
    <td width="184" bgcolor="#CCCCCC"><strong>Nama Karyawan </strong></td>
    <td width="110" bgcolor="#CCCCCC"><strong> Potongan (Rp) </strong></td>
    <td width="198" bgcolor="#CCCCCC"><strong>Nama Potongan</strong></td>
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
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
    <td><?php echo $myData['nik']; ?></td>
    <td><?php echo $myData['nm_karyawan']; ?></td>
    <td><?php echo format_angka($myData['besar_potongan']); ?></td>
    <td><?php echo $myData['nama_potongan']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="14" onClick="javascript:window.print()" />
</body>
</html>