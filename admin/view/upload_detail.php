<?php
defined( 'validSession' ) or die( 'Restricted access' );

$curPage = "view/upload_detail"; 
$hakUser = getUserPrivilege($curPage);
if (substr($_SERVER['PHP_SELF'], -10, 10) == "index2.php" && $hakUser == 90) {
//Jika Mode Tambah/Add
    if ($_POST["txtMode"] == "Add") {
        $folderUpload = "uploads/";
        $nameimg= array();
        $files = $_FILES;
        $jumlahFile = count($files['listGambar']['name']);

        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaFile = $files['listGambar']['name'][$i];
            $lokasiTmp = $files['listGambar']['tmp_name'][$i];
        }
        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaFile = $files['listGambar']['name'][$i];
            $lokasiTmp = $files['listGambar']['tmp_name'][$i];

    # kita tambahkan uniqid() agar nama gambar bersifat unik
            $lokasiBaru = "{$folderUpload}/{$namaFile}";
            if(move_uploaded_file($lokasiTmp, $lokasiBaru)){
            	$pesan = "file moved successfully";
            }
            else{
            	$pesan = " STILL DID NOT MOVE";
            }
            if ($namaFile != '') {
                array_push($nameimg,$namaFile);
            }
        }
    }
    if (strtoupper(substr($pesan, 0, 5)) == "GAGAL") {
        global $mailSupport;
        $pesan.="Warning!!, please text to " . $mailSupport . " for support this error!.";
    }
    header("Location:index.php?page=view/upload_detail&pesan=" . $pesan);
    exit;
}
?>
<section class="content-header">
  <h1>
    Upload Data & Images
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Input</a></li>
    <li class="active">Upload</li>
  </ol>
</section>
<br>
<div class="box-body">
	<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header">
				<i class="fa fa-paper-plane"></i><br><br>
				<label for="exampleInputFile">Import Data</label>
				<div class="modal-body">
					<form method="post" enctype="multipart/form-data" action="uploaddata.php">
						<input type="file" name="filepegawai" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required class="btn btn-default"> 
						<input type="hidden" name="prev_url" id="prev_url" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
				</div>
				<div class="modal-footer">
					<input type="submit" name="upload" class="btn btn-primary" value="Import" >
				</div></form>
			</div><br><br><br><br><br><br><br><br>
		</div>
	</section>
	<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header">
				<i class="fa fa-upload"></i><br><br>
				<label for="exampleInputFile">File Desain</label>
				<div class="modal-body">
					<form action="index2.php?page=view/upload_detail" method="post" name="frmSiswaDetail" onSubmit="return validasiForm(this);" autocomplete="off" enctype="multipart/form-data"> 
						<input type='hidden' name='txtMode' value='Add'>
						<input type="file" name="listGambar[]" class="btn btn-default" accept="image/*" multiple>
				</div>
				<div class="modal-footer">
					<input type="submit" name="upload" class="btn btn-primary" value="Upload" >
				</div></form>
			</div><br><br><br><br><br><br><br><br>
		</div>
	</section>
</div>
