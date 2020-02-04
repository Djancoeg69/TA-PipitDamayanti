<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if(isset($_GET['KdBagian'])){
	$dataBagian	= isset($_GET['KdBagian']) ? $_GET['KdBagian'] : 'ALL'; 
	
	if($dataBagian=="ALL") {
		$filterSql	= "";
		$namaBagian= "Semua Bagian";
	}
	else {
		$filterSql	= "WHERE karyawan.kd_bagian='$dataBagian'";
		
		// Untuk informasi 
		$infoSql	= "SELECT * FROM bagian WHERE kd_bagian='$dataBagian'";
		$infoQry	= mysql_query($infoSql, $koneksidb) or die ("Gagal Query".mysql_error());
	    $infoRow 	= mysql_fetch_array($infoQry);
		$namaBagian = $infoRow['nm_bagian'];
	}
}
?>
<html>
<head>
<title>:: Data Karyawan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DATA KARYAWAN </h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Bagian</strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $namaBagian; ?></td>
  </tr>
</table>
<br />

<table class="table-list" width="950" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="33" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="111" bgcolor="#CCCCCC"><strong>Nik</strong></td>
    <td width="167" bgcolor="#CCCCCC"><strong>Nama Karyawan </strong></td>
    <td width="135" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
    <td width="87" bgcolor="#CCCCCC"><strong> Kelamin</strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong>G Darah </strong></td>
    <td width="81" bgcolor="#CCCCCC"><strong>Agama</strong></td>
    <td width="219" bgcolor="#CCCCCC"><strong>Alamat Tinggal </strong></td>
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
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>