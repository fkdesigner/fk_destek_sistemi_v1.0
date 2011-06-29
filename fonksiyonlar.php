<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<?php
/*
FK Destek Sistemi
Yazar: Firat KOYUNCU
Nick: FK Designer
Website: www.fkdesigner.com
E-Mail: fkdesigner@hotmail.com - iletisim@fkdesigner.com
Facebook Sayfasi: www.facebook.com/fkdesigner
Twitter Sayfasi: www.twitter.com/fkdesigner

Bu dosya FK Destek sisteminin bir parçasıdır.

	FK Destek Sistemi ücretsizdir: bu sistemi Free Software Foundation 
	tarafından yayınlanmış GNU Genel Kamu Lisansı 3 ya da sonrasının 
	şartları altında dağıtabilir ve/veya düzenleyebilirsiniz.

	FK Destek Sistemi faydalı olması umuduyla dağıtılmaktadır, 
	ancak hiç bir garantisi yoktur; herhangi belli bir amaca uygunluğuna 
	bile garanti veremez. Daha fazla detay için GNU Genel Kamu Lisansına 
	bakın.
	
	FK Destek Sistemi ile Genel Kamu Lisansı'nın bir kopyasını da almış 
	olmalısınız. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bakın.


This file is part of FK Destek Sistemi.

    FK Destek Sistemi is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    FK Destek Sistemi is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.   
*/
?>

</head>
<body>
<?php
//FONKSIYONLARIMIZ: Toplam 5 adet fonksiyonumuz var.

//bosmu_kontrol: Formun bos gönderilmemesi için yazdigim fonksiyon.
function bosmu_kontrol($deger, $hata, $link){	
	if (empty($deger)){	
	echo "<br><center><b><font face='verdana' size='2' color='red'>Lütfen $hata alanını doldurun.</font></b>";	
	echo "<br><br><a href=\"$link\">Geri dönmek için tıklayın.</a></center><br>";	
	exit;	
	}
return;
}

//guvenlik_filtresi: Kötü amaçli ziyaretçiler için forma yazilan html kodlarini temizler ve kod yaziminda kullanilan temel karakterleri siler.
function guvenlik_filtresi($deger){	
$deger = strip_tags ($deger);	
$deger = eregi_replace ("<", "", $deger);	
$deger = eregi_replace (">", "", $deger);	
$deger = eregi_replace ("/", "", $deger);	
$deger = eregi_replace ("=", "", $deger);	
$deger = eregi_replace ("'", "", $deger);	
$deger = eregi_replace ('"', "", $deger);	
$deger = eregi_replace ("{", "", $deger);	
$deger = eregi_replace ("}", "", $deger);	
$deger = eregi_replace ("&", "", $deger);	
$deger = eregi_replace ("%", "", $deger);	
$deger = eregi_replace ("$", "", $deger);
$deger = eregi_replace (";", "", $deger);
return $deger;
}

//eposta_kontrol: E-Posta adresi dogru bir biçimde yazilmis mi diye kontrol eder, dogru ise verilen degiskene atar.
function eposta_kontrol($deger, $hata){	
	if (eregi("^.+@.+\..+$", $deger, $deger )){
	}
	else {
	echo '<center><br><font face="verdana" size="2" color="red">Lütfen e-mail adresinizi dogru bir biçimde giriniz.</font><br><br>';
	echo '<a href="'."$hata".'.php">Geri Dön</a></center>';
	exit;
	}
	list ($deger) = $deger;
return $deger;
}

//db_baglan: Veritabani baglantisini yapar.
function db_baglan($db_server, $db_username, $db_userpass, $db_name){
@mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanina baglanilamiyor, lütfen veritabani ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri Dön</a></center>');
mysql_select_db("$db_name") or die('<br><center><b><font face="arial" size="3" color="red">Veritabani seçilemiyor lütfen veritabani adi kismina dogru bilgi girdiginizden emin olunuz.</font></b><br><br><a href="install.php">Geri Dön</a></center>');
return;
}

//rastgele_sifre: Aktifleştirme ya da şifre unutma durumları için random olarak şifre üretir.
function rastgele_sifre() { 
  $salt = "abchefghjkmnpqrstuvwxyz0123456789"; 
  srand((double)microtime()*1000000); 
      $i = 0; 
      while ($i <= 6) { 
            $num = rand() % 33; 
            $tmp = substr($salt, $num, 1); 
            $pass = $pass . $tmp; 
            $i++; 
      } 
      return $pass; 
}

include ("footer.php");
?>
</body>
</html>
