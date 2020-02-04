<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['cmbKaryawan'])=="BLANK") {
		$pesanError[] = "Data <b>Karyawan</b> tidak boleh kosong, <b> ini adalah karyawan yang akan digaji</b> !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbBulan			= $_POST['cmbBulan'];
	$cmbTahun			= $_POST['cmbTahun'];
	$cmbKaryawan		= $_POST['cmbKaryawan'];
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtTunjTransport	= $_POST['txtTunjTransport'];
	$txtTunjMakan		= $_POST['txtTunjMakan'];
	$txtTotalLembur		= $_POST['txtTotalLembur'];
	$txtTotalPotongan	= $_POST['txtTotalPotongan'];
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. Jika tidak menemukan pesan error, simpan data ke database
		$userLogin	= $_SESSION['SES_LOGIN'];
		$kodeBaru	= buatKode("penggajian", "PGJ");
		$tanggalGaji= date('Y-m-d');
		$mySql  	= "INSERT INTO penggajian(id_slip, periode_gaji, tanggal, nik, gaji_pokok, tunj_transport, tunj_makan, 
												total_lembur, total_potongan, kd_user)
						VALUES ('$kodeBaru', 
								'$cmbBulan-$cmbTahun',
								'$tanggalGaji', 
								'$cmbKaryawan', 
								'$txtGajiPokok', 
								'$txtTunjTransport',
								'$txtTunjMakan',
								'$txtTotalLembur', 
								'$txtTotalPotongan', '$userLogin')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query 1".mysql_error());
		
			
			// Refresh Jendela baru
			echo "<script>";
			echo "window.open('penggajian_nota.php?noNota=$kodeBaru', width=330,height=330,left=100, top=25)";
			echo "</script>";

			echo "<meta http-equiv='refresh' content='0; url=?page=Penggajian-Data'>";
		}
		exit;
	}	
 // Penutup POST

# MASUKKAN DATA KE VARIABEL
$dataKode			= buatKode("penggajian", "PGJ");
$dataKaryawan		= isset($_POST['cmbKaryawan']) ? $_POST['cmbKaryawan'] : '';

$dataBulan			= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : date('m')-1; // bulan kemaren (asumsi Penggajian dilakukan di tanggal 1, bulan berikutnya)

// Membuat angka bulan selalu 2 digit (01, 02, 03.....12)
if(strlen($dataBulan)=="1") { $dataBulan= "0".$dataBulan; } else { $dataBulan = $dataBulan; }

$dataTahun			= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : date('Y'); // tahun sekarang

// Mendapatkan Informasi Gaji Pokok + Tunjangan dari tabel BAGIAN
$mySql = "SELECT bagian.* FROM bagian, karyawan WHERE karyawan.kd_bagian=bagian.kd_bagian AND karyawan.nik='$dataKaryawan'";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$myData= mysql_fetch_array($myQry);

$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : '0';
$dataGajiPokok		= isset($myData['gaji_pokok']) ? $myData['gaji_pokok'] : $dataGajiPokok;

$dataTunjTransport	= isset($_POST['txtTunjTransport']) ? $_POST['txtTunjTransport'] : '0';
$dataTunjTransport	= isset($myData['uang_transport']) ? $myData['uang_transport'] : $dataTunjTransport;

$dataTunjMakan		= isset($_POST['txtTunjMakan']) ? $_POST['txtTunjMakan'] : '0';
$dataTunjMakan		= isset($myData['uang_makan']) ? $myData['uang_makan'] : $dataTunjMakan;

// Menghitung Total Lembur
$my2Sql = "SELECT COUNT(*) tot_lembur FROM lembur WHERE nik='$dataKaryawan' AND LEFT(tanggal,4)='$dataTahun' AND MID(tanggal,6,2)='$dataBulan'";
$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 2 salah : ".mysql_error());
$my2Data= mysql_fetch_array($my2Qry);  
$totalLembur = $my2Data['tot_lembur'] * $myData['uang_lembur'];

$dataTotalLembur	= isset($_POST['txtTotalLembur']) ? $_POST['txtTotalLembur'] : '0';
$dataTotalLembur	= isset($my2Data['tot_lembur']) ? $totalLembur : $dataTotalLembur;


// Menghitung Total Potongan
$my3Sql = "SELECT SUM(besar_potongan) tot_potongan FROM potongan 
			WHERE nik='$dataKaryawan'";
$my3Qry = mysql_query($my3Sql, $koneksidb)  or die ("Query 3 salah : ".mysql_error());
$my3Data= mysql_fetch_array($my3Qry);  

$dataTotalPotongan	= isset($_POST['txtTotalPotongan']) ? $_POST['txtTotalPotongan'] : '0';
$dataTotalPotongan	= isset($my3Data['tot_potongan']) ? $my3Data['tot_potongan'] : $dataTotalPotongan;
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th height="26" colspan="3"><div align="left"><b>TRANSAKSI PENGGAJIAN BARU</b></div></th>
    </tr>
    <tr>
      <td><div align="right"><strong>No. Slip</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="textfield" type="text" disabled="disabled" value="<?php echo $dataKode; ?>" size="10" maxlength="10"/></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Periode Bulan </strong></div></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBulan">
          <?php
	$namaBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
					 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
					 "08" => "Agustus", "09" => "September", "10" => "Oktober",
					 "11" => "November", "12" => "Desember");

	  foreach($namaBulan as $bulanKe => $bulanNM) {
	  	if ($bulanKe == $dataBulan) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bulanKe' $cek>$bulanKe - $bulanNM</option>";
	  }
	  ?>
        </select>
          <select name="cmbTahun">
            <?php
		$tahunKemaren = date('Y') - 1;
	  for($thn= $tahunKemaren; $thn <= date('Y'); $thn++) {
	  	if ($thn == $dataTahun) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$thn' $cek>$thn</option>";
	  }
	  ?>
        </select></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Karyawan </strong></div></td>
      <td><strong>:</strong></td>
      <td><select name="cmbKaryawan"  onchange="javascript:submitform();">
        <option value="BLANK">....</option>
        <?php
	  $dataSql = "SELECT * FROM karyawan ORDER BY nik";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataKaryawan == $dataRow['nik']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[nik]' $cek>[ $dataRow[nik] ] $dataRow[nm_karyawan]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Gaji Pokok  (Rp)</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtGajiPokok" type="text" value="<?php echo $dataGajiPokok; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tunjangan Transport (Rp)</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjTransport" type="text" value="<?php echo $dataTunjTransport; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tunjangan Makan  (Rp)</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTunjMakan" type="text" value="<?php echo $dataTunjMakan; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Total Lembur  (Rp)</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalLembur" type="text"  value="<?php echo $dataTotalLembur; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>Potongan Gaji</strong></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Total Potongan  (Rp)</strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTotalPotongan" type="text"  value="<?php echo $dataTotalPotongan; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td width="584">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="528">
      <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " />      </td>
    </tr>
  </table>
</form>
