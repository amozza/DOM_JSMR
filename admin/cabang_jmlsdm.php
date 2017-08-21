<?php
include('akses.php'); //untuk memastikan dia sudah login
include ('connect.php'); //connect ke database

  if(isset($_GET['tahun'])){
    $nilaiTahun = $_GET['tahun'];
  }else $nilaiTahun = '0';

  $getidcabang = $_GET['id_cabang'];
  $cabang =  mysqli_query($connect,"SELECT * FROM cabang WHERE id_cabang = '$getidcabang'");
  $data_cabang = mysqli_fetch_array($cabang);
  $iduser = $_SESSION['id_user'];

  //ambil informasi jenis sub gardu
  $gardu = mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM jenis_subgardu"));

  $idgerbang= mysqli_fetch_array(mysqli_query($connect,"SELECT id_gerbang FROM gerbang"));
	
?>
<!DOCTYPE html>
<html lang="en">
<!-- head -->
<?php include 'templates/head.php' ?>
<!--/head-->


  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="home.php" class="site_title"><i class="fa fa-group"></i> <span>Dashboard DOM</span></a>
            </div>

            <div class="clearfix"></div>

           <!-- menu profile quick info -->
           <?php include'templates/headmenu.php' ?>
            <!-- /menu profile quick info -->


            <br />

             <!-- sidebar menu -->
            <?php include 'templates/sidebarmenu.php' ?>
            <!-- /sidebar menu -->


            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

          <!-- top navigation -->
        <?php include 'topnavigation.php' ?>
        <!-- /top navigation -->


        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Jumlah SDM Cabang <?php echo $data_cabang['nama_cabang']?></h3>
              </div>


            </div>

            <div class="clearfix"></div>

            <div class="">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-table"></i> Table <small></small></h2>

                    <div class="clearfix"></div>
                  </div>
				  <form action="dropdownproses.php" method="POST">
                  <div class='col-sm-2'>                    
                    <div class="form-group">
                        <div class='input-group date' id='myDatepickerFilter'>
                            <input type='text' class="form-control" name= "tahun" <?php if(isset($_GET['tahun'])){ ?> value="<?php echo $nilaiTahun ;?>" <?php } ?>/>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
					<input type='hidden' value=<?php echo $getidcabang; ?> name ="id_cabang">
                  </div>
                  <button type="submit" class="btn btn-primary" name="dropdownTahunSDM1">View</button>
				  <button type="submit" class="btn btn-danger" name="clearTahunSDM1">Clear</button>
                  </form>
                  <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-5 form-group pull-right top_search" style="margin-top:10px;">
                    </div>
                   </div>
                  <div class="x_content">
                      <table id="datatable-keytable"  class="table table-striped table-bordered " class="centered">
                            <thead >
                              <tr >
                                <th rowspan="2">No</th>
                                <th rowspan="2">Gerbang</th>
								<th rowspan="2">Tahun</th>
                                <th rowspan="2">Kepala Gerbang Tol</th>
                                <th rowspan="2">KSPT</th>
                                <th colspan="5">Pengumpul Tol</th>
                                <th rowspan="2">TUGT</th>
                                <th rowspan="2">Aksi</th>
                              </tr>
                              <tr>
                                <th colspan="1">Karyawan Jasamarga</th>
								<th colspan="1">Karyawan JLJ</th>
                                <th rowspan="1">Karyawan JLO</th>
                                <th colspan="1">Sakit Permanen</th>
								<th colspan="1">Total</th>
                              </tr>
                            </thead>
                            <tbody>

                              <?php
							  if($nilaiTahun >0){
                                $jumlah_sdm = mysqli_query($connect, "SELECT * FROM pengumpul_tol join jenis_karyawan join gerbang on gerbang.id_gerbang=pengumpul_tol.id_gerbang WHERE pengumpul_tol.tahun='$nilaiTahun' AND pengumpul_tol.id_cabang = '$getidcabang' group by pengumpul_tol.tahun, pengumpul_tol.id_gerbang");
								  
							  }else{
                                $jumlah_sdm = mysqli_query($connect, "SELECT * FROM pengumpul_tol join jenis_karyawan join gerbang on gerbang.id_gerbang=pengumpul_tol.id_gerbang WHERE pengumpul_tol.id_cabang = '$getidcabang' group by pengumpul_tol.tahun, pengumpul_tol.id_gerbang");								  
							  }
                                $nomor = 1;
                                while($data_jumlahsdm = mysqli_fetch_array($jumlah_sdm)){
                                  $idgerbanglist = $data_jumlahsdm['id_gerbang'];
                                  $total = 0;
                                  $data_gerbang = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM gerbang WHERE id_gerbang = '$idgerbanglist'"));
                                  $data_kepalagerbangtol = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '5'"));
                                  $data_kspt = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '6'"));
                                  $data_kryjasamarga = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '1'"));
                                  $data_kryjlj = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '2'"));
                                  $data_kryjlo= mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '3'"));
                                  $data_sakitpermanen = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '4'"));
                                  $data_tugt = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM pengumpul_tol, jenis_karyawan WHERE pengumpul_tol.id_gerbang = '$idgerbanglist' AND pengumpul_tol.id_karyawan = '7'"));
                                  ?>
                              <tr>
								<td><?php echo $nomor; $nomor++ ?></td>
                                <td><?php echo $data_gerbang['nama_gerbang']?></td>
								<td><?php echo $data_jumlahsdm['tahun']?></td>
                                <td><?php echo $data_kepalagerbangtol['jumlah']?></td>
                                <td><?php echo $data_kspt['jumlah']?></td>
                                <td><?php echo $data_kryjasamarga['jumlah']?></td>
                                <td><?php echo $data_kryjlj['jumlah']?></td>
                                <td><?php echo $data_kryjlo['jumlah']?></td>
                                <td><?php echo $data_sakitpermanen['jumlah']?></td>
                                <td><?php echo $total+=($data_kryjasamarga['jumlah']+$data_kryjlj['jumlah']+ $data_kryjlo['jumlah']+$data_sakitpermanen['jumlah']);?></td>
                                <td><?php echo $data_tugt['jumlah']?></td>
								<td>
								<button type="button" class="btn btn-round btn-info" class="btn btn-primary" data-toggle="modal" data-target=".bs-edit-modal" 
								 data-id-gerbang ="<?php echo $data_gerbang['id_gerbang']?>"
								 data-tahun ="<?php echo $data_jumlahsdm['tahun']?>"
								 data-data1="<?php echo $data_kepalagerbangtol['jumlah']?>"
                                 data-data2="<?php echo $data_kspt['jumlah']?>"
                                 data-data3="<?php echo $data_kryjasamarga['jumlah']?>"
                                 data-data4="<?php echo $data_kryjlj['jumlah']?>"
                                 data-data5="<?php echo $data_kryjlo['jumlah']?>"
								 data-data6="<?php echo $data_sakitpermanen['jumlah']?>"															 
								 data-data7="<?php echo $data_tugt['jumlah']?>">Edit</button>
								 <button type="button" class="btn btn-round btn-danger" class="btn btn-primary" data-toggle="modal" data-target=".bs-delete-modal" 
								 data-id-gerbang ="<?php echo $data_gerbang['id_gerbang']?>"
								 data-tahun ="<?php echo $data_jumlahsdm['tahun']?>">Delete</button>
								</td>
                              </tr>
                              <?php }?>
                            </tbody>
                          </table>
                  </div>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <!-- /page content -->

		<div class="x_content">
		
