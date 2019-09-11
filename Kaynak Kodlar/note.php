<?php require 'header.php'; 
if (isset($_GET['link'])) {
	$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link");
	$sorgu->execute(array(
		'not_link' => guvenlik($_GET['link'])
	));
	$sonuc=$sorgu->rowcount();
	$notdetay=$sorgu->fetch(PDO::FETCH_ASSOC);

	if ($sonuc==0) {
		header("location:404.php");
		exit;
	}

	if ($notdetay['not_durum']==0) {
		header("location:404.php");
		exit;
	}

	if ($notdetay['not_limit'] < $notdetay['not_okunma_sayisi']) {
		header("location:404.php");
		exit;
	}

} else {
	header("location:index.php");
	exit;
}



?>

<?php 
if (strlen($notdetay['not_sifre'])>0 AND !isset($_SESSION['sifre_durum'])) { ?>
	<div class="container mt-3">
		<div class="row d-flex justify-content-center">
			<div class="col-md-8">
				<div class="card shadow-lg">
					<div class="card-body p-4">
						<form action="islemler/ajax.php" method="POST" accept-charset="utf-8">
							<div class="form-row d-flex justify-content-center text-center">
								<div class="col-md-8 form-group">
									<label>Not Şifresi</label>
									<input type="text" name="not_sifre" placeholder="Notun Şifresini Girin" class="form-control">
									<input type="hidden" name="not_link" value="<?php echo guvenlik($_GET['link']) ?>">
								</div>
							</div>
							<div class="text-center">
								<button type="submit" name="sifrekontrol" class="btn btn-primary">Kontrol Et</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } else { 
	$sorgu=$db->prepare("UPDATE notlar SET not_okunma_sayisi=:not_okunma_sayisi WHERE not_link=:not_link");
	$sorgu->execute(array(
		'not_okunma_sayisi' => $notdetay['not_okunma_sayisi']+1,
		'not_link' => $_GET['link']
	));
	?>
	<div class="container mt-3">
		<div class="row d-flex justify-content-center">
			<div class="col-md-8">
				<div class="card shadow-lg">
					<?php if (isset($_SESSION['sifre_durum'])): ?>
						<div class="card-header">
							<div class="alert alert-danger text-center">
							Notu Kopyalamayı Unutmayın
						</div>
						</div>
					<?php endif ?>
					<div class="card-body p-3">
						<textarea readonly="" name="not_detay" class="form-control" style="height: 20rem"><?php echo $notdetay['not_detay'] ?></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } unset($_SESSION['sifre_durum']) ?>


<div class="container mt-4">
	<div class="row d-flex justify-content-center">
		<div class="col-md-3">
			<div class="card text-center shadow-lg istatistik">
				<div class="card-body">
					<h6 class="font-weight-bold">Toplam Okunma Sayısı</h6>
					<span><?php echo $notdetay['not_okunma_sayisi'] ?></span>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card text-center shadow-lg istatistik">
				<div class="card-body">
					<h6 class="font-weight-bold">Eklenme Tarihi</h6>
					<span><?php echo $notdetay['not_eklenme_tarih'] ?></span>
				</div>
			</div>
		</div>
	</div>
</div>


<?php require 'footer.php'; ?>

<?php 
if (@$_GET['durum']=="sifreyanlis") { ?>
  <script type="text/javascript">
    Swal.fire({
      type: 'error',
      title: 'Hata',
      text: 'Girdiğiniz Şifre Yanlış',
      confirmButtonText: "Tamam"
    })
  </script>
  <?php } ?>