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

//Bize gerekli olan di�er dosyalardaki bilgileri de kullanabilmek i�in onlar� da sayfaya dahil ediyoruz.
include ("ayarlar.php");
include ("fonksiyonlar.php");
?>
<title><?php echo "$site_adi"." - "."$site_aciklama"; ?></title>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Formdan gelen de�erleri al�p de�i�kenleri tan�ml�yoruz.
$username = $_POST['username'];
$userpass = $_POST['userpass'];
//Formdan gelen verilerin bo� olmamas� i�in kontrol ediyoruz.
$username_hata = "kullan�c� ad�";
$userpass_hata = "�ifre";
$link = "index.php";
bosmu_kontrol($username, $username_hata, $link);
bosmu_kontrol($userpass, $userpass_hata, $link);
//Kullan�c� ad� ve �ifre bo� de�ilse �imdi de html kodu ya da zararl� bir kod i�ermemesini sa�l�yoruz.
guvenlik_filtresi($username);
guvenlik_filtresi($userpass);
//Veritaban� ba�lant�m�z� yap�yoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');
//Bu kez de verilerin sql kodu i�ermediklerine emin oluyoruz.
$username = mysql_real_escape_string($username);
$userpass = mysql_real_escape_string($userpass);
//�ifreyi sha1 format�na �eviriyoruz.
$userpass = sha1($userpass);
//Mail adresi kay�tl� de�ilse uyar�s�n� veriyoruz.
$kullanici_kontrol = mysql_query("select * from uyeler where username='$username'", $baglanti_pointer);
$kulanici_kontrol_sonucu = mysql_num_rows($kullanici_kontrol);
if ($kullanici_kontrol_sonucu == "0"){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz kullan�c� ad� kay�tl� de�il.</font><br><br>';
echo '<a href="index.php">Geri D�n</a></b></center>';
exit;
}
else {
}
//Gelen bilgilerin veritaban�ndan do�rulu�unu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where username='$username' and userpass='$userpass' and aktiflik='pasif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == "0"){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">�yeli�inizi aktifle�tirmemi�siniz, l�tfen aktifle�tirme i�lemini yap�n.</font><br><br>';
echo '<a href="aktivasyon.php">Aktivasyon maili gelmedi ise t�klay�n</a></b></center>';
exit;
}
//Kullan�c� ad� ve �ifreyi veritaban�ndan sorgulat�yoruz. 
$kullanici_sorgu = mysql_query("select * from uyeler where username='$username' and userpass='$userpass' and aktiflik='aktif'"); 
//Kullan�c� sorgusunun sonucunu al�yoruz ve uygun i�lemler yapt�r�yoruz.
$kullanici_sorgu_sonucu = mysql_num_rows($kullanici_sorgu);
if ($kullanici_sorgu_sonucu == "0"){
echo '<br><center><b><font face="verdana" size="2" color="red">�yelik bilgileri bulunamad�. Kullan�c� ad� veya �ifreyi yanl�� girdiniz.</font><br><br>';
echo '<a href="index.php">Geri D�n</a></b></center>';
exit;
}
else {
while($kullanici_bilgi = mysql_fetch_array($kullanici_sorgu)) 
{ 
//Veritaban�ndan kullan�c� seviyesini al�p, sessiona kaydediyoruz. 
$_SESSION['kullanici'] = $kullanici_bilgi['username']; 
//Admini, y�netim paneline y�nlendiriyoruz.
header("Location: kullanici.php"); 
} 
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
include ("footer.php");
?>
</body>
</html>