<!-- Modal Delete Jml  SDM -->
	<div class="modal fade bs-delete-modal" id="modal_deletejmlsdm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Delete Rencana</h4>
			</div>
			<div class="modal-body">
			<form action="editdelete.php" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" ">
			 <div class="alert alert-danger" role="alert">
			   <h1 class="glyphicon glyphicon-alert" aria-hidden="true"></h1>
					<h4> Anda yakin untuk menghapus data ini? </h4>
			  </div>
			  <h2 style="color:red;"></h2>
			  <form action="editdelete.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
				  <input name="idgerbang" type="text" id="id" value="" hidden>						
				  <input name="tahun" type="text" id="tahun" value="" hidden>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			  <button type="submit" class="btn btn-danger" name ="deletejs" >Delete</button>
			</div>
			</form>
		  </div>
		</div>
	  </div>
	  
<!-- Modal Edit Jml SDM -->
 <div class="modal fade bs-edit-modal" id="modal_editjmlsdm" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-lg">
		  <div class="modal-content">

			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
			  </button>
			  <h4 class="modal-title" id="myModalLabel">Edit Rencana</h4>
			</div>
			<div class="modal-body">
			<form action="editdelete.php" method="POST" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
				  <input name="idgerbang" type="text" id="id" value="" hidden>					  
				  <input name="tahun" type="text" id="tahun" value="" hidden>
				<div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kpl_gerbangtol">Kepala Gerbang Tol</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "kpl_gerbangtol" type="number" min="0" id="kpl_gerbangtol" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kspt">KSPT</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "kspt" type="number" min="0" id="kspt" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kry_jasamarga">Karyawan Jasamarga</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "kry_jasamarga" type="number" min="0" id="kry_jasamarga" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kry_jlj">Karyawan JLJ</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "kry_jlj" type="number" min="0" id="kry_jlj" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kry_jlo">Karyawan JLO</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "kry_jlo" type="number" min="0" id="kry_jlo" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="sakit_permanen">Sakit Permanen</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "sakit_permanen" type="number" min="0" id="sakit_permanen" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tugt">TUGT</label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input value ="" name= "tugt" type="number" min="0" id="tugt" required="required" class="form-control col-md-7 col-xs-12">
              </div>
            </div>
			</div>
			<div class="modal-footer">
			  <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			  <button type="submit" class="btn btn-primary" name ="editjs" >Save changes</button>
			</div>
			</form>
		  </div>
		</div>
	  </div>
		</div>

<style>
.table th {
   vertical-align: middle ; text-align: center ;"
}
.buttonright {
  width:60%;
  display:inline;
  overflow: auto;
  white-space: nowrap;
  margin:0px auto;
}
.buttonrightfloat {
  float:right;
  margin-right: 10px;
}
</style>
        <!-- footer content -->
<?php include 'templates/footer.php' ?>
        <!-- /footer content -->
      </div>
    </div>
<!-- scripts -->
<?php include 'templates/scripts.php' ?>





<!-- /scripts -->
  </body>
</html>
