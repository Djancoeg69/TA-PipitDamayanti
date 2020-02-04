<?php
if(isset($_SESSION['SES_ADMIN'])){
?>
	<div id="cssmenu">
    <ul>
    <li><a href='?page' title='Halaman Utama'>Home</a></li>
	<li><a href='?page=User-Data' title='Pengguna Data' target="_self">Data User</a></li>
	<li><a href='?page=Bagian-Data' title='Bagian Data' target="_self">Data Bagian </a></li>
	<li><a href='?page=Karyawan-Data' title='Karyawan Data' target="_self">Data Karyawan </a></li>
	<li><a href='?page=Lembur-Data' title='Lembur Data' target="_self">Data Lembur </a></li>
    <li><a href='?page=Potongan-Data' title='Potongan Data' target="_self">Data Potongan </a></li>
	<li><a href='?page=Penggajian-Data' title='Penggajian Data' target="_self">Data Penggajian</a></li>
	<li><a href='?page=Laporan' title='Laporan'>Laporan</a></li>
	<li><a href='?page=Logout' title='Logout (Exit)' target="_self">Logout</a></li>
	</ul>

</div>
<?php
}

else { ?>
	<ul>
	<li><a href='?page=Login' title='Login System'>Login</a></li>	
	</ul>
<?php 
}
?>