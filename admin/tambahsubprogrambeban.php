<?php
	include 'connect.php';
	include 'anti_inject.php';

		if(isset($_POST['tambah'])){
			$idcabang = anti_injection($_POST['idcabang']);
		 	$id_pk= anti_injection($_POST['idprogramkerja']);
			$nama_subpk = anti_injection($_POST['subprogramkerja']);


		//cek inputan double di database



		$ceknama_subprogramkerja = mysqli_fetch_array(mysqli_query($connect, "SELECT * FROM sub_program WHERE id_pk = '$id_pk' AND nama_sp ='$nama_subpk' AND jenis ='beban'"));

		$cek = $ceknama_subprogramkerja['id_pk']; //id program kerja checker
		$cek2 = $ceknama_subprogramkerja['nama_sp']; //id subprogram kerja checker

			if($cek2==$nama_subpk && $cek== $id_pk){

?>
				<script>window.alert('Nama Sub Program Kerja Sudah Ada Pada Program Kerja') </script>
				<script>document.location.href="javascript:history.back()";</script>
<?php
            }
            else{

				$insert= mysqli_query($connect,"INSERT INTO sub_program VALUES ('','$nama_subpk','$id_pk','$idcabang','beban')");

					if($insert){
?>
                    <script> window.alert('Data berhasil Ditambah') </script>
                    <script>document.location.href="<?php echo $_SERVER['HTTP_REFERER'];?>";</script>
<?php
					}
                    else{
?>
						<script> window.alert('Data Gagal Ditambahkan') </script>
					 <script>document.location.href="<?php echo $_SERVER['HTTP_REFERER'];?>";</script>
 <?php 		 		}
			}
		}
?>
