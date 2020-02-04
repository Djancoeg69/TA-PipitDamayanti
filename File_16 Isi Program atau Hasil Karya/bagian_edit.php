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
	if (trim($_POST['txtKode'])=="") {
		$pesanError[] = "Data <b>Kode</b> tidak terbaca !";		
	}
	if (trim($_POST['txtBagian'])=="") {
		$pesanError[] = "Data <b>Nama Bagian</b> tidak boleh kosong !";		
	}
	if (trim($_POST['txtGajiPokok'])=="" or ! is_numeric(trim($_POST['txtGajiPokok']))) {
		$pesanError[] = "Data <b>Gaji Pokok (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangTransport'])=="" or ! is_numeric(trim($_POST['txtUangTransport']))) {
		$pesanError[] = "Data <b>Uang Transport (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangMakan'])=="" or ! is_numeric(trim($_POST['txtUangMakan']))) {
		$pesanError[] = "Data <b>Uang Makan (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	if (trim($_POST['txtUangLembur'])=="" or ! is_numeric(trim($_POST['txtUangLembur']))) {
		$pesanError[] = "Data <b>Uang Lembur (Rp)</b> tidak boleh kosong, harus diisi angka  atau 0 !";		
	}
	
	// Validasi nama ke Database
	$cekSql="SELECT * FROM bagian WHERE nm_bagian='".$_POST['txtBagian']."' AND NOT(nm_bagian='".$_POST['txtBagianLama']."')";
	$cekQry=mysql_query($cekSql, $koneksidb) or die ("Eror Query".mysql_error()); 
	if(mysql_num_rows($cekQry)>=1){
		$pesanError[] = "NAMA BAGIAN <b>".$_POST['txtBagian']."</b> SUDAH ADA, ganti dengan yang lain";
	}
			
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtBagian			= $_POST['txtBagian'];
	$txtBagian			= strtoupper($txtBagian);
	
	$txtGajiPokok		= $_POST['txtGajiPokok'];
	$txtGajiPokok		= str_replace(".","",$txtGajiPokok);
	
	$txtUangTransport	= $_POST['txtUangTransport'];
	$txtUangTransport	= str_replace(".","",$txtUangTransport);
	
	$txtUangMakan		= $_POST['txtUangMakan'];
	$txtUangMakan		= str_replace(".","",$txtUangMakan);
	
	$txtUangLembur		= $_POST['txtUangLembur'];
	$txtHargaJutxtUangLembural	= str_replace(".","",$txtUangLembur);
	

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
		$mySql  = "UPDATE bagian SET nm_bagian='$txtBagian', gaji_pokok='$txtGajiPokok', 
					uang_transport='$txtUangTransport', uang_makan='$txtUangMakan', uang_lembur='$txtUangLembur' 
					WHERE kd_bagian='".$_POST['txtKode']."'";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		?>
		  <script>
		    alert('Data berhasil diubah');
		    window.location="?page=Bagian-Data";
		  </script>
		  <?php
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Bagian-Data'>";
		}
		exit;
	}	
} // Penutup POST

# ====================== TAMPILKAN  DATA KE FORM ===============================================
# TAMPILKAN DATA DARI DATABASE, Untuk ditampilkan kembali ke form edit
if($_GET) {
	$Kode= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
	$mySql = "SELECT * FROM bagian WHERE kd_bagian='$Kode'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query ambil data salah : ".mysql_error());
	
		// Baca data
		$myData = mysql_fetch_array($myQry);
		
		// Masukkan data ke dalam variabel
		$dataKode			= $myData['kd_bagian'];
		$dataBagian			= isset($_POST['txtBagian']) ? $_POST['txtBagian'] : $myData['nm_bagian'];
		$dataBagianLama		= $myData['nm_bagian'];
		$dataGajiPokok		= isset($_POST['txtGajiPokok']) ? $_POST['txtGajiPokok'] : $myData['gaji_pokok'];
		$dataUangTransport	= isset($_POST['txtUangTransport']) ? $_POST['txtUangTransport'] : $myData['uang_transport'];
		$dataUangMakan		= isset($_POST['txtUangMakan']) ? $_POST['txtUangMakan'] : $myData['uang_makan'];
		$dataUangLembur		= isset($_POST['txtUangLembur']) ? $_POST['txtUangLembur'] : $myData['uang_lembur'];
} // Penutup GET
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post"   name="form1" target="_self">
  <table width="100%" class="table-list" border="0" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="3"><div align="left"><b>UBAH DATA BAGIAN </b></div></th>
    </tr>
    <tr>
      <td height="36" colspan="3"><a href="?page=Bagian-Data" class="konten_tombol">&laquo; Kembali</a></td>
    </tr>
    <tr>
      <td><div align="right"><b>Kode</b></div></td>
      <td><b>:</b></td>
      <td><input name="textfield" type="text" disabled="disabled" value="<?php echo $dataKode; ?>" size="10" maxlength="10"/>
          <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Nama Bagian </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtBagian" type="text" onKeyPress="return goodchars(event,'abcdefghijklmnopqrstuvwxyz ABCDEFGHIJKLMNOPQRSTUVWXYZ',this)" value="<?php echo $dataBagian; ?>" size="40" maxlength="100" />
      <input name="txtBagianLama" type="hidden" value="<?php echo $dataBagianLama; ?>" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Gaji Pokok (Rp.) </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtGajiPokok" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataGajiPokok; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Transport  (Rp.) </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangTransport" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataUangTransport; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Makan  (Rp.) </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangMakan" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataUangMakan; ?>" size="20" maxlength="12" /></td>
    </tr>
    <tr>
      <td><div align="right"><b>Uang Lembur  (Rp.) </b></div></td>
      <td><b>:</b></td>
      <td><input name="txtUangLembur" type="text" onKeyPress="return goodchars(event,'1234567890',this)" value="<?php echo $dataUangLembur; ?>" size="20" maxlength="12" /></td>
    </tr>
    

    <tr>
      <td width="572">&nbsp;</td>
      <td width="5">&nbsp;</td>
      <td width="558">
        <input type="submit" name="btnSimpan" class="konten_tombol" value=" Simpan " /> </td>
    </tr>
  </table>
</form>
