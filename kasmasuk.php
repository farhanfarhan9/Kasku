<?php 
	require_once 'core/init.php';
	require_once 'view/header.php';

	if (isset($_SESSION['nama']) == 0) {
    header('location:login.php');
	}

	$sql = "SELECT tb_pengguna.nama, tb_kasmasuk.id, tb_kasmasuk.waktu, tb_kasmasuk.jumlah FROM tb_kasmasuk INNER JOIN tb_pengguna ON tb_kasmasuk.pengguna_id = tb_pengguna.id";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();

	$sql2 = "SELECT SUM(jumlah) AS total FROM tb_kasmasuk"; 
	$stmt2 = $koneksi->prepare($sql2);
	$stmt2->execute();

 ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Kas Masuk</h1>
  </div>
  	<div class="row">
        <div class="col-md-12 text-right">
        	<?php  if ($_SESSION['status'] === 'admin') { ?>
        	<a href="kasmasuk_tambah.php" class="btn btn-primary">Tambah Kas Masuk</a>
        <?php }elseif (($_SESSION['status']) === 'bendahara') {?>
			<a href="kasmasuk_tambah.php" class="btn btn-primary">Tambah Kas Masuk</a>
        <?php } ?>
        </div>
    </div><br>
  	<div class="table-responsive table-striped">
	  <table class="table">
	  	<thead>
		    <tr>
		    	<th>No</th>
		    	<th>Nama Pengguna</th>
		    	<th>Waktu</th>
		    	<th>Jumlah</th>
		    	<?php  if ($_SESSION['status'] === 'admin') { ?>
		    	<th class="text-center">Aksi</th>
		    	<?php }elseif (($_SESSION['status']) === 'bendahara') {?>
		    		<th class="text-center">Aksi</th>
		    	<?php } ?>
		    </tr>
	    </thead>
	    <?php 
	    		$no = 1;
	    		while ($row = $stmt->fetch() ) {
	    			
	    	 ?>
	    <tr>
	    	<td><?= $no; ?></td>
	    	<td><?= $row['nama'] ?></td>
	    	<td><?= $row['waktu'] ?></td>
	    	<td><?= $row['jumlah'] ?></td>
	    	<?php  if ($_SESSION['status'] === 'admin') { ?>
	    	<td class="text-center">
	    		<a href="kasmasuk_edit.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="far fa-edit"></i> Edit</a>
	    		<a href="kasmasuk_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</a>
	    	</td>
	    	<?php }elseif (($_SESSION['status']) === 'bendahara') {?>
    		<td class="text-center">
	    		<a href="kasmasuk_edit.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm"><i class="far fa-edit"></i> Edit</a>
	    		<a href="kasmasuk_hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Hapus</a>
	    	</td>
	    	<?php } ?>
	    </tr>
	    <?php 
	    		$no++;
	    		}
	    	?>
	  </table>
	  <div class="alert alert-light text-center text-dark" role="alert">
 		 <?php 
			$row2 = $stmt2->fetch();
		 ?>
     	<p>Total Rp.<?= $row2['total'] ?>,-</p>
	  </div>
	</div>
</main>
<?php 
	require_once 'view/footer.php';
 ?>		
		  