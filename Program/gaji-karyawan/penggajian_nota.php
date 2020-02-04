<?php
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

# Baca variabel URL
$noNota = $_GET['noNota'];

# Perintah untuk mendapatkan data dari tabel penggajian
$mySql = "SELECT penggajian.*, user.nm_user, karyawan.nik, karyawan.nm_karyawan, bagian.nm_bagian, bagian.uang_lembur
			FROM penggajian
			LEFT JOIN user ON penggajian.kd_user=user.kd_user 
			LEFT JOIN karyawan ON penggajian.nik=karyawan.nik
			LEFT JOIN bagian ON karyawan.kd_bagian=bagian.kd_bagian
			WHERE id_slip='$noNota'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

$kdKaryawan = $myData['nik'];

$dataBulan	= substr($myData['periode_gaji'],0,2); // ambil bulan
$dataTahun	= substr($myData['periode_gaji'],3,4); // ambil tahun

// Hitung Gaji Total
$totalGaji	= 0;
$totalGaji	= $totalGaji + $myData['gaji_pokok'];
$totalGaji	= $totalGaji + $myData['tunj_transport'];
$totalGaji	= $totalGaji + $myData['tunj_makan'];
$totalGaji	= $totalGaji + $myData['total_lembur'];
$totalGaji	= $totalGaji - $myData['total_potongan'];
?>
<html>
<head>
<title> :: Slip Gaji Karyawan</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="styles/styles_cetak.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
	window.print();
	window.onfocus=function(){ window.close();}
</script>
</head>
<body onLoad="window.print()">
<table class="table-list" width="430" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="4" align="center"><h2>SLIP GAJI </h2></td>
  </tr>
  <tr>
    <td  colspan="4" align="center">
      <table width="100%" border="0" cellpadding="2" cellspacing="1">
        <tr>
          <td width="24%"><strong>Tanggal</strong></td>
          <td width="4%"><strong>:</strong></td>
          <td width="72%"> <?php echo IndonesiaTgl($myData['tanggal']); ?> </td>
        </tr>
        <tr>
          <td><strong>Periode Gaji</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['periode_gaji']; ?> </td>
        </tr>
        <tr>
          <td><strong>Nama</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['nik']." / ".$myData['nm_karyawan']; ?> </td>
        </tr>
        <tr>
          <td><strong>Bagian</strong></td>
          <td><strong>:</strong></td>
          <td> <?php echo $myData['nm_bagian']; ?> </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td width="294" align="right"><strong>Gaji Pokok   (Rp)+ : </strong></td>
    <td width="125" align="right"><?php echo format_angka($myData['gaji_pokok']); ?></td>
  </tr>
  <tr>
    <td align="right"><strong>  Tunjangan Transport (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['tunj_transport']); ?></td>
  </tr>
  <tr>
    <td align="right"><strong>Tunjangan Makan (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['tunj_makan']); ?></td>
  </tr>
  
 <?php
 $my2Sql = "SELECT * FROM lembur WHERE nik='$kdKaryawan' 
 			AND LEFT(tanggal,4)='$dataTahun' 
			AND MID(tanggal,6,2)='$dataBulan'";
 $my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error()); 
 $lemburKe =0;
 while($my2Data= mysql_fetch_array($my2Qry)) {
 $lemburKe++;
 ?>
  <tr>
    <td align="right"><strong>Uang Lembur  <?php echo $lemburKe; ?> (Rp)+ : </strong></td>
    <td align="right"><?php echo format_angka($myData['uang_lembur']); ?></td>
  </tr>
  <?php } ?>
  
  <?php
 $my3Sql = "SELECT * FROM potongan WHERE nik='$kdKaryawan' ";
 $my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
 while($my3Data= mysql_fetch_array($my3Qry)) {
 ?>
  <tr>
    <td align="right"><strong>Total Potongan  (Rp)- : </strong></td>
    <td align="right"><?php echo format_angka($my3Data['besar_potongan']); ?></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td align="right" bgcolor="#CCCCCC"><strong>Total Gaji   (Rp) : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><b><?php echo format_angka($totalGaji); ?></b></td>
  </tr>
  <tr>
    <td colspan="4">Admin : <?php echo $myData['nm_user']; ?></td>
  </tr>
</table>
<table width="430" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">** TERIMA KASIH ** </td>
  </tr>
</table>
</body>
</html>