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
include ("ayarlar.php");
include ("fonksiyonlar.php");
//Hemen bir oturum başlatılıyor.
@session_start();
?>
<title><?php echo "$site_adi"." - "."Tekrar Aktivasyon"; ?></title>
</head>
<body>
<?php 
//Formdan gelen bilgileri alıyoruz;
$e_mail = $_POST['email'];
$guvenlik = $_POST['guvenlik'];
//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
$hata_email = "e-posta adresi";
$link = "aktivasyon.php";
bosmu_kontrol($e_mail, $hata_email, $link);
$hata_guvenlik = "güvenlik";
bosmu_kontrol($guvenlik, $hata_guvenlik, $link);
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($e_mail);
guvenlik_filtresi($guvenlik);
//E-mail adresi doğru girilmiş mi diye kontrol ediyoruz.
$email_hata = "aktivasyon";
eposta_kontrol ($e_mail, $email_hata);
//Güvenlik kodu doğru girilmiş mi diye kontrol ediyoruz, eğer doğru ise formumuza işlemleri yaptıracağız.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$e_mail = mysql_real_escape_string($e_mail);
$guvenlik = mysql_real_escape_string($guvenlik);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri Dön</a></center>');
//Veritabanından arama yapıyoruz, eğer girilen mail adresi veritabanında yer almıyorsa hata verdiriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz e-posta adresi kayıtlı değildir.</font><br><br>';
echo '<a href="kayit_ol.php">Kayıt Ol</a></b></center>';
exit;
}
else {
}
//Gelen bilgilerin veritabanından doğruluğunu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and aktiflik='pasif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Üyeliğinizi daha önce zaten aktifleştirmişsiniz. Tekrar aktivasyon işlemi yapmanıza gerek yok.</font><br><br>';
echo '<a href="index.php">Anasayfaya Dön</a></b></center>';
exit;
}
else {
}
//Kullanıcı şifresini ve güvenlik kodunu veritabanına güvenlik kaydedilmeleri için şifreliyoruz.
$sifrelenmis_guvenlik = sha1($guvenlik);
//Kullanıcıyı veritabanında aktif konumuna getirip aktivasyon işlemini yapıyoruz.
$guvenlik_guncelle = mysql_query ("update uyeler set guvenlik_kodu='$sifrelenmis_guvenlik' where e_mail='$e_mail'", $baglanti_pointer);
//İşlemlerin sonucunda bir yazı yazdırıyoruz.
if ($guvenlik_guncelle){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve üyeliğiniz aktif edilemedi lütfen mailinize gelen bağlantıyla yeniden deneyin, bu işe yaramazsa yeniden aktivasyon maili istemek için aşağıdaki bağlantıyı izleyin:<br><br>';
echo '<a href="aktivasyon.php">Yeniden Aktivasyon</a></font></b></center>';
}
//Üyemize mail atarak aktivasyon kodunu kendisine bildiriyoruz.
//Mail atma başlangıcı:
//Mail'de atacağımız yeni şifre linkini de hemen aşağıda hazırlıyoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$aktivasyon_sayfasi = "http://".$_SERVER['HTTP_HOST'].str_replace("tekrar_aktivasyon.php","aktivasyon.php",$sayfa)."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik";

$kime = "$e_mail";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Sayın '."$kullanici_adi".', tekrar aktivasyon isteğiniz üzerine bu maili almış bulunuyorsunuz. Şu bağlantıdan üyeliğinizi aktif edebilirsiniz :'.'<a href="'."$aktivasyon_sayfasi".'">'."$aktivasyon_sayfasi".'</a>'.'</p><p>'."$site_adi".' Yönetimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geliştirici Takımı</b>nın <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> üzerinden gönderilmiştir.</font><br><br>';
$son_konu = "Tekrar Aktivasyon İşlemi";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">Üyeliğinizi son adım olarak aktifleştirip tamamlamanız için mail adresinize mail gönderildi. Lütfen gelen kutunuzu kontrol edin ve mail içeriğindeki yönergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun oluştu ve aktivasyon için mail gönderilemedi (Bu sorun localhostta çalıştırılmadan ya da host ile ilgili olabilir lütfen web alanı sağlayıcınız ile iletişime geçin).</font></center><br>';
}
//Mail atma sonu. 
//Mysql bağlantımızı kapatıyoruz.
mysql_close ();
//40. satırdaki if güvenlik kodunun kapatıcısı aşağıdadır.
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Güvenlik için girdiğiniz karakterler ile verilenler eşleşmiyor.</font><br><br>';
echo '<a href="aktivasyon.php">Geri Dön</a></b></center>';
exit;
}
include ("footer.php");
?>
</body>
</html>

