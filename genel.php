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
<title><?php echo "$site_adi"." - "."Genel"; ?></title>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Admin giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['kullanici'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giri� yapmad�n�z, giri� sayfas�na y�nlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">E�er taray�c�n�z otomatik y�nlendirmeyi desteklemiyorsa buray� t�klay�n.</a></b></center>';
header("Location: index.php");
exit;
}
//Kullan�c� ad�n� belirtiyoruz:
$kullanici_adi = $_SESSION['kullanici'];
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');	
?>
<b><font face="verdana" size="3" color="#FF0000">GENEL</font></b>
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Bilgileriniz:</font></b><br />
-<font face="verdana" size="1" color="orange">Kullan�c� ad�n�z: </font><font face="verdana" size="1" color="black">
<?php
echo $kullanici_adi;
?></font><br />
-<font face="verdana" size="1" color="orange">Toplam g�nderdi�iniz destek bileti say�s�: </font><font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, toplam �ye say�s�n� bulmak i�in.
$ticket_sayac = mysql_query("select * from tickets where reporter='$kullanici_adi'", $baglanti_pointer);
@$ticket_sayac_sonucu = mysql_num_rows($ticket_sayac);
echo $ticket_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Beklemede olan destek biletleriniz: </font><font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, toplam �ye say�s�n� bulmak i�in.
$ticket_sayac = mysql_query("select * from tickets where reporter='$kullanici_adi' and durum='a��k'", $baglanti_pointer);
@$ticket_sayac_sonucu = mysql_num_rows($ticket_sayac);
echo $ticket_sayac_sonucu;
?></font><br />
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek:</font></b><br />
-<i><font face="verdana" size="1" color="#666666">Sevgili kullan�c�, bu destek sistemi FK Designer Developer Team taraf�ndan �zel olarak yap�ld�. �� alan�nda kullan�lmas� i�in professional olarak yap�lmas�na ra�men T�rkiye'de bili�imin geli�mesine katk�da bulunmak politikas�na sahip olan ekip, �cretsiz olan bu s�n�rl� s�r�m� a��k kaynak koduyla yay�nlad�. Bizi sosyal medyada takip ederek, destekleyerek ve bu paneli kullan�p geri bildirim yaparak kendimizi, sistemlerimizi ve takip�ilerimizi geli�tirmemizde yard�mc� olabilirsiniz. Te�ekk�rler.</font><br /></i>
<br />&nbsp;<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Ffkdesigner&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:750px; height:35px;" allowTransparency="true"></iframe>
<br />&nbsp;<a href="http://www.twitter.com/fkdesigner"><img src="http://twitter-badges.s3.amazonaws.com/follow_us-a.png" alt="Follow fkdesigner on Twitter"/></a>
</body>
</html>
