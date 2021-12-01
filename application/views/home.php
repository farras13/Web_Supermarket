<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<!-- toast -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<!-- icon font -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

	<title>Supermarket</title>
</head>

<body>

	<section>
		<div class="container-fluid p-4 mt-2">
			<div class="row">
				<div class="col-md-12">
					<div class="h-100">
						<div class="align-self-center text-center p-5">

							<h2 style="font-size: 32pt;">Form Supermarket</h2>
							<hr class="w-100">

							<form action="<?= base_url('Home/ins_data') ?>" method="post" enctype="multipart/form-data">
								<div class="row g-2">
									<input type="hidden" name="tb" id="tb" value="<?= $tb ?>" disabled>
									<div class="col-md-4">
										<div class="form-floating">
											<input class="form-control" id="barang" name="barang" type="text" onChange='getoutput()' required>
											<label for="barang">Nama Barang</label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-floating">
											<input class="form-control" id="harga" name="harga" type="number" required>
											<label for="harga">Harga</label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-floating">
											<input class="form-control" id="stok" name="stok" type="number" required>
											<label for="stok">Stok</label>
										</div>
									</div>
									<div class="col-md-8">
										<div class="form-floating">
											<input class="form-control" id="inputfile" name="inputfile" type="file"  accept="image/png, image/jpeg" required>
											<label for="inputfile">Gambar</label>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-floating">
											<input class="form-control" id="kode" name="kode" type="text">
											<label for="kode">Kode</label>
										</div>
									</div>
								</div>
								<div class="mx-auto">
									<button type="submit" class="btn btn-primary w-50 mt-4 mb-5">Submit</button>
								</div>
							</form>
							<hr class="w-100 mt-4">
							<h2 style="font-size: 32pt;">Tabel Barang Supermarket</h2>
							<hr class="w-100">
							<div class="table-responsive">
								<table class="table table-light table-striped table-hover align-middle">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Barang</th>
											<th>Harga</th>
											<th>Stok</th>
											<th>Gambar</th>
											<th>Kode</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if (!empty($model['barang'])) {
												$n = 1; // Jika data pada database tidak sama dengan empty (alias ada datanya)
												foreach ($model['barang'] as $data) { // Lakukan looping pada variabel siswa dari controller
													echo "<tr>";
													echo "<td>" . $n . "</td>";
													echo "<td>" . $data->nama_barang . "</td>";
													echo "<td>" . $data->harga . "</td>";
													echo "<td>" . $data->stok . "</td>";
													echo "<td><img class='img-fluid w-25' src='". base_url('assets/uploads/') . $data->gambar . "' alt=''></td>";
													echo "<td>" . $data->kode . "</td>";
													echo "<td><a class='btn btn-warning' href='". base_url('Home/beli/') . $data->id ."'><i class='fa fa-shopping-cart'></i>Beli</a></td>";
													echo "</tr>";
												}
											} else { // Jika data tidak ada
												echo "<tr><td colspan='5'>Data tidak ada</td></tr>";
											} 
										
										?>
									</tbody>
								</table>
							</div>
							<?php
							// Tampilkan link-link paginationnya
							echo $model['pagination'];
							?>
							<hr class="w-100 mt-4">
							<a class="mx-auto btn btn-dark w-50 mt-4 mb-5" href="<?= base_url('Cart') ?>"><i class="fa fa-shopping-cart"></i> Go to Cart</a>
							<hr class="w-100">
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Optional JavaScript; choose one of the two! -->

	<!-- Option 1: Bootstrap Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<!-- jquery -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<!-- toast -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<script>
		$(document).ready(() => {
			<?php if (isset($_SESSION['toast'])) { ?>
				toastr.options.closeButton = true;
				var toastvalue = "<?php echo $_SESSION['toast'] ?>";
				var status = toastvalue.split(":")[0];
				var message = toastvalue.split(":")[1];
				if (status === "success") {
					toastr.success(message, status);
				} else if (status === "error") {
					toastr.error(message, status);
				} else if (status == "warn") {
					toastr.warning(message, status);
				}
			<?php } ?>
		});
	</script>

	<!-- kode -->
	<script>
		function getoutput() {
			// getfilename
			var filename = document.getElementById('barang').value;
			var hitung = filename.trim().split(/\s+/).length;

			if (hitung < 2) {
				var matches = filename.slice(0, 2);
				var upper = matches.toUpperCase();
			} else {
				var matches = filename.match(/\b(\w)/g);
				var acronym = matches.join('');
				var upper = acronym.toUpperCase();
			}

			// getnumber
			var nomer = document.getElementById("tb").value;

			if (nomer != 0) {
				var kd = nomer.padStart(3, '0');
			} else {
				const no = '1';
				var kd = no.padStart(3, '0');
			}

			//setkode
			$('#kode').val(upper + kd);

		}
	</script>

</body>

</html>
