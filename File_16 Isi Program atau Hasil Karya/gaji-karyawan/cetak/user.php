<?php
session_start();
include_once "../library/inc.sesadmin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

?>
<html>
<head>
<title> :: Daftar User</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2> DAFTAR USER </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="88" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="250" bgcolor="#CCCCCC"><strong>Nama User</strong></td>
    <td width="246" bgcolor="#CCCCCC"><strong>Username</strong></td>
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
<img src="../images/btn_print.png" width="20" onClick="javascript:window.print()" />
</body>
</html>