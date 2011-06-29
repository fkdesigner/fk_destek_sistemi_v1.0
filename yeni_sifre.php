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
<title><?php echo "$site_adi"." - "."Yeni Şifre"; ?></title>
</head>
<body>
<?php
//Şifremi unuttum sayfasından gelen email ve güvenlik kodu bilgilerini get ile alıp değişkenlere kaydediyoruz.
@$e_mail = $_GET['e_mail'];
@$guvenlik_kodu = $_GET['guvenlik_kodu'];
@$guvenlik = $_GET['guvenlik_kodu'];
//Email ve güvenlik kodu girilmeden sayfaya ulaşılmasını engelliyoruz. Eğer girilmişse işlemleri yaptırtıyoruz.
if((!$e_mail) || (!$guvenlik_kodu)) {
echo '<center><br><b><font face="verdana" size="2" color="red">Buraya bu şekilde erişiminiz yasak.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri Dön</a></b></center>';
}
else {
//E-Mail geçerli mi diye kontrol ediyoruz.
$hata ="sifremi_unuttum";
eposta_kontrol($e_mail, $hata);
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
//Gelen bilgilerin veritabanından doğruluğunu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and guvenlik_kodu='$guvenlik_kodu' and aktiflik='aktif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdiğiniz e-posta adresi veya güvenlik kodu yanlış. Ya da üyeliğinizi aktifleştirmemişsiniz.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri Dön</a></b></center>';
}
else {
while($kullanici_bilgi = mysql_fetch_array($bilgi_kontrol)) { 
$kullanici_username = $kullanici_bilgi['username'];
$kullanici_id = $kullanici_bilgi['no'];
}

#FORM GÖSTERİLİYOR ve İŞLENİYOR.	
//Eğer form gönderilmiş ise.
if (isset($_POST["sifre2"])) {
//Formdan gelen verileri alıyoruz.
$sifre1 = $_POST['sifre1'];
$sifre2 = $_POST['sifre2'];
//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
$sifre_hata = "şifre";
$link = "http://".$_SERVER['HTTP_HOST']."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik";
bosmu_kontrol($sifre1, $sifre_hata, $link);
bosmu_kontrol($sifre2, $sifre_hata, $link);
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($sifre1);
guvenlik_filtresi($sifre2);
//Adminin girdiği iki kullanıcı şifresi eşleşiyor mu diye kontrol ediyoruz.
if ($sifre1 == $sifre2){
$sifre = $sifre1;
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Girdiğiniz şifreler birbirleriyle eşleşmiyor.<br><br>';
echo '<a href="yeni_sifre.php">Geri Dön</a></b></font></center>';
exit;
}
//Şifrelere sql kodları girilmediğinden emin oluyoruz.
$sifre = mysql_real_escape_string($sifre);
//Şifreyi şifreliyoruz.
$kullanici_password = sha1($sifre);
//Şifreyi veritabanına kaydediyoruz.
$sifre_guncelle = mysql_query ("update uyeler set userpass='$sifre' where no='$kullanici_id'", $baglanti_pointer);
//İşlemlerin sonucunda bir yazı yazdırıyoruz.
if ($sifre_guncelle){
echo '<br><center><b><font face="verdana" size="2" color="green">Şifreniz değiştirildi.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve şifre değiştirilemedi.<br><br>';
echo '<a href="sifremi_unuttum.php">Geri Dön</a></font></b></center>';
}
//Form gönderilmiş ise if şartının son satırı aşağıda kapatılıyor. Eğer gönderilmemişse aşağıda form gösterilecek. 
}
else {
?>
<br /><br /><br /><br /><br />
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FF0000"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
<form method="post" action="<?php echo $_SERVER["SCRIPT_NAME"]."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik"; ?>">
<div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Kullanıcı : <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="black"><?php echo $kullanici_username ?></font><br /><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Yeni Şifreniz : </font>
<input type="password" name="sifre1" size="20" maxlength = "25">
<br />
<br />
<font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">Yeni Şifreniz(Tekrar) : </font>
<input type="password" name="sifre2" size="20" maxlength = "25">
</div>
<blockquote><blockquote><p align="right">
<input type="submit" value="Gönder">
</p>
</blockquote>
</blockquote>
</form>
</td>
  </tr>
</table>
<?php
}
#FORM BİTİMİ.
}
//Mysql bağlantımızı kapatıyoruz.
mysql_close ();
#En baştaki ifin elsinin kapatılmasıdır.
}
include ("footer.php");
?>
</body>
</html>
