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
    if ($_POST["txtMode"] == "Edit") {
        $pesan ='';
        $q= "UPDATE `gallery` SET `location`='".$_POST['location']."',`title`='".$_POST['title']."',`caption`='".$_POST['caption']."' WHERE no='".$_POST['no']."'";
        if (!mysql_query($q, $dbLink))
            $pesan = 'Error.';
        else $pesan = 'Success.';
    }
    if ($_GET["txtMode"] == "Delete") {
        $pesan ='';
        $q= "DELETE FROM `gallery` WHERE md5(no)='".$_GET["id"]."'";
        if (!mysql_query($q, $dbLink))
            $pesan = 'Error.';
        else $pesan = 'Success.';
    }
    if (strtoupper(substr($pesan, 0, 5)) == "GAGAL") {
        global $mailSupport;
        $pesan.="Warning!!, please text to " . $mailSupport . " for support this error!.";
    }
    header("Location:index.php?page=view/upload_detail&pesan=" . $pesan);
    exit;
}
?>
<script TYPE="text/javascript">
    function validateForm() {
        let x = document.forms["myForm"]["title"].value;
        if (x == "") {
            alert("Name must be filled out");
            return false;
        }
        let y = document.forms["myForm"]["location"].value;
        if (y == "") {
            alert("Location must be filled out");
            return false;
        }
        let z = document.forms["myForm"]["caption"].value;
        if (z == "") {
            alert("Address must be filled out");
            return false;
        }
    }
    function editmodal($param) {
        $("#no").val($param);
        $("#title").val($("#title_"+$param).val());
        $("#location").val($("#wil_"+$param).val());
        $("#caption").val($("#cap_"+$param).val());
        $("#myModal").modal('show');

    }
</script>
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
			</div>
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
			</div>
		</div>
	</section>
    <section class="col-lg-12 connectedSortable">
        <div class="box box-primary">
            <?php
            $q = "SELECT * FROM `gallery` WHERE 1";
            //Paging
            $rs = new MySQLPagedResultSet($q, 50, $dbLink);
            ?>
            <div class="box-header">
                <i class="ion ion-clipboard"></i>
                <ul class="pagination pagination-sm inline"><?php 
                echo $rs->getPageNav($_SERVER['QUERY_STRING']) ?></ul>
            </div>
                <div class="box-body" style="width: 100%;overflow-x: scroll;">
                    <table class="table table-bordered table-striped table-hover" >
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th style="width: 20%">Nama</th>
                                <th style="width: 10%">Wilayah</th>
                                <th style="width: 25%">Alamat</th>
                                <th style="width: 20%">img</th>
                                <th style="width: 12%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowCounter=1;
                            while ($query_data = $rs->fetchArray()) {
                                echo "<tr>";
                                echo "<td>" . $query_data[0] . "</td>";
                                echo "<td><input type='hidden' id='title_" . $query_data[0] . "' value='" . $query_data[2] . "'>" . $query_data[2] . "</td>";
                                echo "<td><input type='hidden' id='wil_" . $query_data[0] . "' value='" . $query_data[1] . "'>" . $query_data[1] . "</td>";
                                echo "<td><input type='hidden' id='cap_" . $query_data[0] . "' value='" . $query_data[3] . "'>" . $query_data[3] . "</td>";
                                if (file_exists('uploads/'.$query_data[4])) {
                                    echo "<td><center><img src='uploads/".$query_data[4]."' class='img-fluid' width='120'height='100' ><br>".$query_data[4]."</center></td>";
                                }else{
                                    echo "<td><center><img src='uploads/ntf.jpg' class='img-fluid' width='120'height='100'><br>".$query_data[4]." </center></td>";
                                }
                                
                                
                                if ($hakUser == 90) {
                                    echo '<td><div class="col-lg-12"><center><button type="button" class="btn btn-primary " onclick="editmodal('.$query_data[0].')"><i class="fa fa-pencil" ></i> Edit</button><br><br>';
                                    echo '<button type="button" class="btn btn-primary" onclick=\'if(confirm("Apakah anda yakin akan menghapus data ' . $query_data[2] . ' ?")){location.href="index2.php?page=' . $curPage . '&txtMode=Delete&id=' . md5($query_data[0]) . '"}\' style="cursor:pointer;"><i class="fa fa-trash" ></i> Delete</button></center></div></td>';
                                    
                                } else {
                                    echo("<td>&nbsp;</td>");
                                }
                                echo("</tr>");
                                $rowCounter++;
                            }
                            if (!$rs->getNumPages()) {
                                echo("<tr class='even'>");
                                echo ("<td colspan='10' align='center'>Maaf, data tidak ditemukan</td>");
                                echo("</tr>");
                            }
                            ?>
                        </tbody>
                    </table>
                </div> 
            </div>
        </section>
</div>
<form method="post" action="index2.php?page=view/upload_detail" method="post" name="frmSiswaDetail" onsubmit="return validateForm()" autocomplete="off" enctype="multipart/form-data" name="myForm">
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <input type='hidden' name='txtMode' value='Edit'>
        <input type='hidden' name='no' id='no' value=''>
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="title" id="title" class="form-control" required value="<">
                </div>
                <div class="form-group">
                    <label>Wilayah</label>
                    <input type="text" name="location" id="location" class="form-control" required value="">
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="caption" id="caption" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <input type="submit" name="" class="btn btn-primary" value="Save">
            </div>
        </div>
    </div>
</div>
</form>