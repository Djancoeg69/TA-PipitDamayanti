
<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
include_once "library/inc.tanggal.php";

date_default_timezone_set("Asia/Jakarta"); 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> :: APLIKASI PENGGAJIAN KARYAWAN - Sistem Penggajian Karyawan</title>
<link href="styles/style_admin.css" rel="stylesheet" type="text/css">
<link href="styles/menu.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="plugins/tigra_calendar/tcal.css" />
<script type="text/javascript" src="plugins/tigra_calendar/tcal.js"></script> 
<style type="text/css">
<!--
body {
	background:#999;
}
body,td,th {
	font-family: Arial;
}
-->
</style></head>
<div id="wrap">
<table width="100%" class="table-print">
  <tr>
    <td height="100" colspan="2"><a href="?page"><div id="header"></div>
    </a></td>
  </tr>
  <tr valign="top">
    <td width="1%" bgcolor="#FFF"  style="border:0px solid #CCC;"><div style="margin:0px; padding:5px;"><?php include "menu.php"; ?></div></td>
    <td width="69%" height="495" bgcolor="#ADE8E6" background="images/white.jpg">
    <div style="margin:5px; padding:5px;"><?php include "buka_file.php";?></div>
    </td>
  </tr>
</table>

</body>
<div id="footer">
<div align="center">Copyright &copy; 2014 Pipit Damayanti (BSI BOGOR) </div>
</div>
</html>
