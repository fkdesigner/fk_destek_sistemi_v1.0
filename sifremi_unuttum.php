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
<title><?php echo "$site_adi"." - "."Şifremi Unuttum"; ?></title>
</head>
<body>
<?php
//EĞER FORM GÖNDERİLMİŞ İSE AŞAĞIDAKİ İŞLEMLER UYGULANACAKTIR.
if (isset($_POST['gonder'])) {
//Girilen değerleri formdan çekip değişkenlere kaydediyoruz.
$email = $_POST['email'];
$guvenlik = $_POST['guvenlik'];
//Formdan gelen verilerin boş olmaması için kontrol ediyoruz.
$email_hata = "e-posta adresi";
$guvenlik_hata = "guvenlik";
$link = "sifremi_unuttum.php";
bosmu_kontrol($email, $email_hata, $link);
bosmu_kontrol($guvenlik, $guvenlik_hata, $link);
//E-mail ve güvenlik kodu boş değilse şimdi de html kodu ya da zararlı bir kod içermemesini sağlıyoruz.
guvenlik_filtresi($email);
guvenlik_filtresi($guvenlik);
//E-Mail geçerli mi diye kontrol ediyoruz.
$hata ="sifremi_unuttum";
eposta_kontrol($email, $hata);
//Veritabanı bağlantımızı yapıyoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Bu kez de verilerin sql kodu içermediklerine emin oluyoruz.
$email = mysql_real_escape_string($email);
$guvenlik = mysql_real_escape_string($guvenlik);
//Şimdi güvenlik kodu doğru girilmiş mi diye bir kontrol yapıyoruz, doğru ise işlem yapılacak, değilse hata verilecek.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Kullanıcı adı ve şifreyi veritabanından sorgulatıyoruz. 
$email_sorgu = mysql_query("select * from uyeler where e_mail='$email' and aktiflik='aktif'", $baglanti_pointer);
//Kullanıcı sorgusunun sonucunu alıyoruz ve uygun işlemler yaptırıyoruz.
$email_sorgu_sonucu = mysql_num_rows($email_sorgu);
if ($email_sorgu_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz e-posta adresi kayıtlı değil ya da aktifleştirilmemiş.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri Dön</a></b></center>';
}
else {
//Veritabanından kullanıcı adı ve mail bilgilerini çekip değişkenlere kaydediyoruz.. 
while($kullanici_bilgi = mysql_fetch_array($email_sorgu)) { 
$kullanici_email = $kullanici_bilgi['e_mail'];
$kullanici_username = $kullanici_bilgi['username'];
}
//Girilen güvenlik kodu, şifrelenerek veritabanına kaydedilecek ve bir değişkene atılacak.
$guvenlik_kodu = sha1($guvenlik);

$guvenlik_kodu_guncelle = mysql_query ("update uyeler set guvenlik_kodu='$guvenlik_kodu' where e_mail='$kullanici_email'", $baglanti_pointer);
//Mail ile atılacak değişkenler şöyle: $kullanici_email ve $sifre;
//Kullanıcıya şifre değiştirebilmesi için yeni şifre sayfasına erişebilmesi için ona özel oluşturulmuş link mail ile atılacak.
//Mail atma başlangıcı:
//Mail'de atacağımız yeni şifre linkini de hemen aşağıda hazırlıyoruz.
$link = $_SERVER['REQUEST_URI'];
$yeni_sifre_linki = "http://".$_SERVER['HTTP_HOST'].str_replace("sifremi_unuttum.php","yeni_sifre.php",$link)."?e_mail="."$kullanici_email"."&guvenlik_kodu="."$guvenlik";

$kime = "$kullanici_email";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Sayın '."$kullanici_username".', şifrenizi unuttuğunuza ve yeni bir tane talep ettiğinize dair bir bildirim aldık. Kendinize şu adresten yeni bir şifre belirleyebilirsiniz:'.'<a href="'."$yeni_sifre_linki".'">'."$yeni_sifre_linki".'</a>'.'</p><p>Eğer böyle bir talepte bulunmadıysanız bu e-maili önemsemeyin ve mevcut şifrenizi kullanmaya devam edin. Teşekkürler.</p><p>'."$site_adi".' Yönetimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geliştirici Takımı</b>nın <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> üzerinden gönderilmiştir.</font><br><br>';
$son_konu = "Şifre Hatırlatma Talebiniz";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">Şifre değişikliği talebiniz için girdiğiniz mail adresine mail gönderildi. Lütfen gelen kutunuzu kontrol edin ve mail içeriğindeki yönergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun oluştu ve şifre değişikliği için mail gönderilemedi (Bu sorun localhostta çalıştırılmadan ya da host ile ilgili olabilir lütfen web alanı sağlayıcınız ile iletişime geçin).</font></center><br>';
//Mail atma sonu. 
}
}
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Verilen güvenlik kodu ile sizin girdiğiniz karakterler eşleşmiyor.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri Dön</a></b></center>';
}
//Veritabanı bağlantımızı sonlandırıyoruz.
mysql_close ();
//Burası son satır, en baştaki if form girilmişse satırının son kapatıcı komutu aşağıdadır. Buradan sonra form gönderilmemişse işlemleri başlayacaktır.
}
else {
//EĞER FORM GÖNDERİLMEMİŞSE O ZAMAN AŞAĞIDA BOŞ FORM GÖSTERİLECEKTİR.
?>
<br /><br /><br /><br /><br />
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FF0000"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
	<form id="form1" method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">
                      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">Şifreniz e-posta adresinize gönderilecektir.</font><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta Adresiniz : </font>
                        <input type="text" name="email" size="20" maxlength = "25">
                        <br />
                        <br />
                             <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">Aşağıdaki güvenlik kodunu, yanındaki kutucuğa girin.</font>
                        <br />
                        <img src="guvenlik_kodu.php" /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Güvenlik Kodu : </font>
						<input type="text" name="guvenlik" size="20" maxlength = "25">
                      </div>
        <blockquote><blockquote><p align="right">
              <input type="submit" name="gonder" value="Gönder">
              </p>
            </blockquote>
          </blockquote>
	</form>	</td>
  </tr>
</table>
<?php
}
include ("footer.php");
?>
</body>
</html>
