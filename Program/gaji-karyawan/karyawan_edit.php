
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
	if (trim($_POST['txtNik'])== "") {
		$pesanError[] = "Data <b>Kode Pelanggan </b> tidak terbaca !";		
	}
	
	if (trim($_POST['txtNamaKaryawan'])=="") {
		$pesanError[] = "Data <b>Nama Karyawan</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbBagian'])=="BLANK") {
		$pesanError[] = "Data <b>Kode Bagian</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbKelamin'])=="BLANK") {
		$pesanError[] = "Data <b>Jenia Kelamin</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbGolDarah'])=="BLANK") {
		$pesanError[] = "Data <b>Golongan Darah</b> tidak boleh kosong !";		
	}	
	if (trim($_POST['cmbAgama'])=="") {
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
		
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$mySql  = "UPDATE karyawan SET nm_karyawan='$txtNamaKaryawan', 
					 kd_bagian='$cmbBagian', kelamin='$cmbKelamin', gol_darah='$cmbGolDarah',
					 agama='$cmbAgama', alamat_tinggal='$txtAlamatTinggal', no_telepon='$txtNoTelepon', 
					 tempat_lahir='$txtTempatLahir', tanggal_lahir='$tanggalLahir',
					 status_kawin='$cmbStatusKawin', tanggal_masuk='$txtTglMasuk'  
					 WHERE nik='".$_POST['txtNik']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		 ?>
		  <script>
		    alert('Data berhasil diubah');
		    window.location="?page=Karyawan-Data";
		  </script>
		  <?php
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Karyawan-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
if($_GET) {
	# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtNik']; 
	$mySql = "SELECT * FROM karyawan WHERE nik='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
		// Baca data
		$myData = mysql_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode			= $myData['nik'];
		$dataNamaKaryawan	= isset($_POST['txtNamaKaryawan']) ? $_POST['txtNamaKaryawan'] : $myData['nm_karyawan'];
		$dataBagian			= isset($_POST['cmbBagian']) ? $_POST['cmbBagian'] : $myData['kd_bagian'];
		$dataJenisKelamin	= isset($_POST['cmbKelamin']) ? $_POST['cmbKelamin'] : $myData['kelamin'];
		$dataGolDarah		= isset($_POST['cmbGolDarah']) ? $_POST['cmbGolDarah'] : $myData['gol_darah'];
		$dataAgama			= isset($_POST['cmbAgama']) ? $_POST['cmbAgama'] : $myData['agama'];
		$dataAlamatTinggal	= isset($_POST['txtAlamatTinggal']) ? $_POST['txtAlamatTinggal'] : $myData['alamat_tinggal'];
		$dataNoTelepon		= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : $myData['no_telepon'];
		$dataTempatLahir	= isset($_POST['txtTempatLahir']) ? $_POST['txtTempatLahir'] : $myData['tempat_lahir'];
		$dataTglLahir		= isset($_POST['cmbThnLahir']) ? $_POST['cmbThnLahir'] : $myData['tanggal_lahir'];
		$dataStatusKawin	= isset($_POST['cmbStatusKawin']) ? $_POST['cmbStatusKawin'] : $myData['status_kawin'];
		$dataTglMasuk		= isset($_POST['txtTglMasuk']) ? $_POST['txtTglMasuk'] : IndonesiaTgl($myData['tanggal_masuk']);
} // Penutup GET
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>UBAH DATA KARYAWAN </b></div></th>
    </tr>
    <tr>
      <td height="32" colspan="3"><a href="?page=Karyawan-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td width="585"><div align="right"><b>NIK</b></div></td>
      <td width="5"><b>:</b></td>
      <td width="510"> <input name="txtNik" type="text"  value="<?php echo $dataKode; ?>" size="10" maxlength="5"  readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Nama Karyawan </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtNamaKaryawan" type="text" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ',this)" value="<?php echo $dataNamaKaryawan; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Bagian </strong></div></td>
      <td><b>:</b></td>
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
      <td><div align="right"><b>Jenis Kelamin </b></div></td>
      <td><b>:</b></td>
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
      <td><div align="right"><b>Gol. Darah </b></div></td>
      <td><b>:</b></td>
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
      <td><div align="right"><b>Agama</b></div></td>
      <td><b>:</b></td>
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
      <td><div align="right"><b>Alamat Tinggal </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtAlamatTinggal" type="text"  value="<?php echo $dataAlamatTinggal; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>No Telepon </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtNoTelepon" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataNoTelepon; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Tempat Lahir </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtTempatLahir" type="text"  value="<?php echo $dataTempatLahir; ?>" size="40" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Tanggal Lahir </b></div></td>
      <td><b>:</b></td>
      <td><?php echo listTanggal("Lahir",$dataTglLahir); ?></td>
    </tr>
    <tr>
      <td><div align="right"><b>Status Kawin </b></div></td>
      <td><b>:</b></td>
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
      <td><div align="right"><b>Tanggal Masuk </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtTglMasuk" type="text"    value="<?php echo $dataTglMasuk; ?>" maxlength="12" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" class="konten_tombol"  value=" Simpan " /> </td>
    </tr>
  </table>
</form>
