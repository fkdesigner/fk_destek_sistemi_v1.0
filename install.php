<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9" />
<title>FK DESTEK SİSTEMİ - KURULUM SAYFASI</title>
</head>
<body>
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

//Güvenlik kodu için oturum başlatılır.
@session_start();

//FONKSİYONLARIMIZ:
//bosmu_kontrol: Formun boş gönderilmemesi için yazdığım fonksiyon.
function bosmu_kontrol($deger){	
	if (empty($deger)){	
	echo "<br><center><b><font face='verdana' size='2' color='red'>Lütfen tüm alanları doldurun.</font></b>";	
	echo "<br><br><a href='install.php'>Geri dönmek için tıklayın.</a></center><br>";	
	exit;	
	}
return;
}
//guvenlik_filtresi: Kötü amaçlı ziyaretçiler için forma yazılan html kodlarını temizler ve kod yazımında kullanılan temel karakterleri siler.
function guvenlik_filtresi($deger){	
$deger = strip_tags ($deger);	
$deger = eregi_replace ("<", "", $deger);	
$deger = eregi_replace (">", "", $deger);	
$deger = eregi_replace ("/", "", $deger);	
$deger = eregi_replace ("=", "", $deger);	
$deger = eregi_replace ("'", "", $deger);	
$deger = eregi_replace ('"', "", $deger);	
$deger = eregi_replace ("{", "", $deger);	
$deger = eregi_replace ("}", "", $deger);	
$deger = eregi_replace ("&", "", $deger);	
$deger = eregi_replace ("%", "", $deger);	
$deger = eregi_replace ("$", "", $deger);
$deger = eregi_replace (";", "", $deger);
return $deger;
}
//eposta_kontrol: E-Posta adresi doğru bir biçimde yazılmış mı diye kontrol eder, doğru ise verilen değişkene atar.
function eposta_kontrol($deger){	
	if (eregi("^.+@.+\..+$", $deger, $deger )){
	}
	else {
	echo '<center><br><font face="arial" size="3" color="red">Lütfen e-mail adresinizi doğru bir biçimde giriniz.</font><br><br>';
	echo '<a href="install.php">Geri Dön</a></center>';
	exit;
	}
	list ($deger) = $deger;
return $deger;
}
//db_baglan: Veritabanı bağlantısını yapar.
function db_baglan($db_server, $db_username, $db_userpass, $db_name){
@mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri Dön</a></center>');
mysql_select_db("$db_name") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanı seçilemiyor lütfen veritabanı adı kısmına doğru bilgi girdiğinizden emin olunuz.</font></b><br><br><a href="install.php">Geri Dön</a></center>');
return;
}

