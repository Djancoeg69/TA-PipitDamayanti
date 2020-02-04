<?php
# Konek ke Web Server Lokal
$myHost	= "localhost";
$myUser	= "root";
$myPass	= "";
$myDbs	= "gaji_karyawandb";

# Konek ke Web Server Lokal
$koneksidb	= mysql_connect($myHost, $myUser, $myPass);
if (! $koneksidb) {
  echo "Failed Connection !";
}

# Memilih database pd MySQL Server
mysql_select_db($myDbs, $koneksidb) or die ("Database not Found !");
?>