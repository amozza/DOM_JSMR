<?php 
include "connect.php";
include('akses.php'); //untuk memastikan dia sudah login

 if(isset($_GET['tahun'])){
    $nilaiTahun = $_GET['tahun'];
  
  }else $nilaiTahun = '0';
  $iduser = $_SESSION['id_user'];

  $resultjs = $connect-> query("SELECT * FROM cabang");

  //ambil informasi jenis sub gardu
  $gardu = mysqli_fetch_array(mysqli_query($connect,"SELECT * FROM jenis_subgardu"));

  $idgerbang= mysqli_fetch_array(mysqli_query($connect,"SELECT id_gerbang FROM gerbang"));



// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/x-msdownload");
// Mendefinisikan nama file ekspor "hasil-export.xls"
if($nilaiTahun > 0){
	header("Content-Disposition: attachment; filename=Laporan Lalin Jam-jaman Tahun ".$nilaiTahun.".xls");}
else{
	header("Content-Disposition: attachment; filename=Laporan Lalin Jam-jaman.xls");}header("Pragma : no-cache");
header("Expires :0"); $i=0;
?>

 <div align="center"> <p>Lalu-lintas Jam-jaman</p></div>

                       <table border="1" id="datatable-keytable"  class="table table-striped table-bordered " class="centered">
                            <thead >

                              <tr >
                                <th rowspan="3">No</th>
                                <th rowspan="3">Cabang</th>
								<th rowspan="3">Tahun</th>
                                <th colspan="7">Lalu Lintas Transaksi Tinggi</th>
                              </tr>
                              <tr>
                                <th colspan="3">Reguler</th>
								<th colspan="3">GTO</th>
                                <th rowspan="2">E-Pass</th>
                              </tr>
                              <tr>

                                <th rowspan="1">Gardu Keluar</th>
                                <th rowspan="1">Gardu Masuk</th>
                                <th colspan="1">Gardu Terbuka</th>
                                <th rowspan="1">Gardu Keluar</th>
                                <th rowspan="1">Gardu Masuk</th>
                                <th colspan="1">Gardu Terbuka</th>
                              </tr>

                            </thead>
                            <tbody>
                              <?php
                              if($nilaiTahun > 0){
								$lalin_transaksitinggi = mysqli_query($connect, "SELECT * FROM transaksi_tinggi join cabang on cabang.id_cabang=transaksi_tinggi.id_cabang WHERE transaksi_tinggi.tahun='$nilaiTahun' group by transaksi_tinggi.tahun, transaksi_tinggi.id_cabang");
							  }else{
								$lalin_transaksitinggi = mysqli_query($connect, "SELECT * FROM transaksi_tinggi join cabang on cabang.id_cabang=transaksi_tinggi.id_cabang group by transaksi_tinggi.tahun, transaksi_tinggi.id_cabang");
							  }
                                $nomor = 1; $total1 =0; $total2 =0; $total3 =0; $total4 =0; $total5 =0; $total6 =0; $total7 =0;
                                while($data_lalintransaksi = mysqli_fetch_array($lalin_transaksitinggi)){
                                   $idcabang = $data_lalintransaksi['id_cabang'];
								   $tahun = $data_lalintransaksi['tahun'];
                                   
                                  //fetching data untuk tabel bagian lalin transaksi tinggi
                                  $data_gerbang_terbuka_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '1'");
                                  $total_gerbang_terbuka_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_terbuka_lalin)) {
								  $total_gerbang_terbuka_lalin += $num['nilai'];}
                                  $data_gerbang_masuk_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '2'");
                                  $total_gerbang_masuk_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_masuk_lalin)) {
								  $total_gerbang_masuk_lalin += $num['nilai'];}
                                  $data_gerbang_keluar_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '3'");
                                  $total_gerbang_keluar_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_keluar_lalin)) {
								  $total_gerbang_keluar_lalin += $num['nilai'];}
                                  $data_gerbang_terbuka_gto_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '4'");
                                  $total_gerbang_terbuka_gto_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_terbuka_gto_lalin)) {
								  $total_gerbang_terbuka_gto_lalin += $num['nilai'];}
                                  $data_gerbang_masuk_gto_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '5'");
                                  $total_gerbang_masuk_gto_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_masuk_gto_lalin)) {
								  $total_gerbang_masuk_gto_lalin += $num['nilai'];}
                                  $data_gerbang_keluar_gto_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '6'");
                                  $total_gerbang_keluar_gto_lalin = 0;
								  while ($num = mysqli_fetch_array($data_gerbang_keluar_gto_lalin)) {
								  $total_gerbang_keluar_gto_lalin += $num['nilai'];}
                                  $data_epass_lalin = mysqli_query($connect, "SELECT * FROM transaksi_tinggi WHERE tahun='$tahun' AND id_cabang = '$idcabang' AND id_subgardu = '7'");
                                  $total_epass_lalin = 0;
								  while ($num = mysqli_fetch_array($data_epass_lalin)) {
								  $total_epass_lalin += $num['nilai'];}

                            ?>
                              <tr>
                                <td><?php echo $nomor; $nomor++?></td>
                                <td><?php echo $data_lalintransaksi['nama_cabang']?></td>
								<td><?php echo $data_lalintransaksi['tahun']?></td>
								<td><?php $total1+=$total_gerbang_keluar_lalin;
									echo $total_gerbang_keluar_lalin?></td>
								<td><?php $total2+=$total_gerbang_masuk_lalin;
									echo $total_gerbang_masuk_lalin?></td>
								<td><?php $total3+=$total_gerbang_terbuka_lalin;
									echo $total_gerbang_terbuka_lalin?></td>
								<td><?php $total4+=$total_gerbang_keluar_gto_lalin;
									echo $total_gerbang_keluar_gto_lalin?></td>
								<td><?php $total5+=$total_gerbang_masuk_gto_lalin;
									echo $total_gerbang_masuk_gto_lalin?></td>
							    <td><?php $total6+=$total_gerbang_terbuka_gto_lalin;
									echo $total_gerbang_terbuka_gto_lalin?></td>
								<td><?php $total7+=$total_epass_lalin;
									echo $total_epass_lalin?></td>
                              </tr>
                              <?php }?>
                              <tr>
                                <td colspan='3'>Total</td>
                                <td><?php echo $total1?></td>
                                <td><?php echo $total2?></td>
                                <td><?php echo $total3?></td>
                                <td><?php echo $total4?></td>
                                <td><?php echo $total5?></td>
								<td><?php echo $total6?></td>
                                <td><?php echo $total7?></td>
                              </tr>
                            </tbody>
                       </table>

            

<div align="right">
 <p>Jakarta, </p>
 <br>
 
 <p><u>.........</u><br>
 NPP. </p>
<div>



 