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
<title><?php echo "$site_adi"." - "."Kayıt Ol"; ?></title>
</head>
<body>
<?php
//EĞER FORM GÖNDERİLMİŞ İSE AŞAĞIDAKİ İŞLEMLER UYGULANACAKTIR.
if (isset($_POST["guvenlik"])) {
//Formdan gelen bilgileri alıyoruz;
$kullanici_adi = $_POST['username'];
$sifre_1 = $_POST['userpass1'];
$sifre_2 = $_POST['userpass2'];
$kullanici_mail = $_POST['user_email'];
$guvenlik = $_POST['guvenlik'];
$guvenlik_kodu = $_SESSION["guvenlik_kodu"];
//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
$hata_kullanici_adi = "kullanıcı adı";
$link = "kayit_ol.php";
bosmu_kontrol($kullanici_adi, $hata_kullanici_adi, $link);
$hata_sifre1 = "şifre";
bosmu_kontrol($sifre1, $hata_sifre1, $link);
bosmu_kontrol($sifre2, $hata_sifre1, $link);
$hata_email = "e-posta";
bosmu_kontrol($kullanici_mail, $hata_email, $link);
$hata_guvenlik = "güvenlik kodu";
bosmu_kontrol($guvenlik, $hata_guvenlik, $link);
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($kullanici_adi);
guvenlik_filtresi($sifre_1);
guvenlik_filtresi($sifre_2);
guvenlik_filtresi($kullanici_mail);
guvenlik_filtresi($guvenlik);
//E-mail adresi doğru girilmiş mi diye kontrol ediyoruz.
$geri_sayfa = "kayit_ol";
eposta_kontrol ($kullanici_mail, $geri_sayfa);
//İki kullanıcı şifresi eşleşiyor mu diye kontrol ediyoruz.
if ($sifre_1 == $sifre_2){
$sifre = $sifre_1;
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Girdiğiniz şifreler birbirleriyle eşleşmiyor.</font><br><br>';
echo '<a href="kayit_ol.php">Geri Dön</a></b></center>';
exit;
}
//Güvenlik kodu doğru girilmiş mi diye kontrol ediyoruz, eğer doğru ise formumuza işlemleri yaptıracağız.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$kullanici_adi = mysql_real_escape_string($kullanici_adi);
$sifre = mysql_real_escape_string($sifre);
$kullanici_mail = mysql_real_escape_string($kullanici_mail);
$guvenlik = mysql_real_escape_string($guvenlik);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri Dön</a></center>');
//Veritabanından arama yapıyoruz, eğer girilen mail adresi veritabanında yer alıyorsa hata verdiriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$kullanici_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz e-posta adresi başka bir üye için kayıtlı. Şifrenizi unuttuysanız lütfen giriş sayfasında şifremi unuttum bağlantısını kullanın.</font><br><br>';
echo '<a href="kayit_ol.php">Geri Dön</a></b></center>';
exit;
}
//Veritabanından arama yapıyoruz, eğer girilen kullanıcı adı veritabanında yer alıyorsa hata verdiriyoruz.
$kullanici_kontrol = mysql_query("select * from uyeler where username='$kullanici_adi'", $baglanti_pointer);
$kullanici_kontrol_sonucu = mysql_num_rows($kullanici_kontrol);
if ($kullanici_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz kullanıcı adı başka bir üye için kayıtlı. Şifrenizi unuttuysanız lütfen giriş sayfasında şifremi unuttum bağlantısını kullanın.</font><br><br>';
echo '<a href="kayit_ol.php">Geri Dön</a></b></center>';
exit;
}
//Kullanıcı şifresini ve güvenlik kodunu veritabanına güvenlik kaydedilmeleri için şifreliyoruz.
$sifrelenmis_sifre = sha1($sifre);
$sifrelenmis_guvenlik = sha1($guvenlik);
//Şimdi veritabanımıza üyemizi kaydediyoruz.
$uye_ekle = mysql_query ("INSERT INTO uyeler (no, username, userpass, e_mail, name, surname, guvenlik_kodu, aktiflik) values ('', '$kullanici_adi', '$sifrelenmis_sifre', '$kullanici_mail', '', '', '$sifrelenmis_guvenlik', 'pasif')", $baglanti_pointer);
//Kayıt işleminin sonucuna bağlı olarak ekrana çıktı yazdırıyoruz.
if ($uye_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Üyelik işleminiz tamamlandı, lütfen mail adresinizi kontrol ederek size gelen aktivasyon linkiyle üyeliğinizi aktif ediniz.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve üyeliğiniz tamamlanamadı. Lütfen tekrar deneyin.</font><br><br>';
echo '<a href="kayit_ol.php">Geri Dön</a></b></center>';
exit;
}
//Üyemize mail atarak aktivasyon kodunu kendisine bildiriyoruz.
//Mail atma başlangıcı:
//Mail'de atacağımız yeni şifre linkini de hemen aşağıda hazırlıyoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$aktivasyon_sayfasi = "http://".$_SERVER['HTTP_HOST'].str_replace("kayit_ol.php","aktivasyon.php",$sayfa)."?e_mail="."$kullanici_mail"."&guvenlik_kodu="."$guvenlik";

