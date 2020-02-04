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
	if (trim($_POST['txtBagian'])=="") {
		$pesanError[] = "Data <b>Nama Bagian</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtGajiPokok'])=="") {
		$pesanError[] = "Data <b>Gaji Pokok (Rp)</b> tidak boleh kosong!";		
	}
	if (trim($_POST['txtUangTransport'])=="" ) {
		$pesanError[] = "Data <b>Uang Transport (Rp)</b> tidak boleh kosong!";		
	}
	if (trim($_POST['txtUangMakan'])=="") {
		$pesanError[] = "Data <b>Uang Makan (Rp)</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtUangLembur'])=="" ) {
		$pesanError[] = "Data <b>Uang Lembur (Rp)</b> tidak boleh kosong !";		
	}
	
	// Validasi nama ke Database
	$cekSql="SELECT * FROM bagian WHERE nm_bagian='".$_POST['txtBagian']."'";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "NAMA BAGIAN <b>".$_POST['txtBagian']."</b> SUDAH ADA, ganti dengan yang lain";
	}
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtBagian			= $_POST['txtBagian']; 
	$txtBagian			= strtoupper($txtBagian); // huruf menjadi BESAR
	
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtGajiPokok		= str_replace(".","",$txtGajiPokok); // menghilangkan karakter titik dalam angka
	
	$txtUangTransport	= $_POST['txtUangTransport'];
	$txtUangTransport	= str_replace(".","",$txtUangTransport); // menghilangkan karakter titik dalam angka
	
	$txtUangMakan		= $_POST['txtUangMakan'];
	$txtUangMakan		= str_replace(".","",$txtUangMakan); // menghilangkan karakter titik dalam angka
	
	$txtUangLembur		= $_POST['txtUangLembur'];
	$txtHargaJutxtUangLembural	= str_replace(".","",$txtUangLembur); // menghilangkan karakter titik dalam angka
	
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
		$kodeBaru	= buatKode("bagian", "BAG");
		$mySql  	= "INSERT INTO bagian (kd_bagian, nm_bagian, gaji_pokok, uang_transport, uang_makan, uang_lembur)
						VALUES ('$kodeBaru', 
								'$txtBagian', 
								'$txtGajiPokok', 
								'$txtUangTransport', 
								'$txtUangMakan',
								'$txtUangLembur')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			?>
 <script>
 alert('Data berhasil ditambahkan');
window.location="?page=Bagian-Data";
 </script>
 <?php

		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode			= buatKode("bagian", "BAG");
$dataBagian			= isset($_POST['txtBagian']) ? $_POST['txtBagian'] : '';
$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : '';
$dataUangTransport	= isset($_POST['txtUangTransport']) ? $_POST['txtUangTransport'] : '';
$dataUangMakan		= isset($_POST['txtUangMakan']) ? $_POST['txtUangMakan'] : '';
$dataUangLembur		= isset($_POST['txtUangLembur']) ? $_POST['txtUangLembur'] : '';
?>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>TAMBAH DATA BAGIAN </b></div></th>
    </tr>
    <tr>
      <td height="32" colspan="3"><a href="?page=Bagian-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td><div align="right"><b>Kode</b></div></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" disabled="disabled" value="<?php echo $dataKode; ?>" size="10" maxlength="10"/></td>
    </tr>
    <tr>
      <td><div align="right"><b>Nama Bagian </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtBagian" type="text" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ',this)" value="<?php echo $dataBagian; ?>" size="40" maxlength="100" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Gaji Pokok (Rp.)  </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtGajiPokok" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataGajiPokok; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Transport  (Rp.)  </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangTransport" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataUangTransport; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Makan  (Rp.)  </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangMakan" type="text"  onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataUangMakan; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Lembur  (Rp.)  </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangLembur" type="text" onKeyPress="return goodchars(event,'1234567890',this)"  value="<?php echo $dataUangLembur; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td width="557">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="555">
      <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " />
      <input type="reset" name="reset" id="reset" class="konten_tombol" value="Batal" /></td>
    </tr>
  </table>
</form>
