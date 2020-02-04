<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM lembur";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="746" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA LEMBUR </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?page=Lembur-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="45"><b>No</b></th>
        <th width="115"><b>Tanggal</b></th>
        <th width="124">NIK </th>
        <th width="161">Karyawan </th>
        <th width="128">Keterangan</th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><b>Aksi</b><b></b></td>
        </tr>
      <?php
	  $no = 1;
if($jml == 0)
{
echo "<tr><td colspan=\"5\">Data masih kosong</td></tr>";
}
	   
	$mySql 	= "SELECT lembur.*, karyawan.nik, karyawan.nm_karyawan FROM lembur
				LEFT JOIN karyawan ON lembur.nik=karyawan.nik 
				ORDER BY lembur.id DESC  LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['id'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo IndonesiaTgl($kolomData['tanggal']); ?></td>
        <td><?php echo $kolomData['nik']; ?></td>
        <td><?php echo $kolomData['nm_karyawan']; ?></td>
        <td><?php echo $kolomData['keterangan']; ?></td>
        <td width="70" align="center"><a href="?page=Lembur-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Ubah</a></td>
		<td width="63" align="center"><a href="?page=Lembur-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Hapus </a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <tr class="selKecil">
    <td width="363" height="22" bgcolor="#CCCCCC"><strong>Jumlah Data : <?php echo $jml; ?> </strong></td>
    <td width="375" align="right" bgcolor="#CCCCCC"> <strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Lembur-Data&hal=$list[$h]'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>

