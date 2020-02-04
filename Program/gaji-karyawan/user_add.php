
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

# PADA SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($_POST['txtNamaUser'])=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtTelpon'])=="") {
		$pesanError[] = "Data <b>No. Telpon</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtUsername'])=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtPassword'])=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong !";		
	}
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNamaUser= $_POST['txtNamaUser'];
	$txtUsername= $_POST['txtUsername'];
	$txtPassword= $_POST['txtPassword'];
	$txtTelpon	= $_POST['txtTelpon'];
	
	# VALIDASI NAMA, jika sudah ada akan ditolak
	$cekSql="SELECT * FROM user WHERE username='$txtUsername'";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "USERNAME <b> $txtUsername </b> SUDAH ADA, ganti dengan yang lain";
	}
	
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNamaUser			= $_POST['txtNamaUser']; 
	$txtNamaUser			= strtoupper($txtNamaUser); // huruf menjadi BESAR

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
		$kodeBaru	= buatKode("user", "USR");
		$mySql  	= "INSERT INTO user (kd_user, nm_user, no_telepon, 
										 username, password)
						VALUES ('$kodeBaru', 
								'$txtNamaUser', 
								'$txtTelpon', 
								'$txtUsername', 
								'$txtPassword')"; 
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			?>
 <script>
 alert('Data berhasil ditambahkan');
window.location="?page=User-Data";
 </script>
 <?php
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("user", "USR");
$dataNamaUser	= isset($_POST['txtNamaUser']) ? $_POST['txtNamaUser'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataTelpon		= isset($_POST['txtTelpon']) ? $_POST['txtTelpon'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>TAMBAH DATA USER </b></div></th>
    </tr>
    <tr>
      <td height="33" colspan="3"><a href="?page=User-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td width="554"><div align="right"><b>Kode</b></div></td>
      <td width="5"><b>:</b></td>
      <td width="558"> <input name="textfield" type="text" disabled="disabled" value="<?php echo $dataKode; ?>" size="10" maxlength="6"/></td>
    </tr>
    <tr>
      <td><div align="right"><b>Nama User </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtNamaUser" type="text" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ',this)" value="<?php echo $dataNamaUser; ?>" size="40" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>No. Telepon </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtTelpon" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataTelpon; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Username</b></div></td>
      <td><b>:</b></td>
      <td> <input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="30" maxlength="50" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Password</b></div></td>
      <td><b>:</b></td>
      <td><input name="txtPassword" type="password" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " />
        <input type="reset" name="reset" id="reset" class="konten_tombol" value="Batal" /></td>
    </tr>
  </table>
</form>
