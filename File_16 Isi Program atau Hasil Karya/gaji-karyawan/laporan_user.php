<?php
include_once "library/inc.sesadmin.php";
include_once "library/inc.library.php";
?>
<h2> DAFTAR USER </h2>
<form id="form1" name="form1" method="post" action="">
  <p><a href="?page=Laporan" class="konten_tombol">&laquo; Kembali</a></p>
</form>
<table class="table-list" width="559" border="0" cellspacing="1" cellpadding="2">
  <tr>
  
    <td width="106" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="230" bgcolor="#CCCCCC"><strong>Nama User</strong></td>
    <td width="207" bgcolor="#CCCCCC"><strong>Username</strong></td>  
  </tr>
	<?php
	$mySql = "SELECT * FROM user ORDER BY kd_user ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor	 = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo $myData['username']; ?></td>
  </tr>
  <?php } ?>
</table>
<br />
<a href="cetak/user.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
