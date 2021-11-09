<?php
defined( 'validSession' ) or die( 'Restricted access' );
include( './config.php' );
global $dbLink;
$curPage = "view/input_detail"; 
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
        $pesan ='';
        $q= "INSERT INTO `pulau`(`name`, `link`, `img`) VALUES ('".$_POST['name']."','".$_POST['link']."','".$namaFile."')";
        if (!mysql_query($q, $dbLink))
            $pesan = 'Error.';
        else $pesan = 'Success.';

    }
    if (strtoupper(substr($pesan, 0, 5)) == "GAGAL") {
        global $mailSupport;
        $pesan.="Warning!!, please text to " . $mailSupport . " for support this error!.";
    }
    header("Location:index.php?page=view/input_detail&pesan=" . $pesan);
    exit;
}
?>
<script type="text/javascript">
    function validateForm() {
        let x = document.forms["myForm"]["name"].value;
        if (x == "") {
            alert("Name must be filled out");
            return false;
        }
        let x = document.forms["myForm"]["link"].value;
        if (x == "") {
            alert("Link must be filled out");
            return false;
        }
    }
</script>
<section class="content-header">
  <h1>
    Input Data 
    <small></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Input</a></li>
    <li class="active">Input</li>
  </ol>
</section>
<br>
<div class="box-body">
	<section class="col-lg-6 connectedSortable">
		<div class="box box-primary">
			<div class="box-header">
				<i class="fa fa-pencil"></i><br><br>
				<div class="modal-body">
					<form method="post" action="index2.php?page=view/input_detail" method="post" name="frmSiswaDetail" onsubmit="return validateForm()" autocomplete="off" enctype="multipart/form-data" name="myForm">
                        <input type='hidden' name='txtMode' value='Add'>
						<div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Pulau Jawa" required>
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" id="link" class="form-control" placeholder="jawa" required>
                        </div>
                        <div class="form-group">
                            <label>Img</label>
                            <input type="file" name="listGambar[]" class="btn btn-default" accept="image/*" >
                        </div>
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Save" >
				</div></form>
			</div>
		</div>
	</section>
    <section class="col-lg-6">
    <?php 
        if (isset($_GET["pesan"]) != "") {
            if ($_GET["pesan"] =='Error.') {
                echo '<div class="callout callout-danger">';
                echo '<h4><i class="icon fa fa-ban"></i> Alert!</h4>';
            }else{
                echo '<div class="callout callout-success">';
                echo '<h4><i class="icon fa fa-check"></i> Alert!</h4>';
            }
            ?>
                
                <?php

                    if ($_GET["pesan"] != "") {

                        echo $_GET["pesan"];
                    }
                ?>
            </div>
            <?php
        }
    ?>
    </section>
    <section class="col-lg-12 connectedSortable">
        <div class="box box-primary">
            <?php
            $q = "SELECT * FROM `pulau` WHERE 1";
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
                                <th width="3%">No</th>
                                <th style="width: 30%">Pulau</th>
                                <th style="width: 20%">Link</th>
                                <th style="width: 20%">img</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $rowCounter=1;
                            while ($query_data = $rs->fetchArray()) {
                                echo "<tr>";
                                echo "<td>" . $rowCounter . "</td>";
                                echo "<td>" . $query_data[1] . "</td>";
                                echo "<td>" . $query_data[2] . "</td>";
                                echo "<td>" . $query_data[3] . "</td>";
                                
                                if ($hakUser == 90) {
                                    echo "<td><span class='label label-success' style='cursor:pointer;' onclick=location.href='" . $_SERVER['PHP_SELF'] . "?page=view/setting_detail&mode=edit&kode=" . md5($query_data[0]) . "'><i class='fa fa-edit'></i>&nbsp;Ubah</span></td>";
                                    
                                    echo("<td><span class='label label-danger' onclick=\"if(confirm('Apakah anda yakin akan menghapus data Setting " . $query_data[1] . " ?')){location.href='index2.php?page=" . $curPage . "&txtMode=Delete&kodeSetting=" . md5($query_data[0]) . "'}\" style='cursor:pointer;'><i class='fa fa-trash'></i>&nbsp;Hapus</span></td>");
                                    
                                } else {
                                    echo("<td>&nbsp;</td>");
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
