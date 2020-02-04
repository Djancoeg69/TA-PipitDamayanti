<?php
include_once "library/inc.sesadmin.php";

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penggajian";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<table width="777" border="0" cellpadding="2" cellspacing="0" class="table-border">
  <tr>
    <td colspan="2" align="right"><h1><b>DATA PENGGAJIAN </b></h1></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><a href="?page=Penggajian-Add" target="_self"><img src="images/ADD DATA.png" width="134" height="36" border="0" /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table class="table-list" width="100%" border="0" cellspacing="1" cellpadding="2">
      <tr>
        <th width="25"><b>No</b></th>
        <th width="78"><strong>Periode</strong></th>
        <th width="94"><strong>Tanggal</strong></th>
        <th width="105">NIK</th>
        <th width="171">Nama Karyawan </th>
        <th width="158"><b>Gaji Bersih (Rp) </b></th>
        <td colspan="3" align="center" bgcolor="#CCCCCC"><b>Aksi</b><b></b></td>
        </tr>
      <?php
	  $no = 1;
						if($jml == 0)
						{
							echo "<tr><td colspan=\"5\">Data masih kosong, silahkan melakukan penggajian baru</td></tr>";
						}else
						{
						$totalGaji = 0;} 
	  
	$mySql 	= "SELECT penggajian.*, karyawan.nik, karyawan.nm_karyawan FROM penggajian
				LEFT JOIN karyawan ON penggajian.nik=karyawan.nik 
				ORDER BY penggajian.id_slip ASC LIMIT $hal, $row";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['id_slip'];
		
		// Hitung Total Gaji Bersih
		$totalGaji = $myData['gaji_pokok'] + $myData['tunj_transport'] + $myData['tunj_makan'] + $myData['total_lembur'] ; 
		$gajiBersih= $totalGaji - $myData['total_potongan'];
	?>
    
      <tr>
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['periode_gaji']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tanggal']); ?></td>
        <td><?php echo $myData['nik']; ?></td>
        <td><?php echo $myData['nm_karyawan']; ?></td>
        <td align="center"><?php echo format_angka($gajiBersih); ?></td>
        <td width="42" align="center"><a href="penggajian_nota.php?noNota=<?php echo $Kode; ?>" target="_blank">Nota</a></td>
		<td width="59" align="center"><a href="?page=Penggajian-Delete&amp;Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PENGGAJIAN INI ... ?')">Hapus</a></td>
      </tr>
      <?php } ?>
    </table>    </td>
  </tr>
  <tr class="selKecil">
    <td width="360" height="22" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jml; ?> </td>
    <td width="409" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Penggajian-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>

