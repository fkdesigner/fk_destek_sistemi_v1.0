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

Bu dosya FK Destek sisteminin bir par�as�d�r.

	FK Destek Sistemi �cretsizdir: bu sistemi Free Software Foundation 
	taraf�ndan yay�nlanm�� GNU Genel Kamu Lisans� 3 ya da sonras�n�n 
	�artlar� alt�nda da��tabilir ve/veya d�zenleyebilirsiniz.

	FK Destek Sistemi faydal� olmas� umuduyla da��t�lmaktad�r, 
	ancak hi� bir garantisi yoktur; herhangi belli bir amaca uygunlu�una 
	bile garanti veremez. Daha fazla detay i�in GNU Genel Kamu Lisans�na 
	bak�n.
	
	FK Destek Sistemi ile Genel Kamu Lisans�'n�n bir kopyas�n� da alm�� 
	olmal�s�n�z. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bak�n.


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

//bosmu_kontrol: Formun bos g�nderilmemesi i�in yazdigim fonksiyon.
function bosmu_kontrol($deger, $hata, $link){	
	if (empty($deger)){	
	echo "<br><center><b><font face='verdana' size='2' color='red'>L�tfen $hata alan�n� doldurun.</font></b>";	
	echo "<br><br><a href=\"$link\">Geri d�nmek i�in t�klay�n.</a></center><br>";	
	exit;	
	}
return;
}

//guvenlik_filtresi: K�t� ama�li ziyaret�iler i�in forma yazilan html kodlarini temizler ve kod yaziminda kullanilan temel karakterleri siler.
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

//eposta_kontrol: E-Posta adresi dogru bir bi�imde yazilmis mi diye kontrol eder, dogru ise verilen degiskene atar.
function eposta_kontrol($deger, $hata){	
	if (eregi("^.+@.+\..+$", $deger, $deger )){
	}
	else {
	echo '<center><br><font face="verdana" size="2" color="red">L�tfen e-mail adresinizi dogru bir bi�imde giriniz.</font><br><br>';
	echo '<a href="'."$hata".'.php">Geri D�n</a></center>';
	exit;
	}
	list ($deger) = $deger;
return $deger;
}

//db_baglan: Veritabani baglantisini yapar.
function db_baglan($db_server, $db_username, $db_userpass, $db_name){
@mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanina baglanilamiyor, l�tfen veritabani ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri D�n</a></center>');
mysql_select_db("$db_name") or die('<br><center><b><font face="arial" size="3" color="red">Veritabani se�ilemiyor l�tfen veritabani adi kismina dogru bilgi girdiginizden emin olunuz.</font></b><br><br><a href="install.php">Geri D�n</a></center>');
return;
}

//rastgele_sifre: Aktifle�tirme ya da �ifre unutma durumlar� i�in random olarak �ifre �retir.
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
