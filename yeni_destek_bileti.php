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
<title><?php echo "$site_adi"." - "."YEN� DESTEK B�LET� G�NDER"; ?></title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
.style3 {
	color: #666666;
	font-style: italic;
}
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #666666;
}
-->
</style>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Admin giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['kullanici'])){
$kullanici = $_SESSION['kullanici'];
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giri� yapmad�n�z, giri� sayfas�na y�nlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">E�er taray�c�n�z otomatik y�nlendirmeyi desteklemiyorsa buray� t�klay�n.</a></b></center>';
header("Location: index.php");
exit;
}
//E�ER FORM G�NDER�LM�� �SE A�A�IDAK� ��LEMLER UYGULANACAKTIR.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri al�yoruz;
$kategori = $_POST['kategori'];
$baslik = $_POST['baslik'];
$mesaj = $_POST['mesaj'];
//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
$hata_baslik = "ba�l�k";
$link = "?sayfa=yeni_destek_bileti";
bosmu_kontrol($baslik, $hata_baslik, $link);
$hata_mesaj = "mesaj";
bosmu_kontrol($mesaj, $hata_mesaj, $link);
if ($kategori == "Se�iniz"){
echo "<br><center><b><font face='verdana' size='2' color='red'>L�tfen destek biletiniz i�in bir kategori belirtin.</font></b><br><br><a href='?sayfa=yeni_destek_bileti'>Geri d�nmek i�in t�klay�n.</a></center>";
}
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($baslik);
guvenlik_filtresi($kategori);
guvenlik_filtresi($mesaj);
//Kategorinin t�r�ne g�re renklendirme i�lemi yap�l�yor.
if ($kategori == "Soru"){
$kategori = '<font color="orange">Soru</font>';
}
if ($kategori == "G�r��"){
$kategori = '<font color="gray">G�r��</font>';
}
if ($kategori == "�neri"){
$kategori = '<font color="green">�neri</font>';
}
if ($kategori == "�ikayet"){
$kategori = '<font color="red">�ikayet</font>';
}
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$kategori = mysql_real_escape_string($kategori);
$baslik = mysql_real_escape_string($baslik);
$mesaj = mysql_real_escape_string($mesaj);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//�imdi veritaban�m�za biletimizi kaydediyoruz.
$ticket_ekle = mysql_query ("INSERT INTO tickets (no, reporter, icerik, ticket, durum, kategori, gonderilme) values ('', '$kullanici', '$baslik', '$mesaj', 'A��k', '$kategori', '')", $baglanti_pointer);
//Kay�t i�leminin sonucuna ba�l� olarak ekrana ��kt� yazd�r�yoruz.
if ($ticket_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Destek biletiniz g�nderildi. En k�sa zamanda y�neticiler destek biletinizi cevaplayacakt�r.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve destek bileti g�nderilemedi. L�tfen tekrar deneyin.</font><br><br>';
echo mysql_errno()." kodu ve hata mesaji :".mysql_error();
echo '<a href="?sayfa=yeni_destek_bileti">Geri D�n</a></b></center>';
exit;
}
//31.sat�rdaki form if kodunun kapat�c� sat�r� a�a��dad�r.
}
else{
?> <br /><br />
<span class="style5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destek biletinizi g�ndermeden �nce bilmelisiniz ki biletiniz di�er biletlerin aras�nda s�raya girecektir. Biletler zaman s�ralamas�na g�re listelenmektedir do�al olarak e�er sizden �nce ba�ka biri destek bileti a�m��sa �nce o bilet cevaplan�p kapanacak daha sonra sizin biletinizle ilgilenilicektir. L�tfen ger�ekten ihtiyac�n�z var ise destek bileti a��n, sormak istedikleriniz, bildirmek istedi�iniz g�r��ler ile �ikayet ve �neriler i�in destek bileti kullanabilirsiniz. Destek biletinize yo�unlu�a g�re erken ya da ge� cevap verilebilir l�tfen bu konuda sab�rl� olun ve destek biletinizi y�neticilere mesaj atarak sormak yerine destek bileti ara ve destek biletlerim fonksiyonlar�yla kontrol ediniz.</span>
<center>
<form id="form1" name="form1" method="post" action="">
  <p class="style1">
    <span class="style2">Kategori:</span><span class="style3"> L�tfen destek biletinizin ilgili oldu�u kategoriyi a�a��dan se�iniz.</span></p>
  <p><span class="style5">
    <select name="kategori" id="kategori">
      <option value="Se�iniz">Se�iniz</option>
      <option value="Soru">Soru</option>
      <option value="G�r��">G�r��</option>
      <option value="�neri">�neri</option>
      <option value="�ikayet">�ikayet</option>
    </select>
  </span></p>
  <p class="style1"><span class="style2">Ba�l�k:</span> <span class="style3">L�tfen destek biletiniz i�in a�a��daki kutucu�a a��klay�c� k�sa bir �eyler yaz�n.</span></p>
  <p>
    <input name="baslik" type="text" id="baslik" maxlength = "25" />
  </p>
  <p class="style1"><span class="style2">Mesaj:</span> <span class="style3">Destek biletinizde y�neticilere kar�� d�zg�n bir �slupla, a��k ve anla��l�r bir dille yaz�n�z.</span></p>
  <p>
    <textarea name="mesaj" cols="100" rows="10" id="mesaj"></textarea>
  </p>
  <p></p>
  <p align="center">
    <input name="temizle" type="reset" id="temizle" value="Temizle" />
    <input name="gonder" type="submit" id="gonder" value="G�nder" />
  </p>
</form></center>
<?php
}
?>
</body>
</html>
