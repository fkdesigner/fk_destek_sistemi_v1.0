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
<title><?php echo "$site_adi"." - "."Yeni �ifre"; ?></title>
</head>
<body>
<?php
//�ifremi unuttum sayfas�ndan gelen email ve g�venlik kodu bilgilerini get ile al�p de�i�kenlere kaydediyoruz.
@$e_mail = $_GET['e_mail'];
@$guvenlik_kodu = $_GET['guvenlik_kodu'];
@$guvenlik = $_GET['guvenlik_kodu'];
//Email ve g�venlik kodu girilmeden sayfaya ula��lmas�n� engelliyoruz. E�er girilmi�se i�lemleri yapt�rt�yoruz.
if((!$e_mail) || (!$guvenlik_kodu)) {
echo '<center><br><b><font face="verdana" size="2" color="red">Buraya bu �ekilde eri�iminiz yasak.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri D�n</a></b></center>';
}
else {
//E-Mail ge�erli mi diye kontrol ediyoruz.
$hata ="sifremi_unuttum";
eposta_kontrol($e_mail, $hata);
//E�er bo� de�illerse hemen g�venlik kontrol�nden ge�iriyoruz.
guvenlik_filtresi($e_mail);
guvenlik_filtresi($guvenlik_kodu);
//Veritaban� ba�lant�m�z� yap�yoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
//Veritaban� ba�lant�s�n�n pointer�n� olu�turuyoruz.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Bu kez de verilerin sql kodu i�ermediklerine emin oluyoruz.
$e_mail = mysql_real_escape_string($e_mail);
$guvenlik_kodu = mysql_real_escape_string($guvenlik_kodu);
//Kontrol yapmadan �nce g�venlik kodunu sha1 ile geri d�n���ms�z olarak �ifreleyip kontrole g�nderiyoruz.
$guvenlik_kodu = sha1($guvenlik_kodu);
//Gelen bilgilerin veritaban�ndan do�rulu�unu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and guvenlik_kodu='$guvenlik_kodu' and aktiflik='aktif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz e-posta adresi veya g�venlik kodu yanl��. Ya da �yeli�inizi aktifle�tirmemi�siniz.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri D�n</a></b></center>';
}
else {
while($kullanici_bilgi = mysql_fetch_array($bilgi_kontrol)) { 
$kullanici_username = $kullanici_bilgi['username'];
$kullanici_id = $kullanici_bilgi['no'];
}

#FORM G�STER�L�YOR ve ��LEN�YOR.	
//E�er form g�nderilmi� ise.
if (isset($_POST["sifre2"])) {
//Formdan gelen verileri al�yoruz.
$sifre1 = $_POST['sifre1'];
$sifre2 = $_POST['sifre2'];
//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
$sifre_hata = "�ifre";
$link = "http://".$_SERVER['HTTP_HOST']."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik";
bosmu_kontrol($sifre1, $sifre_hata, $link);
bosmu_kontrol($sifre2, $sifre_hata, $link);
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($sifre1);
guvenlik_filtresi($sifre2);
//Adminin girdi�i iki kullan�c� �ifresi e�le�iyor mu diye kontrol ediyoruz.
if ($sifre1 == $sifre2){
$sifre = $sifre1;
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Girdi�iniz �ifreler birbirleriyle e�le�miyor.<br><br>';
echo '<a href="yeni_sifre.php">Geri D�n</a></b></font></center>';
exit;
}
//�ifrelere sql kodlar� girilmedi�inden emin oluyoruz.
$sifre = mysql_real_escape_string($sifre);
//�ifreyi �ifreliyoruz.
$kullanici_password = sha1($sifre);
//�ifreyi veritaban�na kaydediyoruz.
$sifre_guncelle = mysql_query ("update uyeler set userpass='$sifre' where no='$kullanici_id'", $baglanti_pointer);
//��lemlerin sonucunda bir yaz� yazd�r�yoruz.
if ($sifre_guncelle){
echo '<br><center><b><font face="verdana" size="2" color="green">�ifreniz de�i�tirildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �ifre de�i�tirilemedi.<br><br>';
echo '<a href="sifremi_unuttum.php">Geri D�n</a></font></b></center>';
}
//Form g�nderilmi� ise if �art�n�n son sat�r� a�a��da kapat�l�yor. E�er g�nderilmemi�se a�a��da form g�sterilecek. 
}
else {
?>
<br /><br /><br /><br /><br />
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FF0000"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik"; ?>">
<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Kullan�c� : <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="black"><?php echo $kullanici_username ?></font><br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Yeni �ifreniz : </font>
<input type="password" name="sifre1" size="20" maxlength = "25">
<br />
<br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Yeni �ifreniz(Tekrar) : </font>
<input type="password" name="sifre2" size="20" maxlength = "25">
</div>
<blockquote><blockquote><p align="right">
<input type="submit" value="G�nder">
</p>
</blockquote>
</blockquote>
</form>
</td>
  </tr>
</table>
<?php
}
#FORM B�T�M�.
}
//Mysql ba�lant�m�z� kapat�yoruz.
mysql_close ();
#En ba�taki ifin elsinin kapat�lmas�d�r.
}
include ("footer.php");
?>
</body>
</html>
