<?php
//nik sesuai tanggal masuk
$today=date("ymd");
$query = "SELECT max(nik) AS last FROM karyawan WHERE nik LIKE '$today%'" or die ("Query failed with error: ".mysql_error()) ;
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$lastNoTransaksi = $data['last'];
$lastNoUrut = substr($lastNoTransaksi, 8, 4);
$nextNoUrut = $lastNoUrut + 1;
$nextNoTransaksi = $today.sprintf('%03s', $nextNoUrut);
?>


<script language="javascript">
function getkey(e)
{
if (window.event)
   return window.event.keyCode;
else if (e)
   return e.which;
else
   return null;
}
function goodchars(e, goods, field)
{
var key, keychar;
key = getkey(e);
if (key == null) return true;
 
keychar = String.fromCharCode(key);
keychar = keychar.toLowerCase();
goods = goods.toLowerCase();
 
if (goods.indexOf(keychar) != -1)
    return true;
// control keys
if ( key==null || key==0 || key==8 || key==9 || key==27 )
   return true;
    
if (key == 13) {
    var i;
    for (i = 0; i < field.form.elements.length; i++)
        if (field == field.form.elements[i])
            break;
    i = (i + 1) % field.form.elements.length;
    field.form.elements[i].focus();
    return false;
    };
// else return false
return false;
}
</script>


<?php
include_once "library/inc.sesadmin.php";

if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtNik'])=="") {
		$pesanError[] = "Data <b>NIK</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtNamaKaryawan'])=="") {
		$pesanError[] = "Data <b>Nama Karyawan</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbBagian'])=="BLANK") {
		$pesanError[] = "Data <b>Bagian</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbKelamin'])=="BLANK") {
		$pesanError[] = "Data <b>Jenis Kelamin</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbGolDarah'])=="BLANK") {
		$pesanError[] = "Data <b>Golongan Darah</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbAgama'])=="BLANK") {
		$pesanError[] = "Data <b>Agama</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtAlamatTinggal'])=="") {
		$pesanError[] = "Data <b>Alamat Tinggal</b> tidak boleh kosong !";	
	}	
	if (trim($_POST['txtNoTelepon'])=="") {
		$pesanError[] = "Data <b>Nomor Telepon</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['txtTempatLahir'])=="") {
		$pesanError[] = "Data <b>Tempat Lahir</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbStatusKawin'])=="BLANK") {
		$pesanError[] = "Data <b>Status Kawin</b> tidak boleh kosong !";		
	}		
	if (trim($_POST['txtTglMasuk'])=="") {
		$pesanError[] = "Data <b>Tanggal Masuk</b> tidak boleh kosong !";		
	}	
		
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNik				= $_POST['txtNik'];
	$txtNamaKaryawan	= $_POST['txtNamaKaryawan'];
	$cmbBagian			= $_POST['cmbBagian'];
	$cmbKelamin			= $_POST['cmbKelamin'];
	$cmbGolDarah		= $_POST['cmbGolDarah'];
	$cmbAgama			= $_POST['cmbAgama'];
	$txtAlamatTinggal	= $_POST['txtAlamatTinggal'];
	$txtNoTelepon		= $_POST['txtNoTelepon'];
	$txtTempatLahir		= $_POST['txtTempatLahir'];
	$cmbStatusKawin		= $_POST['cmbStatusKawin'];
	$txtTglMasuk		= InggrisTgl($_POST['txtTglMasuk']);
	
	// Membaca form tanggal lahir (comboBox : tanggal, bulan dan tahun lahir)
	$cmbTglLahir		= $_POST['cmbTglLahir'];
	$cmbBlnLahir		= $_POST['cmbBlnLahir'];
	$cmbThnLahir		= $_POST['cmbThnLahir'];
	$tanggalLahir		= "$cmbThnLahir-$cmbBlnLahir-$cmbTglLahir";

	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNamaKaryawan			= $_POST['txtNamaKaryawan']; 
	$txtNamaKaryawan			= strtoupper($txtNamaKaryawan); // huruf menjadi BESAR
	
	$cmbKelamin				= $_POST['cmbKelamin'];
	$cmbKelamin				= strtoupper($cmbKelamin);
	
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
	
		$mySql  	= "INSERT INTO karyawan (nik, nm_karyawan, kd_bagian, kelamin, 
		                                     gol_darah, agama, alamat_tinggal, no_telepon, tempat_lahir, 
							                  tanggal_lahir, status_kawin,  tanggal_masuk)
						VALUES ('$txtNik', '$txtNamaKaryawan', '$cmbBagian','$cmbKelamin','$cmbGolDarah',
						'$cmbAgama','$txtAlamatTinggal','$txtNoTelepon','$txtTempatLahir', '$tanggalLahir','$cmbStatusKawin','$txtTglMasuk')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			?>
 <script>
 alert('Data berhasil ditambahkan');
