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

							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Nama Barang</th>
										<th>Harga</th>
										<th>Qty</th>
										<th>Subtotal</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $hrg=0; foreach($cart as $c): ?>
										<tr>
											<td><?= $c->nama_barang ?></td>
											<td>Rp. <?= number_format($c->harga,2,",","."); ?></td>
											<td><?= $c->qty ?></td>
											<td>Rp. <?= number_format($c->subtotal,2,",","."); ?></td>
											<td>
												<a href="<?= base_url('cart/min/').$c->id_barang ?>" class="btn btn-warning"><i class="fa fa-minus"></i></a>
												<?php if($c->stok == 0): ?>
													<button class="btn btn-warning" disabled><i class="fa fa-plus"></i></button>
												<?php else: ?>
													<a href="<?= base_url('cart/plus/').$c->id_barang ?>" class="btn btn-warning"><i class="fa fa-plus"></i></a>
												<?php endif; ?>

											</td>
										</tr>
									<?php $hrg += $c->subtotal; endforeach ?>
								</tbody>
								<tfoot>
									<tr>
										<th class="text-end" colspan="3">Total Harga</th>
										<th class="text-center">Rp. <?php $total = $hrg + 19000; echo number_format($total,2,",","."); ?></th>
										<th></th>
									</tr>
								</tfoot>
							</table>
						
							<hr class="w-100 mt-4">
							<a class="mx-auto btn btn-danger w-50 mt-4" href="<?= base_url('Cart/out') ?>"><i class="fa fa-home"></i> CheckOut</a>
							<a class="mx-auto btn btn-dark w-50 mt-4 mb-5" href="<?= base_url('Home') ?>"><i class="fa fa-home"></i> Go Home</a>
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
</body>

</html>
