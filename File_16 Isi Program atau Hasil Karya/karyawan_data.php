<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM karyawan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="800" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA KARYAWAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?page=Karyawan-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="37"><strong>No</strong></th>
        <th width="115"><strong>NIK</strong></th>
        <th width="193"><strong>Nama Karyawan </strong></th>
        <th width="175">Jenis Kelamin</th>
        <th width="153"><strong>Bagian </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
        </tr>
	<?php
	$no = 1;
if($jml == 0)
{
echo "<tr><td colspan=\"5\">Data masih kosong</td></tr>";
}
	$mySql 	= "SELECT karyawan.*, bagian.nm_bagian FROM karyawan
			LEFT JOIN bagian ON karyawan.kd_bagian=bagian.kd_bagian
			ORDER BY karyawan.nik ASC  LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['nik'];
	?>
      <tr>
        <td> <?php echo $nomor; ?> </td>
        <td> <?php echo $myData['nik']; ?> </td>
        <td> <?php echo $myData['nm_karyawan']; ?> </td>
        <td> <?php echo $myData['kelamin']; ?> </td>
        <td> <?php echo $myData['nm_bagian']; ?> </td>
        <td width="40" align="center"><a href="?page=Karyawan-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self">Ubah</a></td>
        <td width="44" align="center"><a href="?page=Karyawan-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Hapus</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <tr class="selKecil">
    <td width="389" height="22" bgcolor="#CCCCCC"><strong>Jumlah Data :</strong> <?php echo $jml; ?> </td>
    <td width="403" align="right" bgcolor="#CCCCCC"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Karyawan-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>

