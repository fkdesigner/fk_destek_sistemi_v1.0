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
<title><?php echo "$site_adi"." - "."Genel"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['kullanici'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}
//Kullanıcı adını belirtiyoruz:
$kullanici_adi = $_SESSION['kullanici'];
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri Dön</a></center>');	
?>
<b><font face="verdana" size="3" color="#FF0000">GENEL</font></b>
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Bilgileriniz:</font></b><br />
-<font face="verdana" size="1" color="orange">Kullanıcı adınız: </font><font face="verdana" size="1" color="black">
<?php
echo $kullanici_adi;
?></font><br />
-<font face="verdana" size="1" color="orange">Toplam gönderdiğiniz destek bileti sayısı: </font><font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, toplam üye sayısını bulmak için.
$ticket_sayac = mysql_query("select * from tickets where reporter='$kullanici_adi'", $baglanti_pointer);
@$ticket_sayac_sonucu = mysql_num_rows($ticket_sayac);
echo $ticket_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Beklemede olan destek biletleriniz: </font><font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, toplam üye sayısını bulmak için.
$ticket_sayac = mysql_query("select * from tickets where reporter='$kullanici_adi' and durum='açık'", $baglanti_pointer);
@$ticket_sayac_sonucu = mysql_num_rows($ticket_sayac);
echo $ticket_sayac_sonucu;
?></font><br />
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek:</font></b><br />
-<i><font face="verdana" size="1" color="#666666">Sevgili kullanıcı, bu destek sistemi FK Designer Developer Team tarafından özel olarak yapıldı. İş alanında kullanılması için professional olarak yapılmasına rağmen Türkiye'de bilişimin gelişmesine katkıda bulunmak politikasına sahip olan ekip, ücretsiz olan bu sınırlı sürümü açık kaynak koduyla yayınladı. Bizi sosyal medyada takip ederek, destekleyerek ve bu paneli kullanıp geri bildirim yaparak kendimizi, sistemlerimizi ve takipçilerimizi geliştirmemizde yardımcı olabilirsiniz. Teşekkürler.</font><br /></i>
<br />&nbsp;<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Ffkdesigner&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:750px; height:35px;" allowTransparency="true"></iframe>
<br />&nbsp;<a href="http://www.twitter.com/fkdesigner"><img src="http://twitter-badges.s3.amazonaws.com/follow_us-a.png" alt="Follow fkdesigner on Twitter"/></a>
</body>
</html>
