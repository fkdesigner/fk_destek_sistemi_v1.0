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
<title><?php echo "$site_adi"." - "."YENİ DESTEK BİLETİ GÖNDER"; ?></title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	color: #FF0000;
	font-weight: bold;
}
.style3 {
	color: #666666;
	font-style: italic;
}
.style5 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #666666;
}
-->
</style>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['kullanici'])){
$kullanici = $_SESSION['kullanici'];
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}
//EĞER FORM GÖNDERİLMİŞ İSE AŞAĞIDAKİ İŞLEMLER UYGULANACAKTIR.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri alıyoruz;
$kategori = $_POST['kategori'];
$baslik = $_POST['baslik'];
$mesaj = $_POST['mesaj'];
//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
$hata_baslik = "başlık";
$link = "?sayfa=yeni_destek_bileti";
bosmu_kontrol($baslik, $hata_baslik, $link);
$hata_mesaj = "mesaj";
bosmu_kontrol($mesaj, $hata_mesaj, $link);
if ($kategori == "Seçiniz"){
echo "<br><center><b><font face='verdana' size='2' color='red'>Lütfen destek biletiniz için bir kategori belirtin.</font></b><br><br><a href='?sayfa=yeni_destek_bileti'>Geri dönmek için tıklayın.</a></center>";
}
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($baslik);
guvenlik_filtresi($kategori);
guvenlik_filtresi($mesaj);
//Kategorinin türüne göre renklendirme işlemi yapılıyor.
if ($kategori == "Soru"){
$kategori = '<font color="orange">Soru</font>';
}
if ($kategori == "Görüş"){
$kategori = '<font color="gray">Görüş</font>';
}
if ($kategori == "Öneri"){
$kategori = '<font color="green">Öneri</font>';
}
if ($kategori == "Şikayet"){
$kategori = '<font color="red">Şikayet</font>';
}
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$kategori = mysql_real_escape_string($kategori);
$baslik = mysql_real_escape_string($baslik);
$mesaj = mysql_real_escape_string($mesaj);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Şimdi veritabanımıza biletimizi kaydediyoruz.
$ticket_ekle = mysql_query ("INSERT INTO tickets (no, reporter, icerik, ticket, durum, kategori, gonderilme) values ('', '$kullanici', '$baslik', '$mesaj', 'Açık', '$kategori', '')", $baglanti_pointer);
//Kayıt işleminin sonucuna bağlı olarak ekrana çıktı yazdırıyoruz.
if ($ticket_ekle){
echo '<br><center><b><font face="verdana" size="2" color="green">Destek biletiniz gönderildi. En kısa zamanda yöneticiler destek biletinizi cevaplayacaktır.</font><br><br>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun oluştu ve destek bileti gönderilemedi. Lütfen tekrar deneyin.</font><br><br>';
echo mysql_errno()." kodu ve hata mesaji :".mysql_error();
echo '<a href="?sayfa=yeni_destek_bileti">Geri Dön</a></b></center>';
exit;
}
//31.satırdaki form if kodunun kapatıcı satırı aşağıdadır.
}
else{
?> <br /><br />
<span class="style5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Destek biletinizi göndermeden önce bilmelisiniz ki biletiniz diğer biletlerin arasında sıraya girecektir. Biletler zaman sıralamasına göre listelenmektedir doğal olarak eğer sizden önce başka biri destek bileti açmışsa önce o bilet cevaplanıp kapanacak daha sonra sizin biletinizle ilgilenilicektir. Lütfen gerçekten ihtiyacınız var ise destek bileti açın, sormak istedikleriniz, bildirmek istediğiniz görüşler ile şikayet ve öneriler için destek bileti kullanabilirsiniz. Destek biletinize yoğunluğa göre erken ya da geç cevap verilebilir lütfen bu konuda sabırlı olun ve destek biletinizi yöneticilere mesaj atarak sormak yerine destek bileti ara ve destek biletlerim fonksiyonlarıyla kontrol ediniz.</span>
<center>
<form id="form1" name="form1" method="post" action="">
  <p class="style1">
    <span class="style2">Kategori:</span><span class="style3"> Lütfen destek biletinizin ilgili olduğu kategoriyi aşağıdan seçiniz.</span></p>
  <p><span class="style5">
    <select name="kategori" id="kategori">
      <option value="Seçiniz">Seçiniz</option>
      <option value="Soru">Soru</option>
      <option value="Görüş">Görüş</option>
      <option value="Öneri">Öneri</option>
      <option value="Şikayet">Şikayet</option>
    </select>
  </span></p>
  <p class="style1"><span class="style2">Başlık:</span> <span class="style3">Lütfen destek biletiniz için aşağıdaki kutucuğa açıklayıcı kısa bir şeyler yazın.</span></p>
  <p>
    <input name="baslik" type="text" id="baslik" maxlength = "25" />
  </p>
  <p class="style1"><span class="style2">Mesaj:</span> <span class="style3">Destek biletinizde yöneticilere karşı düzgün bir üslupla, açık ve anlaşılır bir dille yazınız.</span></p>
  <p>
    <textarea name="mesaj" cols="100" rows="10" id="mesaj"></textarea>
  </p>
  <p></p>
  <p align="center">
    <input name="temizle" type="reset" id="temizle" value="Temizle" />
    <input name="gonder" type="submit" id="gonder" value="Gönder" />
  </p>
</form></center>
<?php
}
?>
</body>
</html>
