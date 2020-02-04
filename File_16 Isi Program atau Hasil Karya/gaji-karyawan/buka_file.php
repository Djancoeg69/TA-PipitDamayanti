<?php
if($_GET) {
	switch ($_GET['page']){				
		case '' :				
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
		case 'Halaman-Utama' :				
			if(!file_exists ("main.php")) die ("Sorry Empty Page!"); 
			include "main.php";						
		break;
		case 'Login' :				
			if(!file_exists ("login.php")) die ("Sorry Empty Page!"); 
			include "login.php";						
		break;
		case 'Login-Validasi' :				
			if(!file_exists ("login_validasi.php")) die ("Sorry Empty Page!"); 
			include "login_validasi.php";						
		break;
		case 'Logout' :				
			if(!file_exists ("login_out.php")) die ("Sorry Empty Page!"); 
			include "login_out.php";						
		break;

		# MASTER DATA
		case 'Master-Data' :				
			if(!file_exists ("menu_master.php")) die ("Sorry Empty Page!"); 
			include "menu_master.php";	 break;		
			
		# USER LOGIN
		case 'User-Data' :				
			if(!file_exists ("user_data.php")) die ("Sorry Empty Page!"); 
			include "user_data.php";	 break;		
		case 'User-Add' :				
			if(!file_exists ("user_add.php")) die ("Sorry Empty Page!"); 
			include "user_add.php";	 break;		
		case 'User-Edit' :				
			if(!file_exists ("user_edit.php")) die ("Sorry Empty Page!"); 
			include "user_edit.php"; break;	
		case 'User-Delete' :				
			if(!file_exists ("user_delete.php")) die ("Sorry Empty Page!"); 
			include "user_delete.php"; break;	
			
		# BAGIAN
		case 'Bagian-Data' :				
			if(!file_exists ("bagian_data.php")) die ("Sorry Empty Page!"); 
			include "bagian_data.php"; break;		
		case 'Bagian-Add' :				
			if(!file_exists ("bagian_add.php")) die ("Sorry Empty Page!"); 
			include "bagian_add.php"; break;		
		case 'Bagian-Edit' :				
			if(!file_exists ("bagian_edit.php")) die ("Sorry Empty Page!"); 
			include "bagian_edit.php"; break;	
		case 'Bagian-Delete' :				
			if(!file_exists ("bagian_delete.php")) die ("Sorry Empty Page!"); 
			include "bagian_delete.php"; break;	

		# KARYAWAN
		case 'Karyawan-Data' :				
			if(!file_exists ("karyawan_data.php")) die ("Sorry Empty Page!"); 
			include "karyawan_data.php"; break;		
		case 'Karyawan-Add' :				
			if(!file_exists ("karyawan_add.php")) die ("Sorry Empty Page!"); 
			include "karyawan_add.php"; break;		
		case 'Karyawan-Edit' :				
			if(!file_exists ("karyawan_edit.php")) die ("Sorry Empty Page!"); 
			include "karyawan_edit.php"; break;	
		case 'Karyawan-Delete' :				
			if(!file_exists ("karyawan_delete.php")) die ("Sorry Empty Page!"); 
			include "karyawan_delete.php"; break;
			
			# POTONGAN
		case 'Potongan-Data' :				
			if(!file_exists ("potongan_data.php")) die ("Sorry Empty Page!"); 
			include "potongan_data.php"; break;		
		case 'Potongan-Add' :				
			if(!file_exists ("potongan_add.php")) die ("Sorry Empty Page!"); 
			include "potongan_add.php"; break;		
		case 'Potongan-Edit' :				
			if(!file_exists ("potongan_edit.php")) die ("Sorry Empty Page!"); 
			include "potongan_edit.php"; break;	
		case 'Potongan-Delete' :				
			if(!file_exists ("potongan_delete.php")) die ("Sorry Empty Page!"); 
			include "potongan_delete.php"; break;
			

		# PENGGAJIAN
		case 'Penggajian-Data' :				
			if(!file_exists ("penggajian_data.php")) die ("Sorry Empty Page!"); 
			include "penggajian_data.php"; break;		
		case 'Penggajian-Add' :				
			if(!file_exists ("penggajian_add.php")) die ("Sorry Empty Page!"); 
			include "penggajian_add.php"; break;		
		case 'Penggajian-Edit' :				
			if(!file_exists ("penggajian_edit.php")) die ("Sorry Empty Page!"); 
			include "penggajian_edit.php"; break;	
		case 'Penggajian-Delete' :				
			if(!file_exists ("penggajian_delete.php")) die ("Sorry Empty Page!"); 
			include "penggajian_delete.php"; break;
			
		# LEMBUR
		case 'Lembur-Data' :				
			if(!file_exists ("lembur_data.php")) die ("Sorry Empty Page!"); 
			include "lembur_data.php"; break;		
		case 'Lembur-Add' :				
			if(!file_exists ("lembur_add.php")) die ("Sorry Empty Page!"); 
			include "lembur_add.php"; break;		
		case 'Lembur-Edit' :				
			if(!file_exists ("lembur_edit.php")) die ("Sorry Empty Page!"); 
			include "lembur_edit.php"; break;	
		case 'Lembur-Delete' :				
			if(!file_exists ("lembur_delete.php")) die ("Sorry Empty Page!"); 
			include "lembur_delete.php"; break;

			
		# MASTER DATA
		case 'Laporan' :	
			if(!file_exists ("menu_laporan.php")) die ("Sorry Empty Page!"); 
				include "menu_laporan.php";	break;						
		
			# INFORMASI DAN LAPORAN
case 'Laporan-User' :				
	if(!file_exists ("laporan_user.php")) die ("Sorry Empty Page!"); 
	include "laporan_user.php"; break;		
case 'Laporan-Bagian' :				
	if(!file_exists ("laporan_bagian.php")) die ("Sorry Empty Page!"); 
	include "laporan_bagian.php"; break;	
case 'Laporan-Karyawan' :				
	if(!file_exists ("laporan_karyawan.php")) die ("Sorry Empty Page!"); 
	include "laporan_karyawan.php"; break;
case 'Laporan-Potongan' :				
	if(!file_exists ("laporan_potongan.php")) die ("Sorry Empty Page!"); 
	include "laporan_potongan.php"; break;
case 'Laporan-Penggajian' :				
	if(!file_exists ("laporan_penggajian.php")) die ("Sorry Empty Page!"); 
	include "laporan_penggajian.php"; break;
case 'Laporan-Lembur' :				
	if(!file_exists ("laporan_lembur.php")) die ("Sorry Empty Page!"); 
	include "laporan_lembur.php"; break;
	
		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!"); 
			include "main.php";						
		break;
	}
}
else {
	if(!file_exists ("main.php")) die ("Empty Main Page!"); 
		include "main.php";	
}
?>