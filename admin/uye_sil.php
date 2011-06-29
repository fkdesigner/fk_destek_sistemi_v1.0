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

//Bize gerekli olan diğer dosyalardaki bilgileri de kullanabilmek için onları da sayfaya dahil ediyoruz.
include ("../ayarlar.php");
include ("../fonksiyonlar.php");

//Hemen bir oturum başlatılıyor.
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
?>
<title><?php echo "$site_adi"." - "."Üye Sil"; ?></title>
</head>
<body>
<?php
//Formdan gelen bilgileri alıyoruz;
$silinecek_uye_no = $_POST['id'];
//Veri kontrolü sadece sayılar mı değil mi diye;
if (eregi ("^[0-9]{1,}$", $silinecek_uye_no, $silinecek_uye_no)){
$silinecek_uye_no = $silinecek_uye_no[0];
}
else {
echo "<br><br><center><font face='verdana' size='2' color='red'><b>Bu şekilde bir kullanım söz konusu olamaz.</b></font><br><br><a href='admin.php?sayfa=uyeler'>Üyeler Sayfasına Dön.</a></center>";
exit;
}
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$silinecek_uye_no = mysql_real_escape_string($silinecek_uye_no);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Veritabanından arama yapıyoruz, eğer girilen üye veritabanında yoksa hata verdiriyorz tam tersinde işlem yapıyoruz.
$uye_kontrol = mysql_query("select * from uyeler where no='$silinecek_uye_no'", $baglanti_pointer);
$uye_kontrol_sonucu = mysql_num_rows($uye_kontrol);
if ($uye_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Üye bulunamadı.</font><br><br>';
echo '<a href="admin.php?sayfa=uyeler">Geri Dön</a></b></center>';
exit;
}
else {
//Şimdi veritabanımızdan üyemizi siliyoruz.
$uye_sil = mysql_query ("DELETE FROM uyeler WHERE no='$silinecek_uye_no'", $baglanti_pointer);
//Kayıt işleminin sonucuna bağlı olarak ekrana çıktı yazdırıyoruz.
if ($uye_sil){
echo '<br><center><b><font face="verdana" size="2" color="green">Üye silindi.</font><br><br><a href="admin.php?sayfa=uyeler">Geri Dön</a>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve üye silinemedi. Lütfen tekrar deneyin.</font><br><br>';
echo '<a href="admin.php?sayfa=uyeler">Geri Dön</a></b></center>';
exit;
}
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
?>
</body>
</html>
