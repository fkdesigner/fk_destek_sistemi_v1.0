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
<title><?php echo "$site_adi"." - "."Bilgi Merkezi"; ?></title>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Admin giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['admin'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giri� yapmad�n�z, giri� sayfas�na y�nlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">E�er taray�c�n�z otomatik y�nlendirmeyi desteklemiyorsa buray� t�klay�n.</a></b></center>';
header("Location: index.php");
exit;
}
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');	
?>
<b><font face="verdana" size="3" color="#FF0000">B�LG� MERKEZ�</font></b>
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">�statistikler:</font></b><br />
-<font face="verdana" size="1" color="orange">Toplam �ye say�s�: </font><font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, toplam �ye say�s�n� bulmak i�in.
$uye_sayac = mysql_query("select * from uyeler", $baglanti_pointer);
$uye_sayac_sonucu = mysql_num_rows($uye_sayac);
echo $uye_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Toplam admin say�s�: </font><font face="verdana" size="1" color="red"><u>S�n�rl� s�r�mde desteklenmeyen �zellik</u></font><br />
-<font face="verdana" size="1" color="orange">Toplam cevaplanm�� destek bileti: </font><font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, toplam kapal� destek bileti say�s�n� bulmak i�in.
$kapali_bilet_sayac = mysql_query("select * from tickets where durum='kapal�'", $baglanti_pointer);
$kapali_bilet_sayac_sonucu = mysql_num_rows($kapali_bilet_sayac);
echo $kapali_bilet_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Cevaplanmay� bekleyen destek bileti: </font><font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, toplam a��k destek bileti say�s�n� bulmak i�in.
$acik_bilet_sayac = mysql_query("select * from tickets where durum='a��k'", $baglanti_pointer);
$acik_bilet_sayac_sonucu = mysql_num_rows($acik_bilet_sayac);
echo $acik_bilet_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Son �ye: </font>
<font face="verdana" size="1" color="black">
<?php
//Veritaban�ndan arama yap�yoruz, �yeler aras�ndan son �yeyi se�iyoruz.
$son_uye_sayac = mysql_query("select * from order by no desc limit 0, 1", $baglanti_pointer);
@$son_uye_sayac_sonucu = mysql_num_rows($son_uye_sayac);
echo $son_uye_sayac_sonucu;
if ($son_uye_sayac_sonuc == 0){
echo "Hen�z hi� kimse kaydolmad�.";
}
?></font><br />
<br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">S�r�m Bilgisi:</font></b><br />
-<font face="verdana" size="1" color="orange">S�r�m: </font><font face="verdana" size="1" color="red">FK Destek Sistemi 1.0 </font><br />
-<font face="verdana" size="1" color="orange">S�r�m Tipi: </font><u><font face="verdana" size="1" color="red">S�n�rl� s�r�m</font></u><br />
-<font face="verdana" size="1" color="orange">Duyuru: </font><font face="verdana" size="1" color="#666666">
<?php 
@$dosya = file("http://www.fkdesigner.com/destek_yonetim/duyuru.fk");
foreach ($dosya as $satir){
echo $satir;
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
?></font><br />
<br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek:</font></b><br />
-<font face="verdana" size="1" color="#666666">Kendimizi geli�tirmemize yard�mc� olmak i�in l�tfen destek tak�m�m�za geri bildirim yap�n ve sosyal medya ba�lant�lar�m�z� be�enin.</font><br />
-<font face="verdana" size="1" color="orange">Facebook Sayfam�z: <a href="http://www.facebook.com/fkdesigner">www.facebook.com/fkdesigner</a></font><br />
-<font face="verdana" size="1" color="orange">Twitter Sayfam�z: <a href="http://www.twitter.com/fkdesigner">www.twitter.com/fkdesigner</a></font><br />
-<font face="verdana" size="1" color="orange">Web Sayfam�z: <a href="http://www.fkdesigner.com">www.fkdesigner.com</a></font><br />
<br />&nbsp;<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Ffkdesigner&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:750px; height:35px;" allowTransparency="true"></iframe>
<br />&nbsp;<a href="http://www.twitter.com/fkdesigner"><img src="http://twitter-badges.s3.amazonaws.com/follow_us-a.png" alt="Follow fkdesigner on Twitter"/></a>
</body>
</html>
