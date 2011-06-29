<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>FK DESTEK S�STEM� - KURULUM SAYFASI</title>
</head>
<body>
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

//G�venlik kodu i�in oturum ba�lat�l�r.
@session_start();

//FONKS�YONLARIMIZ:
//bosmu_kontrol: Formun bo� g�nderilmemesi i�in yazd���m fonksiyon.
function bosmu_kontrol($deger){	
	if (empty($deger)){	
	echo "<br><center><b><font face='verdana' size='2' color='red'>L�tfen t�m alanlar� doldurun.</font></b>";	
	echo "<br><br><a href='install.php'>Geri d�nmek i�in t�klay�n.</a></center><br>";	
	exit;	
	}
return;
}
//guvenlik_filtresi: K�t� ama�l� ziyaret�iler i�in forma yaz�lan html kodlar�n� temizler ve kod yaz�m�nda kullan�lan temel karakterleri siler.
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
//eposta_kontrol: E-Posta adresi do�ru bir bi�imde yaz�lm�� m� diye kontrol eder, do�ru ise verilen de�i�kene atar.
function eposta_kontrol($deger){	
	if (eregi("^.+@.+\..+$", $deger, $deger )){
	}
	else {
	echo '<center><br><font face="arial" size="3" color="red">L�tfen e-mail adresinizi do�ru bir bi�imde giriniz.</font><br><br>';
	echo '<a href="install.php">Geri D�n</a></center>';
	exit;
	}
	list ($deger) = $deger;
return $deger;
}
//db_baglan: Veritaban� ba�lant�s�n� yapar.
function db_baglan($db_server, $db_username, $db_userpass, $db_name){
@mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri D�n</a></center>');
mysql_select_db("$db_name") or die('<br><center><b><font face="arial" size="3" color="red">Veritaban� se�ilemiyor l�tfen veritaban� ad� k�sm�na do�ru bilgi girdi�inizden emin olunuz.</font></b><br><br><a href="install.php">Geri D�n</a></center>');
return;
}