window.location="?page=Karyawan-Data";
 </script>
 <?php
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah

$dataNamaKaryawan	= isset($_POST['txtNamaKaryawan']) ? $_POST['txtNamaKaryawan'] : '';
$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : '';
$dataJenisKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : '';
$dataGolDarah		= isset($_POST['cmbGolDarah']) ? $_POST['cmbGolDarah'] : '';
$dataAgama			= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : '';
$dataAlamatTinggal	= isset($_POST['txtAlamatTinggal']) ? $_POST['txtAlamatTinggal'] : '';
$dataNoTelepon		= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataTempatLahir	= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : '';
$dataStatusKawin	= isset($_POST['cmbStatusKawin']) ? $_POST['cmbStatusKawin'] : '';
$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : date('d-m-Y');

$dataThn			= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : date('Y');
$dataBln			= isset($_POST['cmbBlnLahir']) ? $_POST['cmbBlnLahir'] : date('m');
$dataTgl			= isset($_POST['cmbTglLahir']) ? $_POST['cmbTglLahir'] : date('d');
$dataTglLahir 		= $dataThn."-".$dataBln."-".$dataTgl;
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left">TAMBAH DATA KARYAWAN </div></th>
    </tr>
    <tr>
      <td height="34" colspan="3"><a href="?page=Karyawan-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td width="576"><div align="right"><strong>NIK</strong></div></td>
      <td width="5"><strong>:</strong></td>
      <td width="519"> <input name="txtNik" type="text" value="<?php echo $nextNoTransaksi; ?>" size="10" maxlength="10" readonly="disabled"/></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Nama Karyawan </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtNamaKaryawan" type="text" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ',this)" value="<?php echo $dataNamaKaryawan; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Bagian </strong></div></td>
      <td><strong>:</strong></td>
      <td><select name="cmbBagian">
          <option value="BLANK">....</option>
          <?php
	  $dataSql = "SELECT * FROM bagian ORDER BY kd_bagian";
	  $dataQry = mysql_query($dataSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($dataRow = mysql_fetch_array($dataQry)) {
	  	if ($dataBagian == $dataRow['kd_bagian']) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$dataRow[kd_bagian]' $cek>$dataRow[nm_bagian]</option>";
	  }
	  $sqlData ="";
	  ?>
      </select></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Jenis Kelamin </strong></div></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbKelamin">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("Perempuan", "Laki-laki");
          foreach ($pilihan as $nilai) {
            if ($dataJenisKelamin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Gol. Darah </strong></div></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbGolDarah">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("A", "B", "AB", "O");
          foreach ($pilihan as $nilai) {
            if ($dataGolDarah==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Agama</strong></div></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbAgama">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("Islam", "Kristen", "Katolik", "Hindu", "Budha");
          foreach ($pilihan as $nilai) {
            if ($dataAgama==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Alamat Tinggal </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtAlamatTinggal" type="text"  value="<?php echo $dataAlamatTinggal; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>No Telepon </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtNoTelepon" type="text" onKeyPress="return goodchars(event,'1234567890',this)"  value="<?php echo $dataNoTelepon; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tempat Lahir  </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" size="40" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tanggal Lahir </strong></div></td>
      <td><strong>:</strong></td>
      <td><?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Status Kawin </strong></div></td>
      <td><strong>:</strong></td>
      <td><b>
        <select name="cmbStatusKawin">
          <option value="BLANK">....</option>
          <?php
		  $pilihan	= array("Kawin", "Belum Kawin");
          foreach ($pilihan as $nilai) {
            if ($dataStatusKawin==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?>
        </select>
      </b></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Tanggal Masuk </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTglMasuk" type="text" value="<?php echo $dataTglMasuk; ?>" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" class="konten_tombol"  value=" Simpan " />
        <input type="reset" name="reset" id="reset" class="konten_tombol" value="Batal" /></td>
    </tr>
  </table>
</form>
