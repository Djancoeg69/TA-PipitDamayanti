<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2> DATA BAGIAN </h2>
<form id="form1" name="form1" method="post" action="">
  <a href="?page=Laporan" class="konten_tombol">&laquo; Kembali</a>
</form>
<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="41" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="134" bgcolor="#CCCCCC"><strong>Nama Bagian </strong></td>
    <td width="135" bgcolor="#CCCCCC"><strong>Gaji Pokok (Rp) </strong></td>
    <td width="151" bgcolor="#CCCCCC"><strong>Uang Transport (Rp) </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Uang Makan (Rp) </strong></td>
    <td width="128" bgcolor="#CCCCCC"><strong>Uang Lembur (Rp) </strong></td>
  </tr>
	<?php
	$mySql = "SELECT * FROM bagian ORDER BY kd_bagian ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_bagian']; ?></td>
    <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
    <td><?php echo format_angka($myData['uang_transport']); ?></td>
    <td><?php echo format_angka($myData['uang_makan']); ?></td>
    <td><?php echo format_angka($myData['uang_lembur']); ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/bagian.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>