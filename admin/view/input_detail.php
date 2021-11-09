<?php
defined( 'validSession' ) or die( 'Restricted access' );
include( './config.php' );
global $dbLink;
$curPage = "view/input_detail"; 
$hakUser = getUserPrivilege($curPage);
if (substr($_SERVER['PHP_SELF'], -10, 10) == "index2.php" && $hakUser == 90) {
//Jika Mode Tambah/Add
    if ($_POST["txtMode"] == "Add") {
        $pesan ='';
        $q= "INSERT INTO `pulau`(`name`, `link`) VALUES ('".$_POST['name']."','".$_POST['link']."')";
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
				</div>
				<div class="modal-footer">
					<input type="submit" class="btn btn-primary" value="Save" >
				</div></form>
			</div><br><br><br><br><br><br><br><br>
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
</div>
