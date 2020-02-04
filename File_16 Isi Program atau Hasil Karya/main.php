<?php
if(isset($_SESSION['SES_ADMIN'])) {
	echo "<h2>Selamat Datang</h2>
          <p><b>$_SESSION[SES_USER]</b>, Anda berada di halaman Admin.
          <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
          <p align=right>Login : Hari ini, ";
  echo date('d-F-Y'); 
  echo " | "; 
  echo date("H:i:s");
  echo " WIB</p>";
  }

else {
	echo "<h2 style='margin:-5px 0px 5px 0px; padding:0px;'>Selamat datang ........!</h2></p>";
	echo "<b>Anda belum login, silahkan <a href='?page=Login' alt='Login'>login </a>untuk mengakses sitem ini ";	
}
?>