	<?php
//Persiapan Import Excel ke Mysql

//panggil Koneksi Database
include( 'config.php' );
global $dbLink;
// Panggil Library Excel Reader
require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require('spreadsheet-reader-master/SpreadsheetReader.php');
//upload data excel kedalam folder uploads
$target_dir = "uploads/".basename($_FILES['filepegawai']['name']);

move_uploaded_file($_FILES['filepegawai']['tmp_name'],$target_dir);

$Reader = new SpreadsheetReader($target_dir);
$berhasil = 0;
foreach ($Reader as $Key => $Row)
{
			// import data excel mulai baris ke-2 (karena ada header pada baris 1)
	if ($Key < 1) continue;		
	if ($Row[0]!= '') {
		$query=mysql_query("INSERT INTO gallery (`location`, `title`, `caption`, `img`)  VALUES ('".$Row[4]."', '".$Row[2]."','".$Row[3]."','".$Row[0].".jpg')");
		$berhasil++;
	}	
	
}
if ($query) {
	echo "Import data berhasil";
}else{
	echo mysql_error();
}

//hapus kembali file .xls yang di upload tadi
unlink($_FILES['filepegawai']['name']);

//alihkan halaman ke index.php
header("location:index.php?page=view/upload_detail&berhasil=$berhasil");
?>