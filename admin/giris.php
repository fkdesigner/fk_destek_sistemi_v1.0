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
?>
<title><?php echo "$site_adi"." - "."$site_aciklama"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Formdan gelen değerleri alıp değişkenleri tanımlıyoruz.
$username = $_POST['username'];
$userpass = $_POST['userpass'];
//Formdan gelen verilerin boş olmaması için kontrol ediyoruz.
$username_hata = "kullanıcı adı";
$userpass_hata = "şifre";
$link = "index.php";
bosmu_kontrol($username, $username_hata, $link);
bosmu_kontrol($userpass, $userpass_hata, $link);
//Kullanıcı adı ve şifre boş değilse şimdi de html kodu ya da zararlı bir kod içermemesini sağlıyoruz.
guvenlik_filtresi($username);
guvenlik_filtresi($userpass);
//Veritabanı bağlantımızı yapıyoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
//Bu kez de verilerin sql kodu içermediklerine emin oluyoruz.
$username = mysql_real_escape_string($username);
$userpass = mysql_real_escape_string($userpass);
//Şifreyi sha1 formatına çeviriyoruz.
$userpass = sha1($userpass);
//Kullanıcı adı ve şifreyi veritabanından sorgulatıyoruz. 
$admin_sorgu = mysql_query("select * from yoneticiler where username='$username' and userpass='$userpass'"); 
//Kullanıcı sorgusunun sonucunu alıyoruz ve uygun işlemler yaptırıyoruz.
$admin_sorgu_sonucu = mysql_num_rows($admin_sorgu);
if ($admin_sorgu_sonucu == "0"){
echo '<br><center><b><font face="verdana" size="2" color="red">Üyelik bilgileri bulunamadı. Kullanıcı adı veya şifreyi yanlış girdiniz.</font><br><br>';
echo '<a href="index.php">Geri Dön</a></b></center>';
}
else {
while($admin_bilgi = mysql_fetch_array($admin_sorgu)) 
{ 
//Veritabanından kullanıcı seviyesini alıp, sessiona kaydediyoruz. 
$_SESSION['admin'] = $admin_bilgi['username']; 
//Admini, yönetim paneline yönlendiriyoruz.
header("Location: admin.php"); 
} 
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
include ("../footer.php");
?>
</body>
</html>
