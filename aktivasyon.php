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
?>
<title><?php echo "$site_adi"." - "."Aktivasyon"; ?></title>
</head>
<body>
<?php
//Şifremi unuttum sayfasından gelen email ve güvenlik kodu bilgilerini get ile alıp değişkenlere kaydediyoruz.
@$e_mail = $_GET['e_mail'];
@$guvenlik_kodu = $_GET['guvenlik_kodu'];
//Email ve güvenlik kodu girilmeden sayfaya ulaşılmasını engelliyoruz. Eğer girilmişse işlemleri yaptırtıyoruz.
if((!$e_mail) || (!$guvenlik_kodu)) {
echo '<center><br><b><font face="verdana" size="2" color="red">Bu şekilde bir erişim söz konusu olamaz.<br> Eğer aktivasyon kodunuz size ulaşmadı ise lütfen aşağıdaki formdan yeni aktivasyon kodu isteyin ve hesabınızı aktif edin.</font></b><br></center><br><br><br><br>';
?>
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="red"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000066"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
	<form id="form1" method="post" action="tekrar_aktivasyon.php">
                      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">Aktivasyon bağlantınız e-posta adresinize gönderilecektir.</font><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta Adresiniz : </font>
                        <input type="text" name="email" size="20" maxlength = "25">
                        <br />
                        <br />
                             <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">Aşağıdaki güvenlik kodunu, altındaki kutucuğa girin.</font>
                        <br />
                        <img src="guvenlik_kodu.php" /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Güvenlik Kodu : </font>
						<input type="text" name="guvenlik" size="20" maxlength = "25">
                      </div>
        <blockquote><blockquote><p align="right">
              <input type="submit" value="Aktivasyon Kodumu Gönder">
              </p>
            </blockquote>
          </blockquote>
	</form>	</td>
  </tr>
</table>
<?php
}
else {
//E-Mail geçerli mi diye kontrol ediyoruz.
$email_hata ="aktivasyon";
eposta_kontrol($e_mail, $email_hata);
//Eğer boş değillerse hemen güvenlik kontrolünden geçiriyoruz.
guvenlik_filtresi($e_mail);
guvenlik_filtresi($guvenlik_kodu);
//Veritabanı bağlantımızı yapıyoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
//Veritabanı bağlantısının pointerını oluşturuyoruz.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Bu kez de verilerin sql kodu içermediklerine emin oluyoruz.
$e_mail = mysql_real_escape_string($e_mail);
$guvenlik_kodu = mysql_real_escape_string($guvenlik_kodu);
//Kontrol yapmadan önce güvenlik kodunu sha1 ile geri dönüşümsüz olarak şifreleyip kontrole gönderiyoruz.
$guvenlik_kodu = sha1($guvenlik_kodu);
//Mail adresi kayıtlı değilse uyarısını veriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz e-posta adresi kayıtlı değil.</font><br><br>';
echo '<a href="kayit_ol.php">Kayıt Ol</a></b></center>';
exit;
}
else {
}
//Güvenlik kodu doğru değilse uyarısını veriyoruz.
$guvenlik_kontrol = mysql_query("select * from uyeler where guvenlik_kodu='$guvenlik_kodu'", $baglanti_pointer);
$guvenlik_kontrol_sonucu = mysql_num_rows($guvenlik_kontrol);
if ($guvenlik_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz aktivasyon kodu yanlış. Lütfen mail adresinizdeki aktivasyon linkine tıklayın. Eğer aktivasyon mailini size ulaşmadıysa aşağıdaki bağlantıyı kullanarak yeni bir tane isteyin.</font><br><br>';
echo '<a href="aktivasyon.php">Geri Dön</a></b></center>';
exit;
}
else {
}
//Zaten aktifse uyarısını veriyoruz.
$guvenlik_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and aktiflik='aktif'", $baglanti_pointer);
$guvenlik_kontrol_sonucu = mysql_num_rows($guvenlik_kontrol);
if ($guvenlik_kontrol_sonucu == 0){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Hesabınızı daha önceden zaten aktif etmişsiniz. Artık aktifleştirme işlemi yapmanıza gerek yok rahatlıklar kullanıcı girişi yapabilirsiniz.</font><br><br>';
echo '<a href="index.php">Anasayfaya Dön</a></b></center>';
exit;
}
//Gelen bilgilerin veritabanından doğruluğunu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and guvenlik_kodu='$guvenlik_kodu' and aktiflik='pasif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
}
else {
while($kullanici_bilgi = mysql_fetch_array($bilgi_kontrol)) { 
$kullanici_username = $kullanici_bilgi['username'];
$kullanici_no = $kullanici_bilgi['no'];
}
}
//Kullanıcıyı veritabanında aktif konumuna getirip aktivasyon işlemini yapıyoruz.
$kullanici_akivasyon = mysql_query ("update uyeler set aktiflik='aktif' where no='$kullanici_no'", $baglanti_pointer);
//İşlemlerin sonucunda bir yazı yazdırıyoruz.
if ($kullanici_aktivasyon){
echo '<br><center><b><font face="verdana" size="2" color="green">Sayın '."$kullanici_username".', üyeliğiniz başarıyla aktif edilmiştir. Rahatlıkla kullanıcı girişi yapabilirsiniz.<br><br>';
echo '<a href="index.php">Anasayfa</a></font></b></center>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve üyeliğiniz aktif edilemedi lütfen mailinize gelen bağlantıyla yeniden deneyin, bu işe yaramazsa yeniden aktivasyon maili istemek için aşağıdaki bağlantıyı izleyin:<br><br>';
echo '<a href="aktivasyon.php">Yeniden Aktivasyon</a></font></b></center>';
}
//Mysql bağlantımızı kapatıyoruz.
mysql_close ();
//28. satırdaki if komutunun kapatıcı satırıdır.
}
include ("footer.php");
?>
</body>
</html>
