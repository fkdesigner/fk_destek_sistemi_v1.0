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

Bu dosya FK Destek sisteminin bir parçasıdır.

	FK Destek Sistemi ücretsizdir: bu sistemi Free Software Foundation 
	tarafından yayınlanmış GNU Genel Kamu Lisansı 3 ya da sonrasının 
	şartları altında dağıtabilir ve/veya düzenleyebilirsiniz.

	FK Destek Sistemi faydalı olması umuduyla dağıtılmaktadır, 
	ancak hiç bir garantisi yoktur; herhangi belli bir amaca uygunluğuna 
	bile garanti veremez. Daha fazla detay için GNU Genel Kamu Lisansına 
	bakın.
	
	FK Destek Sistemi ile Genel Kamu Lisansı'nın bir kopyasını da almış 
	olmalısınız. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bakın.


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
<title><?php echo "$site_adi"." - "."Destek Biletleri"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['admin'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}
$sayfa = $_SERVER['REQUEST_URI'];
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri Dön</a></center>');	
//Veritabanından arama yapıyoruz, toplam kapalı destek bileti sayısını bulmak için.
$kapali_bilet_sayac = mysql_query("select * from tickets where durum='kapalı'", $baglanti_pointer);
$kapali_bilet_sayac_sonucu = mysql_num_rows($kapali_bilet_sayac);
//Veritabanından arama yapıyoruz, toplam açık destek bileti sayısını bulmak için.
$acik_bilet_sayac = mysql_query("select * from tickets where durum='açık'", $baglanti_pointer);
$acik_bilet_sayac_sonucu = mysql_num_rows($acik_bilet_sayac);
?>
<b><font face="verdana" size="3" color="#FF0000">DESTEK BİLETLERİ</font></b>
<br /><br />
<?php
//Adminin panelde gezineceği sayfaları ayarlıyoruz, böylece linkler sayesinde panele farklı sayfalar yüklenecek
@$goster = $_GET['goster'];
switch ($_GET['goster']){
    case 'bekleyen':
    	include ("bekleyen_destek_biletleri.php");
    	break;

    case 'cevaplanmis':
        include ("cevaplanmis_destek_biletleri.php");
        break;

	default:
	?>
	<center><font face="verdana" size="2" color="#0033CC"><a href="<?php echo $sayfa.'&goster=bekleyen' ?>">Bekleyen Destek Biletleri</a> (<?php echo $acik_bilet_sayac_sonucu; ?>) | <a href="<?php echo $sayfa.'&goster=cevaplanmis' ?>">Cevaplanmış Destek Biletleri</a> (<?php echo $kapali_bilet_sayac_sonucu; ?>)</font></center>
    <?php
	//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
	break;
}
?>
</body>
</html>
