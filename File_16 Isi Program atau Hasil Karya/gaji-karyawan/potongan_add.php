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
	if (trim($_POST['cmbKaryawan'])=="BLANK") {
		$pesanError[] = "Data <b>Karyawan</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtBesarPotongan'])=="" ) {
		$pesanError[] = "Data <b>Besar Potongan (Rp) kosong</b>, silahkan isi datanya !";		
	}	
	if (trim($_POST['nama_potongan'])=="") {
		$pesanError[] = "Data <b>Nama Potongan</b> tidak boleh kosong !";		
	}	
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$cmbKaryawan	= $_POST['cmbKaryawan'];
	$txtTanggal		= InggrisTgl($_POST['txtTanggal']);
	$txtBesarPotongan= $_POST['txtBesarPotongan'];
	$nama_potongan	= $_POST['nama_potongan'];
	
	# BACA DATA DALAM FORM, masukkan datake variabel
	$nama_potongan			= $_POST['nama_potongan']; 
	$nama_potongan			= strtoupper($nama_potongan); //Huruf menjadi BESAR
	
	
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
		$mySql  	= "INSERT INTO potongan (nik, tanggal, besar_potongan, nama_potongan, kd_user)
						VALUES ('$cmbKaryawan', 
								'$txtTanggal', 
								'$txtBesarPotongan', 
								'$nama_potongan',
								'$userLogin')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			?>
		  <script>
		    alert('Data berhasil ditambahkan');
		    window.location="?page=Potongan-Data";
		  </script>
		  <?php
		}
		exit;
	}	
}

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKaryawan		= isset($_POST['cmbKaryawan']) ? $_POST['cmbKaryawan'] : '';
$dataTanggal		= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataBesarPotongan	= isset($_POST['txtBesarPotongan']) ? $_POST['txtBesarPotongan'] : '';
$dataPotongan		= isset($_POST['nama_potongan']) ? $_POST['nama_potongan'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"  name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="4">
    <tr>
      <th colspan="3"><div align="left"><strong>TAMBAH DATA POTONGAN</strong></div></th>
    </tr>
    <tr>
      <td height="36" colspan="3"><a href="?page=Potongan-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td><div align="right"><strong> Karyawan </strong></div></td>
      <td><strong>:</strong></td>
      <td><select name="cmbKaryawan">
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
      <td><div align="right"><strong>Tanggal </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtTanggal" type="text" value="<?php echo $dataTanggal; ?>"  maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Besar Potongan  (Rp) </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="txtBesarPotongan" type="text" onKeyPress="return goodchars(event,'1234567890',this)" id="txtBesarPotongan"  value="<?php echo $dataBesarPotongan; ?>" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td><div align="right"><strong>Nama Potongan </strong></div></td>
      <td><strong>:</strong></td>
      <td><input name="nama_potongan" type="text" id="nama_potongan" value="<?php echo $dataPotongan; ?>" size="40" maxlength="100" /></td>
      
    </tr>
    <tr>
      <td width="538">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="535">
      <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " />
      <input type="reset" name="reset" id="reset" class="konten_tombol"  value="Batal" /></td>
    </tr>
  </table>
</form>
