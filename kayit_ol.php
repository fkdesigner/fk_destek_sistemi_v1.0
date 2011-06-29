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
//Hemen bir oturum ba�lat�l�yor.
@session_start();
?>
<title><?php echo "$site_adi"." - "."Kay�t Ol"; ?></title>
</head>
<body>
<?php
//E�ER FORM G�NDER�LM�� �SE A�A�IDAK� ��LEMLER UYGULANACAKTIR.
if (isset($_POST["kayit_ol"])) {
//Formdan gelen bilgileri al�yoruz;
$kullanici_adi = $_POST['username'];
$sifre_1 = $_POST['userpass1'];
$sifre_2 = $_POST['userpass2'];
$kullanici_mail = $_POST['user_email'];
$guvenlik = $_POST['guvenlik'];
$guvenlik_kodu = $_SESSION["guvenlik_kodu"];
//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
$hata_kullanici_adi = "kullan�c� ad�";
$link = "kayit_ol.php";
bosmu_kontrol($kullanici_adi, $hata_kullanici_adi, $link);
$hata_sifre1 = "�ifre";
bosmu_kontrol($sifre_1, $hata_sifre1, $link);
bosmu_kontrol($sifre_2, $hata_sifre1, $link);
$hata_email = "e-posta";
bosmu_kontrol($kullanici_mail, $hata_email, $link);
$hata_guvenlik = "g�venlik kodu";
bosmu_kontrol($guvenlik, $hata_guvenlik, $link);
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($kullanici_adi);
guvenlik_filtresi($sifre_1);
guvenlik_filtresi($sifre_2);
guvenlik_filtresi($kullanici_mail);
guvenlik_filtresi($guvenlik);
//E-mail adresi do�ru girilmi� mi diye kontrol ediyoruz.
$geri_sayfa = "kayit_ol";
eposta_kontrol ($kullanici_mail, $geri_sayfa);
//�ki kullan�c� �ifresi e�le�iyor mu diye kontrol ediyoruz.
if ($sifre_1 == $sifre_2){
$sifre = $sifre_1;
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Girdi�iniz �ifreler birbirleriyle e�le�miyor.</font><br><br>';
echo '<a href="kayit_ol.php">Geri D�n</a></b></center>';
exit;
}
//G�venlik kodu do�ru girilmi� mi diye kontrol ediyoruz, e�er do�ru ise formumuza i�lemleri yapt�raca��z.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$kullanici_adi = mysql_real_escape_string($kullanici_adi);
$sifre = mysql_real_escape_string($sifre);
$kullanici_mail = mysql_real_escape_string($kullanici_mail);
$guvenlik = mysql_real_escape_string($guvenlik);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');
//Veritaban�ndan arama yap�yoruz, e�er girilen mail adresi veritaban�nda yer al�yorsa hata verdiriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$kullanici_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz e-posta adresi ba�ka bir �ye i�in kay�tl�. �ifrenizi unuttuysan�z l�tfen giri� sayfas�nda �ifremi unuttum ba�lant�s�n� kullan�n.</font><br><br>';
echo '<a href="kayit_ol.php">Geri D�n</a></b></center>';
exit;
}
//Veritaban�ndan arama yap�yoruz, e�er girilen kullan�c� ad� veritaban�nda yer al�yorsa hata verdiriyoruz.
$kullanici_kontrol = mysql_query("select * from uyeler where username='$kullanici_adi'", $baglanti_pointer);
$kullanici_kontrol_sonucu = mysql_num_rows($kullanici_kontrol);
if ($kullanici_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz kullan�c� ad� ba�ka bir �ye i�in kay�tl�. �ifrenizi unuttuysan�z l�tfen giri� sayfas�nda �ifremi unuttum ba�lant�s�n� kullan�n.</font><br><br>';
echo '<a href="kayit_ol.php">Geri D�n</a></b></center>';
exit;
}
//Kullan�c� �ifresini ve g�venlik kodunu veritaban�na g�venlik kaydedilmeleri i�in �ifreliyoruz.
$sifrelenmis_sifre = sha1($sifre);
$sifrelenmis_guvenlik = sha1($guvenlik);
//�imdi veritaban�m�za �yemizi kaydediyoruz.
$uye_ekle = mysql_query ("INSERT INTO uyeler (no, username, userpass, e_mail, name, surname, guvenlik_kodu, aktiflik) values ('', '$kullanici_adi', '$sifrelenmis_sifre', '$kullanici_mail', '', '', '$sifrelenmis_guvenlik', 'pasif')", $baglanti_pointer);
//Kay�t i�leminin sonucuna ba�l� olarak ekrana ��kt� yazd�r�yoruz.
if ($uye_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">�yelik i�leminiz tamamland�, l�tfen mail adresinizi kontrol ederek size gelen aktivasyon linkiyle �yeli�inizi aktif ediniz.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �yeli�iniz tamamlanamad�. L�tfen tekrar deneyin.</font><br><br>';
echo '<a href="kayit_ol.php">Geri D�n</a></b></center>';
exit;
}
//�yemize mail atarak aktivasyon kodunu kendisine bildiriyoruz.
//Mail atma ba�lang�c�:
//Mail'de ataca��m�z yeni �ifre linkini de hemen a�a��da haz�rl�yoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$aktivasyon_sayfasi = "http://".$_SERVER['HTTP_HOST'].str_replace("kayit_ol.php","aktivasyon.php",$sayfa)."?e_mail="."$kullanici_mail"."&guvenlik_kodu="."$guvenlik";