$kime = "$kullanici_mail";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Sayın '."$kullanici_adi".', üyeliğiniz işleme alınmıştır. Son bir adım olarak şu adresten üyeliğiniz aktif etmeniz gerekmektedir:'.'<a href="'."$aktivasyon_sayfasi".'">'."$aktivasyon_sayfasi".'</a>'.'</p><p>'."$site_adi".' Yönetimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Bilişim Hizmetleri</b>nin <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> üzerinden gönderilmiştir.</font><br><br>';
$son_konu = "Üyelik İşlemi";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">Üyeliğinizi son adım olarak aktifleştirip tamamlamanız için mail adresinize mail gönderildi. Lütfen gelen kutunuzu kontrol edin ve mail içeriğindeki yönergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun oluştu ve aktivasyon için mail gönderilemedi (Bu sorun localhostta çalıştırılmadan ya da host ile ilgili olabilir lütfen web alanı sağlayıcınız ile iletişime geçin).</font></center><br>';
}
//Mail atma sonu. 
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
//64. satırdaki if güvenlik kodunun kapatıcısı aşağıdadır.
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Güvenlik için girdiğiniz karakterler ile verilenler eşleşmiyor.</font><br><br>';
echo '<a href="kayit_ol.php">Geri Dön</a></b></center>';
exit;
}
//Burası son satır, en baştaki if form girilmişse satırının son kapatıcı komutu aşağıdadır. Buradan sonra form gönderilmemişse işlemleri başlayacaktır.
}
else {
//EĞER FORM GÖNDERİLMEMİŞSE O ZAMAN AŞAĞIDA BOŞ FORM GÖSTERİLECEKTİR.
?>
<b><font face="verdana" size="3" color="#FF0000">YENİ KULLANICI EKLE</font></b>
<form id="form1" method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">
  <table width="939" height="76" border="0" align="center">
    <tr>
      <td width="19">&nbsp;</td>
      <td width="718" valign="top">
	  <br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Kullanıcı Adı : </font>
	<input type="text" name="username" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Destek almak için panelde kullanacağınız bir kullanıcı adı belirleyin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Şifre : </font>
	<input type="password" name="userpass1" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Belirlediğiniz kullanıcı adı için şimdi de bir şifre belirleyin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Şifre (Tekrar) : </font>
	<input type="password" name="userpass2" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Şifrenizi tekrar girin.</font><br /><br />
	<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta : </font>
	<input type="text" name="user_email" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Elektronik posta adresinizi girin, aktivasyon kodunuz bu e-posta adresine gönderilecek.</font><br /><br />
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../guvenlik_kodu.php"  /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Güvenlik Kodu : </font>
	<input type="text" name="guvenlik" size="25" maxlength = "25">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#666666">Kutucuğun üstünde görülen karakterleri kutucuğa girin, güvenlik uygulamasıdır.</font><br /><br />
	<br /><br /><center><input type="reset" value="Vazgeç"> <input type="submit" value="Kayıt Ol"></center>
	</td>
      <td width="31">&nbsp;</td>
    </tr>
  </table>
</form>
<?php
}
?>
<br />
</body>
</html>
