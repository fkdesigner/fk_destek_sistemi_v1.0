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
<title><?php echo "$site_adi"." - "."YARDIM"; ?></title>
</head>
<body>
<p>
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
//Admin mail adresini çekiyoruz.
$admin_bilgi = mysql_query('SELECT e_mail FROM yoneticiler', $baglanti_pointer);
$admin_email = @mysql_result($admin_bilgi, 0);
//Eğer form gönderilmiş ise aşağıdaki işlemler uygulanacaktır.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri alıp değişkenlere kaydediyoruz.
$admin_email = $_POST['admin_email'];
$web_adress = $_POST['web_adress'];
$surum = $_POST['surum'];
$isim = $_POST['isim'];
$konu = $_POST['konu'];
$mesaj = $_POST['mesaj'];
$guvenlik = $_POST['guvenlik'];
//Eğer bilgiler boş girilmişse hata verdiriyoruz
$isim_hata = "adınız ve soyadınız";
$link = "admin.php?sayfa=yardim";
bosmu_kontrol($isim, $isim_hata, $link);
$konu_hata = "bize hangi konuda mesaj gönderiyorsunuz";
bosmu_kontrol($konu, $konu_hata, $link);
$mesaj_hata = "mesaj";
bosmu_kontrol($mesaj, $mesaj_hata, $link);
$guvenlik_hata = "güvenlik kodu";
bosmu_kontrol($guvenlik, $guvenlik_hata, $link);
//Burada tüm veriler güvenlik filtresinden geçiriliyor;
guvenlik_filtresi($isim);
guvenlik_filtresi($mesaj);
guvenlik_filtresi($konu);
guvenlik_filtresi($admin_email);
guvenlik_filtresi($web_adress);
guvenlik_filtresi($surum);
guvenlik_filtresi($guvenlik);
//Burada güvenlik sorusu eğer doğru cevaplanmışsa mail gidiyor, cevaplanmamışsa hata veriliyor;
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
$kime = 'iletisim@fkdesigner.com';
$basliklar = 'From:'."$admin_email"."\n";
$basliklar .= 'Reply-To:'."$admin_email"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";

$son_mesaj .= '
<b>Gönderenin Bilgileri:</b>
<font color="red">Gönderilen Web Adresi : </font>'."$web_adress".'
<br>
<font color="red">Gönderilen Destek Sürümü : </font>'."$surum".'
<br>
<font color="red">Gönderen Admin : </font>'."$isim".'
<br>
<font color="red">Gönderen Admin E-Posta Adresi : </font>'."$admin_email".'
<br>
<font color="red">Mesaj Konusu : </font>'."$konu".'
<br>
<font color="red">Mesajı : </font>';
$son_mesaj .= $mesaj;
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Bilişim Hizmetleri</b>nin FK İletişim Mail Sistemi ile gönderilmiştir.</font><br><br>';
$son_konu = "FK DESTEK/YARDIM";
if (mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="arial" size="4" color="green">Mesajınız iletildi, teşekkürler.</font></b></center><br>';
}
else {
echo '<br><center><font face="arial" size="3" color="red">Bir sorun oluştu ve mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.</font></center><br>';
}



}
//if kapatıcı komut.
}
else{
?>
  <b><font face="verdana" size="3" color="#FF0000">YARDIM</font></b></p>
<form id="form1" name="form1" method="post" action="">
  <label>
  <input type="hidden" name="admin_email" value="<?php echo $admin_email; ?>" />
  <input type="hidden" name="web_adress" value="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>" />
  <input type="hidden" name="surum" value="FK Destek Sistemi 1.0" />
  <br />
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Adınız ve Soyadınız :
  <input type="text" name="isim" />
  </strong></font></label>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Bize Hangi Konuda Mesaj Gönderiyorsunuz : 
        
  </font></strong>
    <select name="konu">
      <option>Soru</option>
      <option>Görüş</option>
      <option>Öneri</option>
      <option>Şikayet</option>
      <option>Hata/Açık Bildirimi</option>
    </select>
  </p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="../guvenlik_kodu.php" /></font></strong></p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Güvenlik Kodu :</font></strong> 
    <input type="text" name="guvenlik" />
  </p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mesajınız :</font> <br />
    </strong><br />
    <textarea name="mesaj" cols="50" rows="5"></textarea>
  </p>
  <p>
    <input name="vazgec" type="reset" id="vazgec" value="Vazgeç" />
    <input name="gonder" type="submit" id="gonder" value="Gönder" />
  </p>
</form>
<p>&nbsp;</p>
<?php
}
?>
</body>
</html>
