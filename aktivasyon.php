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
<title><?php echo "$site_adi"." - "."Aktivasyon"; ?></title>
</head>
<body>
<?php
//�ifremi unuttum sayfas�ndan gelen email ve g�venlik kodu bilgilerini get ile al�p de�i�kenlere kaydediyoruz.
@$e_mail = $_GET['e_mail'];
@$guvenlik_kodu = $_GET['guvenlik_kodu'];
//Email ve g�venlik kodu girilmeden sayfaya ula��lmas�n� engelliyoruz. E�er girilmi�se i�lemleri yapt�rt�yoruz.
if((!$e_mail) || (!$guvenlik_kodu)) {
echo '<center><br><b><font face="verdana" size="2" color="red">Bu �ekilde bir eri�im s�z konusu olamaz.<br> E�er aktivasyon kodunuz size ula�mad� ise l�tfen a�a��daki formdan yeni aktivasyon kodu isteyin ve hesab�n�z� aktif edin.</font></b><br></center><br><br><br><br>';
?>
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="red"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
	<form id="form1" method="post" action="tekrar_aktivasyon.php">
                      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">Aktivasyon ba�lant�n�z e-posta adresinize g�nderilecektir.</font><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta Adresiniz : </font>
                        <input type="text" name="email" size="20" maxlength = "25">
                        <br />
                        <br />
                             <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">A�a��daki g�venlik kodunu, alt�ndaki kutucu�a girin.</font>
                        <br />
                        <img src="guvenlik_kodu.php" /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">G�venlik Kodu : </font>
						<input type="text" name="guvenlik" size="20" maxlength = "25">
                      </div>
        <blockquote><blockquote><p align="right">
              <input type="submit" value="Aktivasyon Kodumu G�nder">
              </p>
            </blockquote>
          </blockquote>
	</form>	</td>
  </tr>
</table>
<?php
}
else {
//E-Mail ge�erli mi diye kontrol ediyoruz.
$email_hata ="aktivasyon";
eposta_kontrol($e_mail, $email_hata);
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
//Mail adresi kay�tl� de�ilse uyar�s�n� veriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz e-posta adresi kay�tl� de�il.</font><br><br>';
echo '<a href="kayit_ol.php">Kay�t Ol</a></b></center>';
exit;
}
else {
}
//G�venlik kodu do�ru de�ilse uyar�s�n� veriyoruz.
$guvenlik_kontrol = mysql_query("select * from uyeler where guvenlik_kodu='$guvenlik_kodu'", $baglanti_pointer);
$guvenlik_kontrol_sonucu = mysql_num_rows($guvenlik_kontrol);
if ($guvenlik_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz aktivasyon kodu yanl��. L�tfen mail adresinizdeki aktivasyon linkine t�klay�n. E�er aktivasyon mailini size ula�mad�ysa a�a��daki ba�lant�y� kullanarak yeni bir tane isteyin.</font><br><br>';
echo '<a href="aktivasyon.php">Geri D�n</a></b></center>';
exit;
}
else {
}
//Zaten aktifse uyar�s�n� veriyoruz.
$guvenlik_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and aktiflik='aktif'", $baglanti_pointer);
$guvenlik_kontrol_sonucu = mysql_num_rows($guvenlik_kontrol);
if ($guvenlik_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Hesab�n�z� daha �nceden zaten aktif etmi�siniz. Art�k aktifle�tirme i�lemi yapman�za gerek yok rahatl�klar kullan�c� giri�i yapabilirsiniz.</font><br><br>';
echo '<a href="index.php">Anasayfaya D�n</a></b></center>';
exit;
}
//Gelen bilgilerin veritaban�ndan do�rulu�unu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and guvenlik_kodu='$guvenlik_kodu' and aktiflik='pasif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
}
else {
while($kullanici_bilgi = mysql_fetch_array($bilgi_kontrol)) { 
$kullanici_username = $kullanici_bilgi['username'];
$kullanici_no = $kullanici_bilgi['no'];
}
}
//Kullan�c�y� veritaban�nda aktif konumuna getirip aktivasyon i�lemini yap�yoruz.
$kullanici_akivasyon = mysql_query ("update uyeler set aktiflik='aktif' where no='$kullanici_no'", $baglanti_pointer);
//��lemlerin sonucunda bir yaz� yazd�r�yoruz.
if ($kullanici_aktivasyon){
echo '<br><center><b><font face="verdana" size="2" color="green">Say�n '."$kullanici_username".', �yeli�iniz ba�ar�yla aktif edilmi�tir. Rahatl�kla kullan�c� giri�i yapabilirsiniz.<br><br>';
echo '<a href="index.php">Anasayfa</a></font></b></center>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �yeli�iniz aktif edilemedi l�tfen mailinize gelen ba�lant�yla yeniden deneyin, bu i�e yaramazsa yeniden aktivasyon maili istemek i�in a�a��daki ba�lant�y� izleyin:<br><br>';
echo '<a href="aktivasyon.php">Yeniden Aktivasyon</a></font></b></center>';
}
//Mysql ba�lant�m�z� kapat�yoruz.
mysql_close ();
//28. sat�rdaki if komutunun kapat�c� sat�r�d�r.
}
include ("footer.php");
?>
</body>
</html>
