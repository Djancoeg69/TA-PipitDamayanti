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
<title>:: Data Penggajian</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA PENGGAJIAN </h2>
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

<table class="table-list" width="937" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tanggal </strong></td>
    <td width="74" bgcolor="#CCCCCC"><strong>NIK</strong></td>
    <td width="156" bgcolor="#CCCCCC"><strong>Nama Karyawan </strong></td>
    <td width="86" bgcolor="#CCCCCC"><strong>Gaji Pokok(+) </strong></td>
    <td width="94" bgcolor="#CCCCCC"><strong>Tunj Makan(+) </strong></td>
    <td width="94" bgcolor="#CCCCCC"><strong>Tunj Transport(+) </strong></td>
    <td width="101" bgcolor="#CCCCCC"><strong>Total Lembur(+) </strong></td>
    <td width="83" bgcolor="#CCCCCC"><strong>Total Potongan(-) </strong></td>
  </tr>
  <?php
	$mySql = "SELECT penggajian.*, karyawan.nik, karyawan.nm_karyawan FROM penggajian
				LEFT JOIN karyawan ON penggajian.nik=karyawan.nik 
				WHERE LEFT(periode_gaji,2)='$dataBulan' AND RIGHT(periode_gaji,4)='$dataTahun'
				ORDER BY penggajian.id_slip ASC";
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
    <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
    <td><?php echo format_angka($myData['tunj_makan']); ?></td>
    <td><?php echo format_angka($myData['tunj_transport']); ?></td>
    <td><?php echo format_angka($myData['total_lembur']); ?></td>
    <td><?php echo format_angka($myData['total_potongan']); ?></td>
    </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>