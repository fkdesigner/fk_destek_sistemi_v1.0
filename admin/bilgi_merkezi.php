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
<title><?php echo "$site_adi"." - "."Bilgi Merkezi"; ?></title>
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
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri Dön</a></center>');	
?>
<b><font face="verdana" size="3" color="#FF0000">BİLGİ MERKEZİ</font></b>
<br /><br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">İstatistikler:</font></b><br />
-<font face="verdana" size="1" color="orange">Toplam üye sayısı: </font><font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, toplam üye sayısını bulmak için.
$uye_sayac = mysql_query("select * from uyeler", $baglanti_pointer);
$uye_sayac_sonucu = mysql_num_rows($uye_sayac);
echo $uye_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Toplam admin sayısı: </font><font face="verdana" size="1" color="red"><u>Sınırlı sürümde desteklenmeyen özellik</u></font><br />
-<font face="verdana" size="1" color="orange">Toplam cevaplanmış destek bileti: </font><font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, toplam kapalı destek bileti sayısını bulmak için.
$kapali_bilet_sayac = mysql_query("select * from tickets where durum='kapalı'", $baglanti_pointer);
$kapali_bilet_sayac_sonucu = mysql_num_rows($kapali_bilet_sayac);
echo $kapali_bilet_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Cevaplanmayı bekleyen destek bileti: </font><font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, toplam açık destek bileti sayısını bulmak için.
$acik_bilet_sayac = mysql_query("select * from tickets where durum='açık'", $baglanti_pointer);
$acik_bilet_sayac_sonucu = mysql_num_rows($acik_bilet_sayac);
echo $acik_bilet_sayac_sonucu;
?></font><br />
-<font face="verdana" size="1" color="orange">Son üye: </font>
<font face="verdana" size="1" color="black">
<?php
//Veritabanından arama yapıyoruz, üyeler arasından son üyeyi seçiyoruz.
$son_uye_sayac = mysql_query("select * from order by no desc limit 0, 1", $baglanti_pointer);
@$son_uye_sayac_sonucu = mysql_num_rows($son_uye_sayac);
echo $son_uye_sayac_sonucu;
if ($son_uye_sayac_sonuc == 0){
echo "Henüz hiç kimse kaydolmadı.";
}
?></font><br />
<br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Sürüm Bilgisi:</font></b><br />
-<font face="verdana" size="1" color="orange">Sürüm: </font><font face="verdana" size="1" color="red">FK Destek Sistemi 1.0 </font><br />
-<font face="verdana" size="1" color="orange">Sürüm Tipi: </font><u><font face="verdana" size="1" color="red">Sınırlı sürüm</font></u><br />
-<font face="verdana" size="1" color="orange">Duyuru: </font><font face="verdana" size="1" color="#666666">
<?php 
@$dosya = file("http://www.fkdesigner.com/destek_yonetim/duyuru.fk");
foreach ($dosya as $satir){
echo $satir;
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
?></font><br />
<br /><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek:</font></b><br />
-<font face="verdana" size="1" color="#666666">Kendimizi geliştirmemize yardımcı olmak için lütfen destek takımımıza geri bildirim yapın ve sosyal medya bağlantılarımızı beğenin.</font><br />
-<font face="verdana" size="1" color="orange">Facebook Sayfamız: <a href="http://www.facebook.com/fkdesigner">www.facebook.com/fkdesigner</a></font><br />
-<font face="verdana" size="1" color="orange">Twitter Sayfamız: <a href="http://www.twitter.com/fkdesigner">www.twitter.com/fkdesigner</a></font><br />
-<font face="verdana" size="1" color="orange">Web Sayfamız: <a href="http://www.fkdesigner.com">www.fkdesigner.com</a></font><br />
<br />&nbsp;<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Ffkdesigner&amp;send=false&amp;layout=standard&amp;width=450&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:750px; height:35px;" allowTransparency="true"></iframe>
<br />&nbsp;<a href="http://www.twitter.com/fkdesigner"><img src="http://twitter-badges.s3.amazonaws.com/follow_us-a.png" alt="Follow fkdesigner on Twitter"/></a>
</body>
</html>
