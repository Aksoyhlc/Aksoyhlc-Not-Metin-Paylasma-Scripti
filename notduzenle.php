<?php require 'header.php'; 

if ($_SESSION['kul_yetki']!=1) {
	$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_id=:not_id AND not_ekleyen=:not_ekleyen");
	$sorgu->execute(array(
		'not_id' => guvenlik($_POST['not_id']),
		'not_ekleyen' => $_SESSION['kul_id']
	));
	$sonuc=$sorgu->rowcount();

	if ($sonuc==0) {
		header("location:../notlar.php?durum=hata");
		exit;
	}

}


$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_id=:not_id");
$sorgu->execute(array(
	'not_id' => guvenlik($_POST['not_id'])
));
$not=$sorgu->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-3">
	<div class="row d-flex justify-content-center">
		<div class="col-md-10">
			<div class="card shadow-lg">
				<div class="card-body p-3">
					<form action="islemler/ajax.php" method="POST" accept-charset="utf-8">		
						<div class="form-row d-flex justify-content-center text-center">
							<div class="col-md-8 form-group">
								<label>Not Başlığı</label>
								<input type="text" name="not_baslik" value="<?php echo $not['not_baslik'] ?>" placeholder="Not Başlığını Girin" class="form-control">
							</div>
						</div>

						<div class="form-row d-flex justify-content-center text-center">
							<div class="col-md-8 form-group">
								<label>Not Limiti</label>
								<input type="number" name="not_limit" value="<?php echo $not['not_limit'] ?>" placeholder="Not Limitini Girin" class="form-control">
							</div>
						</div>

						<div class="form-row d-flex justify-content-center text-center">
							<div class="col-md-8 form-group">
								<label>Not Durumu</label>
								<select name="not_durum" class="form-control">
									<option <?php if($not['not_durum']=="1"){echo "selected";} ?> value="1">Aktif</option>
									<option <?php if($not['not_durum']=="0"){echo "selected";} ?> value="0">Pasif</option>
								</select>
							</div>
						</div>

						<div class="form-row d-flex justify-content-center text-center">
							<div class="col-md-10 form-group">
								<label>Not Detay</label>
								<textarea name="not_detay" class="form-control" style="height: auto;"><?php echo $not['not_detay'] ?></textarea>
							</div>
						</div>
						<input type="hidden" name="not_id" value="<?php echo guvenlik($_POST['not_id']) ?>">
						<div class="text-center">
							<button type="submit" class="btn btn-primary" name="notguncelle">Kaydet</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require 'footer.php'; ?>