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
<title><?php echo "$site_adi"." - "."Destek Biletlerim"; ?></title>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Kullan�c� giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['kullanici'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giri� yapmad�n�z, giri� sayfas�na y�nlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">E�er taray�c�n�z otomatik y�nlendirmeyi desteklemiyorsa buray� t�klay�n.</a></b></center>';
header("Location: index.php");
exit;
}
$sayfa = $_SERVER['REQUEST_URI'];
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');	
//Veritaban�ndan arama yap�yoruz, toplam kapal� destek bileti say�s�n� bulmak i�in.
$kapali_bilet_sayac = mysql_query("select * from tickets where durum='kapal�'", $baglanti_pointer);
$kapali_bilet_sayac_sonucu = mysql_num_rows($kapali_bilet_sayac);
//Veritaban�ndan arama yap�yoruz, toplam a��k destek bileti say�s�n� bulmak i�in.
$acik_bilet_sayac = mysql_query("select * from tickets where durum='a��k'", $baglanti_pointer);
$acik_bilet_sayac_sonucu = mysql_num_rows($acik_bilet_sayac);
?>
<b><font face="verdana" size="3" color="#FF0000">DESTEK B�LETLER�M</font></b>
<br /><br />
<?php
//Kullan�c�n�n panelde gezinece�i sayfalar� ayarl�yoruz, b�ylece linkler sayesinde panele farkl� sayfalar y�klenecek
@$goster = $_GET['goster'];
switch ($_GET['goster']){
    case 'bekleyen':
    	include ("bekleyen_destek_biletlerim.php");
    	break;

    case 'cevaplanmis':
        include ("cevaplanmis_destek_biletlerim.php");
        break;

	default:
	?>
	<center><font face="verdana" size="2" color="#0033CC"><a href="<?php echo $sayfa.'&goster=bekleyen' ?>">Bekleyen Destek Biletlerim</a> (<?php echo $acik_bilet_sayac_sonucu; ?>) | <a href="<?php echo $sayfa.'&goster=cevaplanmis' ?>">Cevaplanm�� Destek Biletlerim</a> (<?php echo $kapali_bilet_sayac_sonucu; ?>)</font></center>
    <?php
	//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
	break;
}
?>
</body>
</html>
