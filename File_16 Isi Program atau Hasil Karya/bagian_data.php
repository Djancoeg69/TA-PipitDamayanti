<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM bagian";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="700" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA BAGIAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?page=Bagian-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="37"><b>No</b></th>
        <th width="85"><b>Kode  </b></th>
        <th width="152">Nama Bagian </th>
        <th width="147"><b>Gaji Pokok (Rp) </b></th>
        <th width="140">Uang Lembur (Rp) </th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Aksi</b><b></b></td>
        </tr>
      <?php
	  $no = 1;
if($jml == 0)
{
echo "<tr><td colspan=\"5\">Data masih kosong</td></tr>";
}
	$mySql 	= "SELECT * FROM bagian ORDER BY kd_bagian ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_bagian'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_bagian']; ?></td>
        <td><?php echo $myData['nm_bagian']; ?></td>
        <td><?php echo format_angka($myData['gaji_pokok']); ?></td>
        <td><?php echo format_angka($myData['uang_lembur']); ?></td>
        <td width="44" align="center"><a href="?page=Bagian-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Ubah</a></td>
		<td width="55" align="center"><a href="?page=Bagian-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Hapus</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <tr class="selKecil">
    <td width="401" height="22" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td width="353" align="right" bgcolor="#CCCCCC"><strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Bagian-Data&hal=$list[$h]'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>

