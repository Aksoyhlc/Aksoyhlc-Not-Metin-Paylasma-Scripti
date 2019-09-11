<?php 
require 'baglan.php';
include_once '../fonksiyonlar.php';

$host_adresi=$ayarcek['site_mail_host'];
$mail_adresiniz=$ayarcek['site_mail_mail'];
$port_numarasi=$ayarcek['site_mail_port'];
$mail_sifreniz=$ayarcek['site_mail_sifre'];

if (isset($_POST['ayarkaydet'])) {
	$sorgu=$db->prepare("UPDATE ayarlar SET 
		site_baslik=:site_baslik,
		site_aciklama=:site_aciklama,
		site_link=:site_link,
		site_sahip_mail=:site_sahip_mail,
		site_mail_host=:site_mail_host,
		site_mail_mail=:site_mail_mail,
		site_mail_port=:site_mail_port,
		site_mail_sifre=:site_mail_sifre,
		sayfa_hakkimizda=:sayfa_hakkimizda WHERE id=1
		");

	$sonuc=$sorgu->execute(array(
		'site_baslik' => $_POST['site_baslik'],
		'site_aciklama' => $_POST['site_aciklama'],
		'site_link' => $_POST['site_link'],
		'site_sahip_mail' => $_POST['site_sahip_mail'],
		'site_mail_host' => $_POST['site_mail_host'],
		'site_mail_mail' => $_POST['site_mail_mail'],
		'site_mail_port' => $_POST['site_mail_port'],
		'site_mail_sifre' => $_POST['site_mail_sifre'],
		'sayfa_hakkimizda' => $_POST['sayfa_hakkimizda']
	));

	if ($_FILES['site_logo']['error']=="0") {
		$gecici_isim=$_FILES['site_logo']['tmp_name'];
		$dosya_ismi=rand(100000,999999).$_FILES['site_logo']['name'];
		move_uploaded_file($gecici_isim,"../dosyalar/$dosya_ismi");

		$sorgu=$db->prepare("UPDATE ayarlar SET 
			site_logo=:site_logo WHERE id=1
			");

		$sonuc=$sorgu->execute(array(
			'site_logo' => $dosya_ismi,

		));
	}

	if ($sonuc) {
		header("location:../ayarlar.php?durum=ok");
	} else {
		header("location:../ayarlar.php?durum=no");
	}
	exit;
}

/*****************************************************************/

if (isset($_POST['oturumacma'])) {
	$sorgu=$db->prepare("SELECT * FROM kullanicilar WHERE kul_mail=:kul_mail AND kul_sifre=:kul_sifre");
	$sorgu->execute(array(
		'kul_mail' => guvenlik($_POST['kul_mail']),
		'kul_sifre' => md5($_POST['kul_sifre'])
	));
	$sonuc=$sorgu->rowcount();
	$kullanici=$sorgu->fetch(PDO::FETCH_ASSOC);

	if ($sonuc==0) {
		header("location:../index.php?durum=no");
	} else {
		$_SESSION['kul_isim'] = $kullanici['kul_isim'];
		$_SESSION['kul_mail'] = $kullanici['kul_mail'];
		$_SESSION['kul_id'] = $kullanici['kul_id'];
		$_SESSION['kul_yetki'] = $kullanici['kul_yetki'];
		header("location:../index.php?durum=ok");
	}
	exit;
}

/*****************************************************************/

if (isset($_POST['profilkaydet'])) {
	$sorgu=$db->prepare("UPDATE kullanicilar SET 
		kul_isim=:kul_isim WHERE kul_id=:kul_id
		");

	$sonuc=$sorgu->execute(array(
		'kul_isim' => guvenlik($_POST['kul_isim']),
		'kul_id' => $_SESSION['kul_id']
	));

	if (strlen($_POST['kul_sifre'])>0) {
		$sorgu=$db->prepare("UPDATE kullanicilar SET 
			kul_sifre=:kul_sifre WHERE kul_id=:kul_id
			");

		$sonuc=$sorgu->execute(array(
			'kul_sifre' => md5($_POST['kul_sifre']),
			'kul_id' => $_SESSION['kul_id']
		));
	}

	if ($sonuc) {
		header("location:../profil.php?durum=ok");
	} else {
		header("location:../profil.php?durum=no");
	}
	exit;
}

/*****************************************************************/

if (isset($_POST['notekleme'])) {
	
	if (strlen($_POST['not_limit'])>0) {
		$limit=$_POST['not_limit'];
	} else {
		$limit=9999999999;
	}


	$link=linkuret();

	$satirsor=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link");
	$satirsor->execute(array(
		'not_link' => $link
	));
	$sonuc=$satirsor->rowcount();

	while ($sonuc >= 1) {
		$link=linkuret();
		
		if (@$asama2!=0) {
			$satirsor=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link");
			$satirsor->execute(array(
				'not_link' => $link
			));
			$asama2=$satirsor->rowcount();
		} else {
			break;
		}
	}

	if (strlen($_POST['not_sifre'])>0) {
		$sifre=md5($_POST['not_sifre']);
	} else {
		$sifre="";
	}

	

	if (isset($_SESSION['kul_id'])) {
		$ekleyen=$_SESSION['kul_id'];
	} else {
		$ekleyen="";
	}


	$sorgu=$db->prepare("INSERT INTO notlar SET
		not_baslik=:not_baslik,
		not_detay=:not_detay,
		not_limit=:not_limit,
		not_sifre=:not_sifre,
		not_link=:not_link,
		not_ekleyen=:not_ekleyen
		");
	$sonuc=$sorgu->execute(array(
		'not_baslik' => guvenlik($_POST['not_baslik']),
		'not_detay' => guvenlik($_POST['not_detay']),
		'not_limit' => $limit,
		'not_sifre' => $sifre,
		'not_link' => $link,
		'not_ekleyen' => $ekleyen
	));


	$_SESSION['not_link']=$link;


	if ($sonuc) {		
		header("location:../sonuc.php?durum=ok");
	} else {		
		header("location:../index.php?durum=no");
	}
	exit;
}
/*****************************************************************/

if (isset($_POST['notguncelle'])) {
	if ($_SESSION['kul_yetki']!=1) {
		$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link AND not_ekleyen=:not_ekleyen");
		$sorgu->execute(array(
			'not_link' => guvenlik($_POST['not_link']),
			'not_ekleyen' => $_SESSION['kul_id']
		));
		$sonuc=$sorgu->rowcount();

		if ($sonuc==0) {
			header("location:../notlar.php?durum=hata");
			exit;
		}

	}

	$sorgu=$db->prepare("UPDATE notlar SET
		not_baslik=:not_baslik,
		not_detay=:not_detay,
		not_limit=:not_limit,
		not_durum=:not_durum WHERE not_id=:not_id
		");
	$sonuc=$sorgu->execute(array(
		'not_baslik' => guvenlik($_POST['not_baslik']),
		'not_detay' => guvenlik($_POST['not_detay']),
		'not_limit' => guvenlik($_POST['not_limit']),
		'not_durum' =>  guvenlik($_POST['not_durum']),
		'not_id' => guvenlik($_POST['not_id'])
	));

	if ($sonuc) {		
		header("location:../notlar.php?durum=ok");
	} else {		
		header("location:../notlar.php?durum=no");
	}
	exit;

}

/*****************************************************************/

if (isset($_POST['sifrekontrol'])) {
	$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link AND not_sifre=:not_sifre");
	$sorgu->execute(array(
		'not_link' => guvenlik($_POST['not_link']) ,
		'not_sifre' => md5($_POST['not_sifre'])
	));
	$sonuc=$sorgu->rowcount();
	
	if ($sonuc==0) {
		header("location:../note.php?link={$_POST['not_link']}&durum=sifreyanlis");
		exit;
	} else {
		$_SESSION['sifre_durum']="Doğru";
		header("location:../note.php?link={$_POST['not_link']}");
		exit;
	}
}

/*****************************************************************/

if (isset($_POST['kayitol'])) {
	$sorgu=$db->prepare("SELECT * FROM kullanicilar WHERE kul_mail=:kul_mail");
	$sorgu->execute(array(
		'kul_mail' => guvenlik($_POST['kul_mail'])
	));
	$sonuc=$sorgu->rowcount();
	if ($sonuc==0) {
		$sorgu=$db->prepare("INSERT INTO kullanicilar SET
			kul_isim=:kul_isim,
			kul_mail=:kul_mail,
			kul_sifre=:kul_sifre
			");
		$sonuc=$sorgu->execute(array(
			'kul_isim' => guvenlik($_POST['kul_isim']),
			'kul_mail' => guvenlik($_POST['kul_mail']),
			'kul_sifre' => md5($_POST['kul_sifre'])
		));


		if ($sonuc) {
			echo '{"sonuc":"ok"}';
		} else {
			echo '{"sonuc":"no"}';
		}
		
	} else {
		echo '{"sonuc":"mailalindi"}';
	}
	exit;

}

/*********************************************/

if (isset($_POST['notsilme'])) {
	if ($_SESSION['kul_yetki']!=1) {
		$sorgu=$db->prepare("SELECT * FROM notlar WHERE not_link=:not_link AND not_ekleyen=:not_ekleyen");
		$sorgu->execute(array(
			'not_link' => guvenlik($_POST['not_link']),
			'not_ekleyen' => $_SESSION['kul_id']
		));
		$sonuc=$sorgu->rowcount();

		if ($sonuc==0) {
			header("location:../notlar.php?durum=hata");
			exit;
		}

	}



	$sorgu=$db->prepare("DELETE FROM notlar WHERE not_link=:not_link");
	$sonuc=$sorgu->execute(array(
		'not_link' => guvenlik($_POST['not_link'])
	));

	if ($sonuc) {
		header("location:../notlar.php?durum=ok");
	} else {
		header("location:../notlar.php?durum=no");
	}

	exit;
}


/*********************************************/


if (isset($_POST['iletisimformu'])) {
	
	require_once 'PHPMailer/Exception.php';
	require_once 'PHPMailer/PHPMailer.php';
	require_once 'PHPMailer/SMTP.php';

	$mailbasligi=$_POST['form_konu']." | İletişim Formu";
	$isim=$_POST['form_isim'];

	$mail = new PHPMailer\PHPMailer\PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl'; 
	$mail->Host = $host_adresi;
	$mail->Port = $port_numarasi; 
	$mail->IsHTML(true);
	$mail->Username = $mail_adresiniz;
	$mail->Password = $mail_sifreniz; 
	$mail->SetFrom($mail->Username, $isim);	
	$mail->Subject = $mailbasligi;
	$mail->CharSet = 'UTF-8';
	$mail->AddReplyTo($_POST['form_mail'], $isim);
	$mailicerigi=$_POST['form_mesaj']."<hr><br> ".$ayarcek['site_baslik']." sitesindeki iletişim formundan gönderildi.";
	$mail->Body = $mailicerigi;
	$mail->AddAddress($ayarcek['site_sahip_mail']);
	
	if ($mail->send()) {
		header("location:../iletisim.php?durum=ok");
	} else {
		header("location:../iletisim.php?durum=no");
	}
	exit;
}


/*********************************************/


if (isset($_POST['sifre_sifirlama_a1'])) {
	$sorgu=$db->prepare("SELECT * FROM kullanicilar WHERE kul_mail=:kul_mail");
	$sorgu->execute(array(
		'kul_mail' => guvenlik($_POST['kul_mail']),
	));
	$sonuc=$sorgu->rowcount();

	if ($sonuc!=0) {
		$_SESSION['sifirlanacak_mail']=guvenlik($_POST['kul_mail']);

		require_once 'PHPMailer/Exception.php';
		require_once 'PHPMailer/PHPMailer.php';
		require_once 'PHPMailer/SMTP.php';

		$mailbasligi="Şifre Hatırlatma";
		$isim=$ayarcek['site_baslik'];

		$mail = new PHPMailer\PHPMailer\PHPMailer(); 
		$mail->IsSMTP(); 
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl'; 
		$mail->Host = $host_adresi;
		$mail->Port = $port_numarasi; 
		$mail->IsHTML(true);
		$mail->Username = $mail_adresiniz;
		$mail->Password = $mail_sifreniz; 
		$mail->SetFrom($mail->Username, $isim);	
		$mail->Subject = $mailbasligi;
		$mail->CharSet = 'UTF-8';
		$_SESSION['guvenlik_kodu']=rand(1000000,9999999);
		$mailicerigi=$ayarcek['site_baslik']." sitesinde yapmış olduğunuz şifre sıfırlama işlemine ait güvenlik kodunuz aşağıdadır <hr>".$_SESSION['guvenlik_kodu']."<hr> bu kodu güvenlik kodu alanına yazın";
		$mail->Body = $mailicerigi;
		$mail->AddAddress($_POST['kul_mail']);

		if ($mail->send()) {
			echo '{"sonuc":"ok"}';
		} else {
			echo '{"sonuc":"hata"}';
		}
		
	} else {
		echo '{"sonuc":"no"}';
	}
	exit;
}



/*********************************************/


if (isset($_POST['sifre_sifirlama_a2'])) {
	if ($_SESSION['guvenlik_kodu']==$_POST['guvenlik_kodu']) {
		$_SESSION['asil_mail']=$_SESSION['sifirlanacak_mail'];
		$_SESSION['sifre_durum']="Tamam";
		echo '{"sonuc":"ok"}';

	} else {
		echo '{"sonuc":"no"}';
	}
	exit;
}


/*********************************************/


if (isset($_POST['sifre_sifirlama_a3'])) {
	if ($_SESSION['sifre_durum']=="Tamam") {
		$sorgu=$db->prepare("UPDATE kullanicilar SET 
			kul_sifre=:kul_sifre WHERE kul_mail=:kul_mail
			");

		$sonuc=$sorgu->execute(array(
			'kul_sifre' => md5($_POST['yeni_sifre']),
			'kul_mail' => $_SESSION['sifirlanacak_mail']
		));

		if ($sonuc) {
			echo '{"sonuc":"ok"}';
		} else {
			echo '{"sonuc":"no"}';
		}
		
	}  else {
		echo '{"sonuc":"no"}';
	}
	exit;

}




?>