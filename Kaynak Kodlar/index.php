<?php require 'header.php'; ?>

<div class="container mt-3">
  <div class="row d-flex justify-content-center">
    <div class="col-md-10">
      <div class="card shadow-lg">
        <form action="islemler/ajax.php" method="POST" accept-charset="utf-8">
          <div class="card-body p-3">
            <textarea required="" name="not_detay" class="form-control" style="height: 20rem"></textarea>
          </div>
          <div class="card-footer text-center">
           <button type="button" class="btn btn-danger" id="seceneklerbutonu">Seçenekler</button>
           <button type="button" class="btn btn-primary" id="paylasmabutonu">Paylaş</button>
           <input type="submit"  value="Gönder" class="d-none" name="notekleme" id="gondermebutonu">
           <div id="seceneklerbolumu" style="display: none;">
             <div class="form-row">
               <div class="col-md-6 form-group">
                <label>Not Başlık</label>
                <input type="text" name="not_baslik" placeholder="Notunuzun Başlığını Girin" class="form-control">
              </div>
              <div class="col-md-6 form-group">
                <label>Okunma Limiti</label>
                <input type="number" name="not_limit" placeholder="Okunma Limiti" class="form-control">
              </div>
            </div>
            <div class="form-row">
             <div class="col-md-6 form-group">
              <label>Not Şifresi</label>
              <input type="password" name="not_sifre" placeholder="Notunuzun Şifresiniz Girin" class="form-control not-sifresi">
            </div>
            <div class="col-md-6 form-group">
              <label>Şifre Tekrar</label>
              <input type="password" placeholder="Şifrenizi Tekrar Girin" class="form-control not-sifresi-tekrar">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</div>


<div class="container mt-4">
  <div class="row d-flex justify-content-center">


    <?php 
    $sorgu=$db->prepare("SELECT not_id FROM notlar");
    $sorgu->execute();
    $sonuc=$sorgu->rowcount();
    ?>
    <div class="col-md-3">
      <div class="card text-center shadow-lg istatistik">
        <div class="card-body">
          <h6 class="font-weight-bold">Toplam Not Sayısı</h6>
          <span><?php echo $sonuc ?></span>
        </div>
      </div>
    </div>



    <?php 
    $sorgu=$db->prepare("SELECT SUM(not_okunma_sayisi) FROM notlar");
    $sorgu->execute();
    $sonuc=$sorgu->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="col-md-3">
      <div class="card text-center shadow-lg istatistik">
        <div class="card-body">
          <h6 class="font-weight-bold">Toplam Not Okunma Sayısı</h6>
          <span><?php echo $sonuc['SUM(not_okunma_sayisi)'] ?></span>
        </div>
      </div>
    </div>


    <?php 
    $sorgu=$db->prepare("SELECT kul_id FROM kullanicilar");
    $sorgu->execute();
    $sonuc=$sorgu->rowcount();
    ?>
    <div class="col-md-3">
      <div class="card text-center shadow-lg istatistik">
        <div class="card-body">
          <h6 class="font-weight-bold">Toplam Üye Sayısı</h6>
          <span><?php echo $sonuc ?></span>
        </div>
      </div>
    </div>


  </div>
</div>
<?php require 'footer.php'; ?>


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