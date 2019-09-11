<?php require 'header.php'; 
oturumkontrol();
?>

<link rel="stylesheet" type="text/css" href="vendor/datatables/dataTables.bootstrap4.min.css">
<div class="container-fluid mt-3">
	<div class="row d-flex justify-content-center">
		<div class="col-md-12">
			<!-- DataTales Giriş -->
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Notlar</h6>
				</div>
				<div class="card-body">

					<div class="dropdown">
						<button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Dışa Aktar
						</button>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<a class="dropdown-item" href="#">
								<button type="button" class="btn btn-dark icon-split btn-sm" onclick="tiklama('kopyala');">
									<span class="icon text-white-60">
										<i class="far fa-clipboard"></i>
									</span> 
									<span class="text">Kopyala</span>
								</button>
							</a>
							<a class="dropdown-item" href="#">
								<button type="button" class="btn btn-success icon-split btn-sm" onclick="tiklama('excel');">
									<span class="icon text-white-60">
										<i class="far fa-file-excel"></i>
									</span> 
									<span class="text">Excel</span>
								</button>
							</a>
							<a class="dropdown-item" href="#">
								<button type="button" class="btn btn-danger icon-split btn-sm" onclick="tiklama('pdf');">
									<span class="icon text-white-60">
										<i class="far fa-file-pdf"></i>
									</span> 
									<span class="text">PDF</span>
								</button>
							</a>
							<a class="dropdown-item" href="#">
								<button type="button" class="btn btn-info icon-split btn-sm" onclick="tiklama('csv');">
									<span class="icon text-white-60">
										<i class="fas fa-file-csv"></i>
									</span> 
									<span class="text">CSV</span>
								</button>
							</a>
						</div>
					</div>

					<div class="table-responsive mt-3">
						<table class="table table-bordered" id="nottablosu">
							<thead>
								<tr>
									<th>No</th>
									<?php if (yetkikontrol()): ?>
										<th>Ekleyen Kişi</th>
									<?php endif ?>
									<th>Link</th>
									<th>Başlık</th>
									<th>Okunma Sayısı</th>
									<th>Durum</th>
									<th>Limit</th>
									<th>Eklenme Tarihi</th>
									<th>İşlemler</th>
								</tr>
							</thead>

							<tbody>
								<?php 
								$sayi=0;
								
								if (yetkikontrol()) {
									$sorgu=$db->prepare("SELECT notlar.*,kullanicilar.kul_isim FROM notlar LEFT JOIN kullanicilar ON kullanicilar.kul_id=notlar.not_ekleyen ORDER BY not_id DESC");
								} else {
									$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_ekleyen={$_SESSION['kul_id']} ORDER BY not_id DESC");
								}


								$sorgu->execute();
								while ($not=$sorgu->fetch(PDO::FETCH_ASSOC)) { 
									$sayi++;
									?>
									<tr>
										<td><?php echo $sayi; ?></td>
										<?php if (yetkikontrol()): ?>
											<td class="text-center"><?php 
											if (strlen($not['kul_isim'])>0) {
												echo $not['kul_isim'];
											} else {
												echo "---";
											}
											?></td>
										<?php endif ?>
										<td><?php 
										;

										echo "<a href='{$ayarcek['site_link']}/{$not['not_link']}'>{$not['not_link']}</a>";
										
										?></td>
										<td class="text-center"><?php 
										if (strlen($not['not_baslik'])==0) {
											echo "---";
										} else {
											echo $not['not_baslik'];
										}
										?></td>
										<td><?php echo $not['not_okunma_sayisi']; ?></td>
										<td><?php
										if ($not['not_durum']=="0") {
											echo "Pasif";
										} else {
											echo "Aktif";
										}
										?></td>
										<td><?php 
										if ($not['not_limit']>9999999) {
											echo "Limitsiz";
										} else {
											echo $not['not_limit'];
										}
										?></td>
										<td><?php echo $not['not_eklenme_tarih']; ?></td>
										
										<td>
											<div class="row justify-content-center">


												<form action="notduzenle.php" method="POST" accept-charset="utf-8">
													<input type="hidden" name="not_id" value="<?php echo $not['not_id']?>">
													<button type="submit" name="duzenleme" class="btn btn-success btn-sm btn-icon-split">
														<span class="icon text-white-60">
															<i class="fas fa-edit"></i>
														</span>
													</button>
												</form>
												<form class="mx-1" action="islemler/ajax.php" method="POST" accept-charset="utf-8">
													<input type="hidden" name="not_link" value="<?php echo $not['not_link']?>">
													<button type="submit" name="notsilme" class="btn btn-danger btn-sm btn-icon-split">
														<span class="icon text-white-60">
															<i class="fas fa-trash"></i>
														</span>
													</button>
												</form>
												<a href='<?php echo $ayarcek['site_link'] ?>/<?php echo $not['not_link'] ?>'>
													<button type="submit" name="duzenleme" class="btn btn-primary btn-sm btn-icon-split">
														<span class="icon text-white-60">
															<i class="fas fa-eye"></i>
														</span>
													</button>
												</a>
											</div>
										</td>
									</tr>
								<?php } ?>            
							</tbody>
							<tfoot>
								<tr>
									<th>No</th>
									<?php if (yetkikontrol()): ?>
										<th>Ekleyen Kişi</th>
									<?php endif ?>
									<th>Link</th>
									<th>Başlık</th>
									<th>Okunma Sayısı</th>
									<th>Durum</th>
									<th>Limit</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
			<!--Datatables çıkış-->
		</div>
	</div>