//E�ER FORM G�NDER�LM�� �SE A�A�IDAK� ��LEMLER UYGULANACAKTIR.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri al�yoruz;
$site_adi = $_POST['site_adi'];
$site_aciklama = $_POST['site_aciklama'];
$admin_username = $_POST['admin_username'];
$admin_pass1 = $_POST['admin_pass1'];
$admin_pass2 = $_POST['admin_pass2'];
$admin_email = $_POST['admin_email'];
$db_name = $_POST['db_name'];
$db_username = $_POST['db_username'];
$db_userpass = $_POST['db_userpass'];
$db_server = $_POST['db_server'];
$guvenlik = $_POST['guvenlik'];
//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
bosmu_kontrol($site_adi);
bosmu_kontrol($site_aciklama);
bosmu_kontrol($admin_username);
bosmu_kontrol($admin_pass1);
bosmu_kontrol($admin_pass2);
bosmu_kontrol($admin_email);
bosmu_kontrol($db_name);
bosmu_kontrol($db_username);
bosmu_kontrol($db_userpass);
bosmu_kontrol($db_server);
bosmu_kontrol($guvenlik);
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($site_adi);
guvenlik_filtresi($site_aciklama);
guvenlik_filtresi($admin_username);
guvenlik_filtresi($admin_pass1);
guvenlik_filtresi($admin_pass2);
guvenlik_filtresi($admin_email);
guvenlik_filtresi($db_name);
guvenlik_filtresi($db_username);
guvenlik_filtresi($db_userpass);
guvenlik_filtresi($db_server);
guvenlik_filtresi($guvenlik);
//Admin e-mail adresi do�ru girilmi� mi diye kontrol ediyoruz.
eposta_kontrol ($admin_email);
//Adminin girdi�i iki kullan�c� �ifresi e�le�iyor mu diye kontrol ediyoruz.
if ($admin_pass1 == $admin_pass2){
$admin_pass = $admin_pass1;
}
else {
echo '<center><br><b><font face="arial" size="3" color="red">Admin hesab� i�in girdi�iniz �ifreler birbirleriyle e�le�miyor.</font><br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}
//G�venlik kodu do�ru girilmi� mi diye kontrol ediyoruz, e�er do�ru ise formumuza i�lemleri yapt�raca��z.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$site_adi = mysql_real_escape_string($site_adi);
$site_aciklama = mysql_real_escape_string($site_aciklama);
$admin_username = mysql_real_escape_string($admin_username);
$admin_pass = mysql_real_escape_string($admin_pass);
$admin_email = mysql_real_escape_string($admin_email);
$db_name = mysql_real_escape_string($db_name);
$db_username = mysql_real_escape_string($db_username);
$db_userpass = mysql_real_escape_string($db_userpass);
$db_server = mysql_real_escape_string($db_server);
$guvenlik = mysql_real_escape_string($guvenlik);
//Veritaban� ve site ile ilgili verileri bir �st dizinde ayarlar.php dosyas�na kaydediyoruz.
$dosyaismi = "ayarlar.php";
$dosyaac = fopen($dosyaismi, "w") or die ("Ayarlar.php a��lamad�.");
$yazilacak = "<?php
"."$"."site_adi = ".'"'."$site_adi".'"'.";
"."$"."site_aciklama = ".'"'."$site_aciklama".'"'.";
"."$"."db_name = ".'"'."$db_name".'"'.";
"."$"."db_username = ".'"'."$db_username".'"'.";
"."$"."db_userpass = ".'"'."$db_userpass".'"'.";
"."$"."db_server = ".'"'."$db_server".'"'.";
?>";
if (fwrite($dosyaac, $yazilacak)){
echo '<br><center><b><font face="verdana" size="2" color="green">Bilgiler kaydedildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Bilgiler kaydedilemedi, l�tfen daha sonra deneyin.</font><br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}
//Kay�t bitti�i zaman bir �st dizindeki ayarlar.php dosyas�n� kapat�yoruz.
fclose ($dosyaac);
//Veritaban�nda uyeler, yoneticiler ve tickets tablolar�n� yarat�yoruz.
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri D�n</a></center>');

$uyeler_ekle = mysql_query ("CREATE TABLE `uyeler` ( 
  `no` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `userpass` varchar(250) NOT NULL, 
  `e_mail` varchar(50) NOT NULL, 
  `name` varchar(50) NOT NULL, 
  `surname` varchar(50) NOT NULL,
  `guvenlik_kodu` varchar(250) NOT NULL, 
  `aktiflik` varchar(20) default 'pasif', 
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);
$yoneticiler_ekle = mysql_query ("CREATE TABLE `yoneticiler` ( 
  `no` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `userpass` varchar(250) NOT NULL, 
  `e_mail` varchar(50) NOT NULL,
  `guvenlik_kodu` varchar(250) NOT NULL,  
  `name` varchar(50) NOT NULL, 
  `surname` varchar(50) NOT NULL, 
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);
$tickets_ekle = mysql_query ("CREATE TABLE `tickets` ( 
  `no` int(11) NOT NULL auto_increment,
  `reporter` varchar(25) NOT NULL,
  `icerik` varchar(25) NOT NULL, 
  `ticket` text NOT NULL,
  `durum` varchar(20) default 'a��k', 
  `kategori` varchar(50) NOT NULL, 
  `gonderilme` varchar(50) NOT NULL,
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);

$cevaplar_ekle = mysql_query ("CREATE TABLE `cevaplar` ( 
  `no` int(11) NOT NULL auto_increment,
  `ticket_id` int(11) NOT NULL,
  `icerik` text NOT NULL, 
  `cevaplayan` varchar(20) NOT NULL, 
  `cevaplanma` varchar(50) NOT NULL,
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);

if ($uyeler_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yarat�ld�(%35).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnas�nda bir sorun olu�tu ve kurulum dosyas� gerekli tablolardan birini olu�turamad�. L�tfen kurulum i�in b�t�n ad�mlar� en ba�tan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}

if ($yoneticiler_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yarat�ld�(%70).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnas�nda bir sorun olu�tu ve kurulum dosyas� gerekli tablolardan birini olu�turamad�. L�tfen kurulum i�in b�t�n ad�mlar� en ba�tan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}

if ($tickets_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yarat�ld�(%100).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnas�nda bir sorun olu�tu ve kurulum dosyas� gerekli tablolardan birini olu�turamad�. L�tfen kurulum i�in b�t�n ad�mlar� en ba�tan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}

if ($cevaplar_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Gerekli tablolar�n hepsi olu�turuldu.</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnas�nda bir sorun olu�tu ve kurulum dosyas� gerekli tablolardan birini olu�turamad�. L�tfen kurulum i�in b�t�n ad�mlar� en ba�tan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}

//Admin kullan�c� bilgilerini veritaban�nda yoneticiler tablosuna kaydediyoruz.
//�nce admin �ifresini sha1 ile �ifreliyoruz ve veritaban�na b�yle kaydedilmesini sa�l�yoruz.
$admin_password = sha1($admin_pass);
$admin_ekle = mysql_query ("INSERT INTO yoneticiler (no, username, userpass, e_mail, guvenlik_kodu, name, surname) values ('', '$admin_username', '$admin_password', '$admin_email', '', '', '')", $baglanti_pointer);

if ($admin_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Admin kullan�c� bilgileriniz kaydedildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Kurulum esnas�nda bir sorun olu�tu ve kurulum dosyas� admin kullan�c�s�n� olu�turamad�. L�tfen kurulum i�in b�t�n ad�mlar� en ba�tan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}
//Admin bilgilerini, web site bilgilerini admin kullan�c�s�n�n mail hesab�na mail olarak at�yoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$site_adresi = "http://".$_SERVER['HTTP_HOST'].str_replace("install.php","",$sayfa);

$kime = "$admin_email";
$basliklar = 'From:'."FK Destek Sistemi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<b>Destek Sitenizin Bilgileri:</b><br><font color="red">Admin Kullan�c�ad� : </font>'."$admin_username".'<br><font color="red">E-Posta Adresi : </font>'."$admin_email".'<br><font color="red">Site Ad� : </font>'."$site_adi".'<br><font color="red">Site A��klamas� : </font>'."$site_aciklama".'<br><font color="red">Site Adresi : </font><a href="'."$site_adiresi".'">'."$site_adresi";
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geli�tirici Tak�m�</b>n�n <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> �zerinden g�nderilmi�tir.</font><br><br>';
$son_konu = "FK Destek Sistemi Kuruldu";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">Kurulum hakk�nda mail adresinize bilgi maili g�nderildi.</font><br><br>';
}
else {
echo '<br><center><font face="arial" size="3" color="red">Bir sorun olu�tu ve bilgilendirme maili g�nderilemedi (Bu sorunu �nemsemeyebilirsiniz, problem kurulumun localhostta �al��t�r�l�yor olmas�ndan ya da hostunuzdan kaynaklan�yor olabilir.).</font></center><br>';
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
//install dizinini siliyoruz.
$otosil = unlink ("install.php");
if ($otosil){
echo '<br><center><b><font face="verdana" size="2" color="green">Kurulum dosyas� kurulumu tamamlad� ve g�venli�iniz i�in kendi kendini sildi. Kurulum tamamland�. </font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum dosyas� kendi kendini silmeyi denediyse de �e�itli sebeplerden �t�r� ba�ar�l� olamad�. L�tfen, kurulumu tamamen d�zg�n bir �ekilde bitirdi�inize eminseniz web alan�n�zdan install.php dosyas�n� G�VENL���N�Z ���N silin, art�k ihtiyac�n�z olmayacak. </font><br><br>';
}
//E�er g�venlik sorusu yanl�� girilmi�se hatay� burada verdiriyoruz.
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">G�venlik i�in girdi�iniz veri ile resimdekiler e�le�miyor.</font><br><br>';
echo '<a href="install.php">Geri D�n</a></b></center>';
exit;
}
//Buras� son sat�r, en ba�taki if form girilmi�se sat�r�n�n son kapat�c� komutu a�a��dad�r. Buradan sonra form g�nderilmemi�se i�lemleri ba�layacakt�r.
}
//E�ER FORM G�NDER�LMEM��SE O ZAMAN A�A�IDA BO� FORM G�STER�LECEKT�R.
else { 
?>
<br />
<center><font face="arial" size"5" color="black"><b>FK DESTEK S�STEM� - KURULUM SAYFASI</b></font></center>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">S�TE B�LG�LER�</font>
<form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post">
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Destek Sitesinin Ad� : </font>
<input type="text" name="site_adi" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek verece�iniz sitenin ad�, kullan�c�lar�n�z siteyi bu isimle g�recektir. <i>�rnek: "1ST M��teri Destek"</i></font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Destek Sitesinin A��klamas� : </font>
<input type="text" name="site_aciklama" size="25" maxlength = "50">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek verece�iniz sitede ismin hemen alt�nda belirecektir. Destek slogan�n�z. <i>�rnek: "En k�sa s�rede hizmet, daha k�sa s�rede destek..."</i></font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">ADM�N B�LG�LER�</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullan�c� Ad� : </font>
<input type="text" name="admin_username" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek y�netim paneline eri�mekte kullanaca��n�z admin hesab� i�in girece�iniz kullan�c�ya ait kullan�c� ad� belirleyin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullan�c� �ifresi : </font>
<input type="password" name="admin_pass1" size="25" maxlength = "15">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek y�netim paneline eri�mekte kullanaca��n�z admin hesab� i�in girece�iniz kullan�c�ya ait �ifre belirleyin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullan�c� �ifresi (Tekrar) : </font>
<input type="password" name="admin_pass2" size="25" maxlength = "15">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Admin hesab�n�z i�in belirledi�iniz �ifreyi tekrar buraya girin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin E-Posta Adresi : </font>
<input type="text" name="admin_email" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Elektronik posta adresinizi girin. L�tfen ge�erli bir adres girin. �rnek: <i>"mail@example.com"</i></font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">MYSQL VER�TABANI B�LG�LER�</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritaban� Ad� : </font>
<input type="text" name="db_name" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi i�in bir mysql veritaban� olu�turun ve buraya veritaban� ad�n� yaz�n.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritaban� Kullan�c� Ad� : </font>
<input type="text" name="db_username" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi i�in se�ti�iniz mysql veritaban�na ait kullan�c� ad�n� buraya yaz�n.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritaban� Kullan�c� �ifresi : </font>
<input type="password" name="db_userpass" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi i�in se�ti�iniz mysql veritaban�na ait kullan�c� �ifresini buraya yaz�n.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritaban� Sunucu Adresi : </font>
<input type="text" name="db_server" size="25" maxlength = "30" value="localhost">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi i�in se�ti�iniz mysql veritaban�n�n sunucu adresi, e�er bilmiyorsan�z de�i�tirmeyin.</font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">G�VENL�K TEST�</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">G�venlik Kodu : </font> <br /><img src="guvenlik_kodu.php" />
<br /><input type="text" name="guvenlik" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">B�t�n bu i�lemlerin ger�ekten sizin taraf�n�zdan yap�ld���n� onaylamak i�in l�tfen resimdeki numara ve harfleri alttaki bo� kutucu�a yaz�n, <b><u>harflerin k���k olduklar�na dikkat edin</u></b>.</font>
<br><br><input type="reset" value="TEM�ZLE"> <input name="gonder" type="submit" id="gonder" value="G�NDER">
</form>
<?php
}
include ("footer.php");
?>
</body>
</html>