//EĞER FORM GÖNDERİLMİŞ İSE AŞAĞIDAKİ İŞLEMLER UYGULANACAKTIR.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri alıyoruz;
$site_adi = $_POST['site_adi'];
$site_aciklama = $_POST['site_aciklama'];
$admin_username = $_POST['admin_username'];
$admin_pass1 = $_POST['admin_pass1'];
$admin_pass2 = $_POST['admin_pass2'];
$admin_email = $_POST['admin_email'];
$db_name = $_POST['db_name'];
$db_username = $_POST['db_username'];
$db_userpass = $_POST['db_userpass'];
$db_server = $_POST['db_server'];
$guvenlik = $_POST['guvenlik'];
//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
bosmu_kontrol($site_adi);
bosmu_kontrol($site_aciklama);
bosmu_kontrol($admin_username);
bosmu_kontrol($admin_pass1);
bosmu_kontrol($admin_pass2);
bosmu_kontrol($admin_email);
bosmu_kontrol($db_name);
bosmu_kontrol($db_username);
bosmu_kontrol($db_userpass);
bosmu_kontrol($db_server);
bosmu_kontrol($guvenlik);
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($site_adi);
guvenlik_filtresi($site_aciklama);
guvenlik_filtresi($admin_username);
guvenlik_filtresi($admin_pass1);
guvenlik_filtresi($admin_pass2);
guvenlik_filtresi($admin_email);
guvenlik_filtresi($db_name);
guvenlik_filtresi($db_username);
guvenlik_filtresi($db_userpass);
guvenlik_filtresi($db_server);
guvenlik_filtresi($guvenlik);
//Admin e-mail adresi doğru girilmiş mi diye kontrol ediyoruz.
eposta_kontrol ($admin_email);
//Adminin girdiği iki kullanıcı şifresi eşleşiyor mu diye kontrol ediyoruz.
if ($admin_pass1 == $admin_pass2){
$admin_pass = $admin_pass1;
}
else {
echo '<center><br><b><font face="arial" size="3" color="red">Admin hesabı için girdiğiniz şifreler birbirleriyle eşleşmiyor.</font><br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}
//Güvenlik kodu doğru girilmiş mi diye kontrol ediyoruz, eğer doğru ise formumuza işlemleri yaptıracağız.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$site_adi = mysql_real_escape_string($site_adi);
$site_aciklama = mysql_real_escape_string($site_aciklama);
$admin_username = mysql_real_escape_string($admin_username);
$admin_pass = mysql_real_escape_string($admin_pass);
$admin_email = mysql_real_escape_string($admin_email);
$db_name = mysql_real_escape_string($db_name);
$db_username = mysql_real_escape_string($db_username);
$db_userpass = mysql_real_escape_string($db_userpass);
$db_server = mysql_real_escape_string($db_server);
$guvenlik = mysql_real_escape_string($guvenlik);
//Veritabanı ve site ile ilgili verileri bir üst dizinde ayarlar.php dosyasına kaydediyoruz.
$dosyaismi = "ayarlar.php";
$dosyaac = fopen($dosyaismi, "w") or die ("Ayarlar.php açılamadı.");
$yazilacak = "<?php
"."$"."site_adi = ".'"'."$site_adi".'"'.";
"."$"."site_aciklama = ".'"'."$site_aciklama".'"'.";
"."$"."db_name = ".'"'."$db_name".'"'.";
"."$"."db_username = ".'"'."$db_username".'"'.";
"."$"."db_userpass = ".'"'."$db_userpass".'"'.";
"."$"."db_server = ".'"'."$db_server".'"'.";
?>";
if (fwrite($dosyaac, $yazilacak)){
echo '<br><center><b><font face="verdana" size="2" color="green">Bilgiler kaydedildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Bilgiler kaydedilemedi, lütfen daha sonra deneyin.</font><br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}
//Kayıt bittiği zaman bir üst dizindeki ayarlar.php dosyasını kapatıyoruz.
fclose ($dosyaac);
//Veritabanında uyeler, yoneticiler ve tickets tablolarını yaratıyoruz.
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="install.php">Geri Dön</a></center>');

$uyeler_ekle = mysql_query ("CREATE TABLE `uyeler` ( 
  `no` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `userpass` varchar(250) NOT NULL, 
  `e_mail` varchar(50) NOT NULL, 
  `name` varchar(50) NOT NULL, 
  `surname` varchar(50) NOT NULL,
  `guvenlik_kodu` varchar(250) NOT NULL, 
  `aktiflik` varchar(20) default 'pasif', 
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);
$yoneticiler_ekle = mysql_query ("CREATE TABLE `yoneticiler` ( 
  `no` int(11) NOT NULL auto_increment,
  `username` varchar(25) NOT NULL,
  `userpass` varchar(250) NOT NULL, 
  `e_mail` varchar(50) NOT NULL,
  `guvenlik_kodu` varchar(250) NOT NULL,  
  `name` varchar(50) NOT NULL, 
  `surname` varchar(50) NOT NULL, 
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);
$tickets_ekle = mysql_query ("CREATE TABLE `tickets` ( 
  `no` int(11) NOT NULL auto_increment,
  `reporter` varchar(25) NOT NULL,
  `icerik` varchar(25) NOT NULL, 
  `ticket` text NOT NULL,
  `durum` varchar(20) default 'açık', 
  `kategori` varchar(50) NOT NULL, 
  `gonderilme` varchar(50) NOT NULL,
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);

$cevaplar_ekle = mysql_query ("CREATE TABLE `cevaplar` ( 
  `no` int(11) NOT NULL auto_increment,
  `ticket_id` int(11) NOT NULL,
  `icerik` text NOT NULL, 
  `cevaplayan` varchar(20) NOT NULL, 
  `cevaplanma` varchar(50) NOT NULL,
  PRIMARY KEY  (`no`) 
) ENGINE=MyISAM;
", $baglanti_pointer);

if ($uyeler_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yaratıldı(%35).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnasında bir sorun oluştu ve kurulum dosyası gerekli tablolardan birini oluşturamadı. Lütfen kurulum için bütün adımları en baştan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}

if ($yoneticiler_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yaratıldı(%70).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnasında bir sorun oluştu ve kurulum dosyası gerekli tablolardan birini oluşturamadı. Lütfen kurulum için bütün adımları en baştan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}

if ($tickets_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">-Gerekli tablo yaratıldı(%100).</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnasında bir sorun oluştu ve kurulum dosyası gerekli tablolardan birini oluşturamadı. Lütfen kurulum için bütün adımları en baştan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}

if ($cevaplar_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Gerekli tabloların hepsi oluşturuldu.</font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum esnasında bir sorun oluştu ve kurulum dosyası gerekli tablolardan birini oluşturamadı. Lütfen kurulum için bütün adımları en baştan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}

//Admin kullanıcı bilgilerini veritabanında yoneticiler tablosuna kaydediyoruz.
//Önce admin şifresini sha1 ile şifreliyoruz ve veritabanına böyle kaydedilmesini sağlıyoruz.
$admin_password = sha1($admin_pass);
$admin_ekle = mysql_query ("INSERT INTO yoneticiler (no, username, userpass, e_mail, guvenlik_kodu, name, surname) values ('', '$admin_username', '$admin_password', '$admin_email', '', '', '')", $baglanti_pointer);

if ($admin_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Admin kullanıcı bilgileriniz kaydedildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Kurulum esnasında bir sorun oluştu ve kurulum dosyası admin kullanıcısını oluşturamadı. Lütfen kurulum için bütün adımları en baştan takip edin.</font>' . mysql_error() . '<br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}
//Admin bilgilerini, web site bilgilerini admin kullanıcısının mail hesabına mail olarak atıyoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$site_adresi = "http://".$_SERVER['HTTP_HOST'].str_replace("install.php","",$sayfa);

$kime = "$admin_email";
$basliklar = 'From:'."FK Destek Sistemi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<b>Destek Sitenizin Bilgileri:</b><br><font color="red">Admin Kullanıcıadı : </font>'."$admin_username".'<br><font color="red">E-Posta Adresi : </font>'."$admin_email".'<br><font color="red">Site Adı : </font>'."$site_adi".'<br><font color="red">Site Açıklaması : </font>'."$site_aciklama".'<br><font color="red">Site Adresi : </font><a href="'."$site_adiresi".'">'."$site_adresi";
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geliştirici Takımı</b>nın <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> üzerinden gönderilmiştir.</font><br><br>';
$son_konu = "FK Destek Sistemi Kuruldu";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">Kurulum hakkında mail adresinize bilgi maili gönderildi.</font><br><br>';
}
else {
echo '<br><center><font face="arial" size="3" color="red">Bir sorun oluştu ve bilgilendirme maili gönderilemedi (Bu sorunu önemsemeyebilirsiniz, problem kurulumun localhostta çalıştırılıyor olmasından ya da hostunuzdan kaynaklanıyor olabilir.).</font></center><br>';
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
//install dizinini siliyoruz.
$otosil = unlink ("install.php");
if ($otosil){
echo '<br><center><b><font face="verdana" size="2" color="green">Kurulum dosyası kurulumu tamamladı ve güvenliğiniz için kendi kendini sildi. Kurulum tamamlandı. </font><br><br>';
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Kurulum dosyası kendi kendini silmeyi denediyse de çeşitli sebeplerden ötürü başarılı olamadı. Lütfen, kurulumu tamamen düzgün bir şekilde bitirdiğinize eminseniz web alanınızdan install.php dosyasını GÜVENLİĞİNİZ İÇİN silin, artık ihtiyacınız olmayacak. </font><br><br>';
}
//Eğer güvenlik sorusu yanlış girilmişse hatayı burada verdiriyoruz.
}
else {
echo '<br><center><b><font face="arial" size="3" color="red">Güvenlik için girdiğiniz veri ile resimdekiler eşleşmiyor.</font><br><br>';
echo '<a href="install.php">Geri Dön</a></b></center>';
exit;
}
//Burası son satır, en baştaki if form girilmişse satırının son kapatıcı komutu aşağıdadır. Buradan sonra form gönderilmemişse işlemleri başlayacaktır.
}
//EĞER FORM GÖNDERİLMEMİŞSE O ZAMAN AŞAĞIDA BOŞ FORM GÖSTERİLECEKTİR.
else { 
?>
<br />
<center><font face="arial" size"5" color="black"><b>FK DESTEK SİSTEMİ - KURULUM SAYFASI</b></font></center>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">SİTE BİLGİLERİ</font>
<form action="<?php echo $_SERVER["SCRIPT_NAME"] ?>" method="post">
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Destek Sitesinin Adı : </font>
<input type="text" name="site_adi" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek vereceğiniz sitenin adı, kullanıcılarınız siteyi bu isimle görecektir. <i>Örnek: "1ST Müşteri Destek"</i></font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Destek Sitesinin Açıklaması : </font>
<input type="text" name="site_aciklama" size="25" maxlength = "50">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek vereceğiniz sitede ismin hemen altında belirecektir. Destek sloganınız. <i>Örnek: "En kısa sürede hizmet, daha kısa sürede destek..."</i></font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">ADMİN BİLGİLERİ</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullanıcı Adı : </font>
<input type="text" name="admin_username" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek yönetim paneline erişmekte kullanacağınız admin hesabı için gireceğiniz kullanıcıya ait kullanıcı adı belirleyin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullanıcı Şifresi : </font>
<input type="password" name="admin_pass1" size="25" maxlength = "15">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek yönetim paneline erişmekte kullanacağınız admin hesabı için gireceğiniz kullanıcıya ait şifre belirleyin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin Kullanıcı Şifresi (Tekrar) : </font>
<input type="password" name="admin_pass2" size="25" maxlength = "15">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Admin hesabınız için belirlediğiniz şifreyi tekrar buraya girin.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Admin E-Posta Adresi : </font>
<input type="text" name="admin_email" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Elektronik posta adresinizi girin. Lütfen geçerli bir adres girin. Örnek: <i>"mail@example.com"</i></font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">MYSQL VERİTABANI BİLGİLERİ</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritabanı Adı : </font>
<input type="text" name="db_name" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi için bir mysql veritabanı oluşturun ve buraya veritabanı adını yazın.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritabanı Kullanıcı Adı : </font>
<input type="text" name="db_username" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi için seçtiğiniz mysql veritabanına ait kullanıcı adını buraya yazın.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritabanı Kullanıcı Şifresi : </font>
<input type="password" name="db_userpass" size="25" maxlength = "30">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi için seçtiğiniz mysql veritabanına ait kullanıcı şifresini buraya yazın.</font>
<br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Veritabanı Sunucu Adresi : </font>
<input type="text" name="db_server" size="25" maxlength = "30" value="localhost">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek sisteminin kurulabilmesi için seçtiğiniz mysql veritabanının sunucu adresi, eğer bilmiyorsanız değiştirmeyin.</font>
<hr size="1" />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="red">GÜVENLİK TESTİ</font>
<br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Güvenlik Kodu : </font> <br /><img src="guvenlik_kodu.php" />
<br /><input type="text" name="guvenlik" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Bütün bu işlemlerin gerçekten sizin tarafınızdan yapıldığını onaylamak için lütfen resimdeki numara ve harfleri alttaki boş kutucuğa yazın, <b><u>harflerin küçük olduklarına dikkat edin</u></b>.</font>
<br><br><input type="reset" value="TEMİZLE"> <input name="gonder" type="submit" id="gonder" value="GÖNDER">
</form>
<?php
}
include ("footer.php");
?>
</body>
</html>