</div>

<?php require 'footer.php'; ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/dataTables.buttons.min.js"></script>
<script src="vendor/datatables/buttons.flash.min.js"></script>
<script src="vendor/datatables/buttons.html5.min.js"></script>
<script src="vendor/datatables/buttons.print.min.js"></script>
<script src="vendor/datatables/jszip.min.js"></script>
<script src="vendor/datatables/pdfmake.min.js"></script>
<script src="vendor/datatables/vfs_fonts.js"></script>

<script>
	$("#nottablosu").DataTable({
		initComplete: function () {
			this.api().columns().every( function () {
				var column = this;
				var select = $('<select><option value=""></option></select>')
				.appendTo( $(column.footer()).empty() )
				.on( 'change', function () {
					var val = $.fn.dataTable.util.escapeRegex(
						$(this).val()
						);

					column
					.search( val ? '^'+val+'$' : '', true, false )
					.draw();
				} );

				column.data().unique().sort().each( function ( d, j ) {
					select.append( '<option value="'+d+'">'+d+'</option>' )
				} );
			} );
		},
		dom: "<'row '<'col-md-6'l><'col-md-6'f><'col-md-4 d-none d-print-block'B>>rtip",
		buttons: [
		{
			extend: 'copyHtml5', 
			className: 'kopyalama-buton'
		},
		{
			extend: 'excelHtml5', 
			className: 'excel-buton'
		},
		{
			extend: 'pdfHtml5',
			className: 'pdf-buton'
		},
		{
			extend: 'csvHtml5',
			className: 'csv-buton'
		}
		]
	});


	function tiklama(islem){
		switch (islem){
			case "excel":
			$(".excel-buton").trigger("click");
			break;
			case "kopyala":
			$(".kopyalama-buton").trigger("click");
			break;
			case "pdf":
			$(".pdf-buton").trigger("click");
			break;
			case "csv":
			$(".csv-buton").trigger("click");
			break;
		}
	}

</script>


<?php 
if (@$_GET['durum']=="ok") { ?>
	<script type="text/javascript">
		Swal.fire({
			type: 'success',
			title: 'İşlem Başarılı',
			text: 'İşleminiz Başarıyla Gerçekleştirildi',
			confirmButtonText: "Tamam"
		})
	</script>
<?php } ?>


<?php 
if (@$_GET['durum']=="no") { ?>
	<script type="text/javascript">
		Swal.fire({
			type: 'error',
			title: 'Hata',
			text: 'İşleminiz Başarısız Oldu Lütfen Tekrar Deneyin',
			confirmButtonText: "Tamam"
		})
	</script>
<?php } ?>
