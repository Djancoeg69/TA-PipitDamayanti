<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM potongan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="742" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h2><b>DATA POTONGAN GAJI </b></h2></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?page=Potongan-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="25"><strong>No</strong></th>
        <th width="87"><strong>Tanggal</strong></th>
        <th width="83"><strong>NIK </strong></th>
        <th width="142"><strong>Nama Karyawan </strong></th>
        <th width="125"><strong>Potongan(Rp) </strong></th>
        <th width="141"><strong>Nama Potongan </strong></th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
        </tr>
      <?php
	  $no = 1;
if($jml == 0)
{							
echo "<tr><td colspan=\"5\">Data masih kosong</td></tr>";
}
	$mySql 	= "SELECT potongan.*, karyawan.nik, karyawan.nm_karyawan FROM potongan
				LEFT JOIN karyawan ON potongan.nik=karyawan.nik
				ORDER BY potongan.id_potongan DESC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($kolomData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $kolomData['id_potongan'];
	?>
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $kolomData['tanggal']; ?></td>
        <td><?php echo $kolomData['nik']; ?></td>
        <td><?php echo $kolomData['nm_karyawan']; ?></td>
        <td align="left"><?php echo format_angka($kolomData['besar_potongan']); ?></td>
        <td><?php echo $kolomData['nama_potongan']; ?></td>
        <td width="41" align="center"><a href="?page=Potongan-Edit&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Ubah</a></td>
		<td width="53" align="center"><a href="?page=Potongan-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENTING INI ... ?')">Hapus</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <tr class="selKecil">
    <td width="401" height="22" bgcolor="#CCCCCC"><strong>Jumlah Data :</strong> <?php echo $jml; ?> </td>
    <td width="333" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b> 
	<?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Potongan-Data&hal=$list[$h]'>$h</a> ";
	}
	?>	</td>
  </tr>
</table>

