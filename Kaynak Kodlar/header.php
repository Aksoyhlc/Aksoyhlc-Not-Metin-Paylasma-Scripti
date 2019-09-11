<?php 
require 'islemler/baglan.php';
include_once 'fonksiyonlar.php';
require_once 'dil.php';

if (isset($_GET['dil'])) {
  if ($_GET['dil']=="tr") {
    $_SESSION['site_dili']="tr";
  } elseif ($_GET['dil']=="fr") {
    $_SESSION['site_dili']="fr";
  } elseif ($_GET['dil']=="es") {
    $_SESSION['site_dili']="es";
  } else {
    $_SESSION['site_dili']="en";
  }
}


if (empty($_SESSION['site_dili'])) {
 $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0,2);
 if ($lang=="tr") {
  $dil=$tr;
} elseif ($lang=="fr") {
  $dil=$fr;
}  elseif ($lang=="es") {
  $dil=$es;
} else {
  $dil=$en;
}

} else {
  if ($_SESSION['site_dili']=="tr") {
    $dil=$tr;
  } elseif ($_SESSION['site_dili']=="fr") {
    $dil=$fr;
  } elseif ($_SESSION['site_dili']=="es") {
    $dil=$es;
  } else {
    $dil=$en;
  }
}



?>
<!doctype html>
<html lang="tr">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/png" href="dosyalar/<?php echo $ayarcek['site_logo'] ?>">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" type="text/css" href="css/sb-admin-2.min.css">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <title><?php echo $ayarcek['site_baslik'] ?></title>

  <style type="text/css" media="screen">
    body {
      background: #667db6;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #667db6, #0082c8, #0082c8, #667db6);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #667db6, #0082c8, #0082c8, #667db6); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }

    .istatistik{
      border: 2px solid gray;
    }
  </style>

</head>
<body>

  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-md-12 text-center">
       <a href="index.php">
        <button type="button" class="btn btn-success"><?php echo $dil['notolustur'] ?></button>
      </a>
      <?php 
      if (isset($_SESSION['kul_id'])) { ?>
       <a href="notlar.php">
        <button type="button" class="btn btn-light">Notlarım</button>
      </a>
      <a href="profil.php">
        <button type="button" class="btn btn-info">Profil</button>
      </a>

      <a href="islemler/cikis.php">
        <button type="button" class="btn btn-light">Çıkış</button>
      </a>

    <?php } else { ?>
      <a href="kayit.php">
        <button type="button" class="btn btn-info"><?php echo $dil['kayitol'] ?></button>
      </a>

      <a href="login.php">
        <button type="button" class="btn btn-success"><?php echo $dil['girisyap'] ?></button>
      </a>

    <?php } ?>

    <a href="iletisim.php">
      <button type="button" class="btn btn-light"><?php echo $dil['iletisim'] ?></button>
    </a>

    <a href="hakkimizda.php">
      <button type="button" class="btn btn-light"><?php echo $dil['hakkimizda'] ?></button>
    </a>

    <?php 
    if (yetkikontrol()) { ?>

      <a href="ayarlar.php">
        <button type="button" class="btn btn-outline-light">Ayarlar</button>
      </a>
    <?php } ?>


    <span class="dropdown">
      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Dil Seç
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="index.php?dil=tr">Türkçe</a>
        <a class="dropdown-item" href="index.php?dil=en">İngilizce</a>
        <a class="dropdown-item" href="index.php?dil=fr">Fransızca</a>
      </div>
    </span>

  </div>
</div>
</div>