$kime = "$kullanici_mail";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Say�n '."$kullanici_adi".', �yeli�iniz i�leme al�nm��t�r. Son bir ad�m olarak �u adresten �yeli�iniz aktif etmeniz gerekmektedir:'.'<a href="'."$aktivasyon_sayfasi".'">'."$aktivasyon_sayfasi".'</a>'.'</p><p>'."$site_adi".' Y�netimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geli�tirici Tak�m�</b>n�n <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> �zerinden g�nderilmi�tir.</font><br><br>';
$son_konu = "�yelik ��lemi";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">�yeli�inizi son ad�m olarak aktifle�tirip tamamlaman�z i�in mail adresinize mail g�nderildi. L�tfen gelen kutunuzu kontrol edin ve mail i�eri�indeki y�nergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun olu�tu ve aktivasyon i�in mail g�nderilemedi (Bu sorun localhostta �al��t�r�lmadan ya da host ile ilgili olabilir l�tfen web alan� sa�lay�c�n�z ile ileti�ime ge�in).</font></center><br>';
}
//Mail atma sonu. 
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
//64. sat�rdaki if g�venlik kodunun kapat�c�s� a�a��dad�r.
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">G�venlik i�in girdi�iniz karakterler ile verilenler e�le�miyor.</font><br><br>';
echo '<a href="kayit_ol.php">Geri D�n</a></b></center>';
exit;
}
//Buras� son sat�r, en ba�taki if form girilmi�se sat�r�n�n son kapat�c� komutu a�a��dad�r. Buradan sonra form g�nderilmemi�se i�lemleri ba�layacakt�r.
}
else {
//E�ER FORM G�NDER�LMEM��SE O ZAMAN A�A�IDA BO� FORM G�STER�LECEKT�R.
?>
<br />
<center>
<font face="Verdana, Arial, Helvetica, sans-serif" size="5" color="#FF0000"><?php echo $site_adi; ?></font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666"><?php echo $site_aciklama; ?></font>
<br /><br /><br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#000066">Kay�t Formu</font></center><hr size="1" />
<form id="form1" method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">
  <table width="939" height="76" border="0" align="center">
    <tr>
      <td width="19">&nbsp;</td>
      <td width="718" valign="top">
	  <br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Kullan�c� Ad� : </font>
	<input type="text" name="username" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek almak i�in panelde kullanaca��n�z bir kullan�c� ad� belirleyin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">�ifre : </font>
	<input type="password" name="userpass1" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Belirledi�iniz kullan�c� ad� i�in �imdi de bir �ifre belirleyin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">�ifre (Tekrar) : </font>
	<input type="password" name="userpass2" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">�ifrenizi tekrar girin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta : </font>
	<input type="text" name="user_email" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Elektronik posta adresinizi girin, aktivasyon kodunuz bu e-posta adresine g�nderilecek.</font><br /><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="guvenlik_kodu.php"  /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">G�venlik Kodu : </font>
	<input type="text" name="guvenlik" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Kutucu�un �st�nde g�r�len karakterleri kutucu�a girin, g�venlik uygulamas�d�r.</font><br /><br />
	<br /><br /><center><input type="reset" value="Vazge�"> <input name="kayit_ol" type="submit" id="kayit_ol" value="Kay�t Ol">
	</center>
	</td>
      <td width="31">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
}
include ("footer.php");
?>
</body>
</html>
