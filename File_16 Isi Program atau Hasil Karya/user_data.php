<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM user";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="848" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA USER</b></h1></td>
  </tr>
  <tr>
    <td height="54" colspan="2" align="right"><a href="?page=User-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="46"><b>No</b></th>
        <th width="106">Kode</th>
        <th width="165"><b>Nama User</b></th>
        <th width="156"><b>No. Telepon </b></th>
        <th width="135"><b>Username</b></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Aksi</b></td>
        </tr>
      <?php
$no = 1;
if($jml == 0)
{
echo "<tr><td colspan=\"5\">Data masih kosong</td></tr>";
}
	$mySql 	= "SELECT * FROM user ORDER BY kd_user ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_user'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_user']; ?></td>
        <td><?php echo $myData['nm_user']; ?></td>
        <td><?php echo $myData['no_telepon']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td width="117" align="center"><a href="?page=User-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Ganti Password</a></td>
        <td width="83" align="center"><a href="?page=User-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Hapus</a></td>
      </tr>
      <?php } ?>
    </table>
    </td>
  </tr>
  <tr class="selKecil">
    <td width="408" height="22" bgcolor="#CCCCCC"><strong>Jumlah Data :</strong> <?php echo $jml; ?> </td>
    <td width="432" align="right" bgcolor="#CCCCCC"><strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=User-Data&hal=$list[$h]'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>

