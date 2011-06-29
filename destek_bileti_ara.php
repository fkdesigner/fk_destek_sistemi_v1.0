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
<title><?php echo "$site_adi"." - "."DESTEK BİLETİ ARA"; ?></title>
</head>
<body>
<?php
//Oturumu başlatıyoruz.
@session_start();
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['kullanici'])){
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
?>
<b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek Bileti Ara:</font></b><br /><br />
<i><font face="verdana" size="1" color="#666666">Görmek istediğiniz destek biletinin numarasını yazarak bulabilirsiniz.</font></i>
<form id="form1" name="form1" method="post" action="">
  <input type="text" name="destek_bileti" />
  <input type="submit" name="ara" value="Ara" />
</form>
<?php
//EĞER FORM GÖNDERİLMİŞ İSE AŞAĞIDAKİ İŞLEMLER UYGULANACAKTIR.
if (isset($_POST["ara"])) {
//Formdan gelen bilgileri alıyoruz;
$bilet_no = $_POST['destek_bileti'];
//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($bilet_no);
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$bilet_no = mysql_real_escape_string($bilet_no);
//Numara kontrolü sadece sayılar mı değil mi diye;
if (eregi ("^[0-9]{1,}$", $bilet_no, $bilet_no)){
$bilet_no = $bilet_no[0];
}
else {
echo "<br><br><br><center><font face='verdana' size='2' color='red'><b>Lütfen sadece aramak istediğiniz destek biletinizin numarasını girin.</b></font></center>";
exit;
}
//Veritabanından o numarayı arayıp bileti çıkartıcağız.
//Listeleme için seçilen veriler.
$tickets = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
//Bilet varmı yok mu kontrol ediyoruz.
$tickets_kontrol_sonucu = mysql_num_rows($tickets);
if ($tickets_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Bilet bulunamadı.</font><br><br></b></center>';
exit;
}
//VERİLERİ YAZDIRMA:
//Tablo oluşturuluyor.
echo '<center><table border="1">';
while($ticket = mysql_fetch_array($tickets)){
echo "
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;No&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$ticket['no']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Kategori&nbsp;</b></font></td>
	<td><b>".$ticket['kategori']."</b></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Başlık&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'><b>".$ticket['icerik']."</b></font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Durumu&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$ticket['durum']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Mesaj&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'><i>".$ticket['ticket']."</i></font></td>
	</tr>
	<br>";  
	$bilet_no = $ticket['no'];
}
echo "</table></center>";

//Ticketa verilen cevap sayısı bulunup alta yazdırılacak.
@$cevaplar = mysql_query("select * from cevaplar where ticket_id='$bilet_no'", $baglanti_pointer);
$toplam_cevap = mysql_num_rows($cevaplar);
echo "<br><center><font face='verdana' size='2' color='black'>Destek biletiniz ile ilgili toplam ".$toplam_cevap." adet cevap bulunuyor. Ayrıntı için destek biletlerim sayfanıza bakabilirsiniz.</font></center>";

//43. satırdaki form gönderilme kodunun kapatma işareti aşağıdadır.
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
?>
</body>
</html>
