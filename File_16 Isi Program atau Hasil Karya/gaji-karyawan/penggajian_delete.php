<?php
include_once "library/inc.sesadmin.php";

if($_GET) {
	if(empty($_GET['Kode'])){
		echo "<b>Data yang dihapus tidak ada</b>";
	}
	else {
		// Hapus data  
		$mySql = "DELETE FROM penggajian WHERE id_slip='".$_GET['Kode']."'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Eror hapus data".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?page=Penggajian-Data'>";
		}
		}
	}

?>