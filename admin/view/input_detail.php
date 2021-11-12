<?php
defined( 'validSession' ) or die( 'Restricted access' );
include( './config.php' );
global $dbLink;
$curPage = "view/input_detail"; 
$hakUser = getUserPrivilege($curPage);
if (substr($_SERVER['PHP_SELF'], -10, 10) == "index2.php" && $hakUser == 90) {
//Jika Mode Tambah/Add
    
        $folderUpload = "uploads/";
        $nameimg= array();
        $files = $_FILES;
        $jumlahFile = count($files['listGambar']['name']);
    if ($files['listGambar']['name'][0] != '') {
        
        for ($i = 0; $i < $jumlahFile; $i++) {
            $namaFile = $files['listGambar']['name'][$i];
            $lokasiTmp = $files['listGambar']['tmp_name'][$i];

        # kita tambahkan uniqid() agar nama gambar bersifat unik
            $lokasiBaru = "{$folderUpload}/{$namaFile}";
            if(move_uploaded_file($lokasiTmp, $lokasiBaru)){
                $pesan = $jumlahFile."file moved successfully";
            }
            else{
                $pesan = $files['listGambar']['name'][0]." STILL DID NOT MOVE";
            }
            if ($namaFile != '') {
                array_push($nameimg,$namaFile);
            }
        }
    }
        
    if ($_POST["txtMode"] == "Add") {
        $pesan ='';
        $q= "INSERT INTO `pulau`(`name`, `link`, `img`) VALUES ('".$_POST['name']."','".$_POST['link']."','".$namaFile."')";
        if (!mysql_query($q, $dbLink))
            $pesan = 'Error.';
        else $pesan = 'Success.';

    }
    if ($_POST["txtMode"] == "Edit") {
        $pesan ='';
        if ($namaFile =="") {
            $q= "UPDATE `pulau` SET `name`='".$_POST['name']."',`link`='".$_POST['link']."' WHERE id='".$_POST['id']."'";
        }else{
            $q= "UPDATE `pulau` SET `name`='".$_POST['name']."',`link`='".$_POST['link']."',`img`='".$namaFile."' WHERE id='".$_POST['id']."'";
        }
        if (!mysql_query($q, $dbLink))
            $pesan = 'Error.';
        else $pesan = 'Success.';
    }
    if ($_GET["txtMode"] == "Delete") {
        $pesan ='';
        $q= "DELETE FROM `pulau` WHERE md5(id)='".$_GET["id"]."'";
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
        let y = document.forms["myForm"]["link"].value;
        if (y == "") {
            alert("Link must be filled out");
            return false;
        }
    }
</script>
<section class="content-header">
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
                        <?php
                        if (isset($_GET["mode"]) == "Edit") {
                            $kode = secureParam($_GET["kode"], $dbLink);
                            $q = "SELECT * FROM pulau WHERE md5(id)='".$kode."'";

                            $rsTemp = mysql_query($q, $dbLink);

                            if ($dataP = mysql_fetch_array($rsTemp)) {
                                echo "<input type='hidden' name='txtMode' value='Edit'>";
                            }
                        }else{
                            echo "<input type='hidden' name='txtMode' value='Add'>";
                        }

                        ?>
                        <input type="hidden" name="id" id="id" class="form-control" value="<?php if(isset($_GET["mode"]) == "Edit") { echo$dataP['id'];}?>" >
						<div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Pulau Jawa" required value="<?php if(isset($_GET["mode"]) == "Edit") { echo$dataP['name'];}?>">
                        </div>
                        <div class="form-group">
                            <label>Link</label>
                            <input type="text" name="link" id="link" class="form-control" placeholder="jawa" required value="<?php if(isset($_GET["mode"]) == "Edit") { echo$dataP['link'];}?>">
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
                echo '<div class="callout callout-info">';
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
                                <th width="5%">No</th>
                                <th style="width: 30%">Pulau</th>
                                <th style="width: 20%">Link</th>
                                <th style="width: 20%">img</th>
                                <th style="width: 10%">Action</th>
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
                                echo "<td><center><img src='uploads/".$query_data[3]."' class='img-fluid' width='120'height='100'></center></td>";
                                
                                if ($hakUser == 90) {
                                    echo '<td><div class="col-lg-12"><center><button type="button" class="btn btn-primary " onclick=location.href="' . $_SERVER['PHP_SELF'] . '?page=view/input_detail&mode=Edit&kode=' . md5($query_data[0]) . '"><i class="fa fa-pencil" ></i> Edit</button><br><br>';
                                    echo '<button type="button" class="btn btn-primary" onclick=\'if(confirm("Apakah anda yakin akan menghapus data Setting ' . $query_data[1] . ' ?")){location.href="index2.php?page=' . $curPage . '&txtMode=Delete&id=' . md5($query_data[0]) . '"}\' style="cursor:pointer;"><i class="fa fa-trash" ></i> Delete</button></center></div></td>';
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
