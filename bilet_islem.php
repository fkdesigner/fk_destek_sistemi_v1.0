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
//Admin giriş yapmış mı diye kontrol ediyoruz, giriş yapılmamışsa giriş sayfasına yönlendiriyoruz.
if(isset($_SESSION['kullanici'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giriş yapmadınız, giriş sayfasına yönlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">Eğer tarayıcınız otomatik yönlendirmeyi desteklemiyorsa burayı tıklayın.</a></b></center>';
header("Location: index.php");
exit;
}
?>
<title><?php echo "$site_adi"." - "."Bilet İşlem Sayfası"; ?></title>
</head>
<body>
<?php
//Formdan gelen bilgileri alıyoruz;
$bilet_no = $_POST['id'];
//Oturum değişkeni olarak bilet no ve admin username'i kaydediyoruz.
$_SESSION["bilet_no"] = $bilet_no;
$bilet_no = $_SESSION["bilet_no"];
$kullanici = $_SESSION['kullanici'];
//Veri kontrolü sadece sayılar mı değil mi diye;
if (eregi ("^[0-9]{1,}$", $bilet_no, $bilet_no)){
$bilet_no = $bilet_no[0];
}
else {
echo "<br><br><center><font face='verdana' size='2' color='red'><b>Bu şekilde bir kullanım söz konusu olamaz.</b></font><br><br><a href='kullanici.php'>Kullanıcı Sayfasına Dön.</a></center>";
exit;
}
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
$bilet_no = mysql_real_escape_string($bilet_no);
//Veritabanından arama yapıyoruz, eğer girilen üye veritabanında yoksa hata verdiriyorz tam tersinde işlem yapıyoruz.
$bilet_kontrol = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
$bilet_kontrol_sonucu = mysql_num_rows($bilet_kontrol);
if ($bilet_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Bilet bulunamadı.</font><br><br>';
echo '<a href="kullanici.php?sayfa=destek_biletlerim">Geri Dön</a></b></center>';
exit;
}
else {


//EĞER GÖSTERE BASILMIŞ İSE AŞAĞIDAKİ İŞLEMLER YAPILACAKTIR.
if (isset($_POST["goster"])) {
//Listeleme için seçilen bilet.
$tickets = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
//Geri Linki oluşturuyoruz:
echo '<center><a href="kullanici.php?sayfa=destek_biletlerim">GERİ</a></center>';
//Biletler tablosu oluşturuluyor.
echo '<br><center><table border="1" width="500">';
while($ticket = mysql_fetch_array($tickets)){
	echo "
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;No&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$ticket['no']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Kategori&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='red'><b>".$ticket['kategori']."</b></font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Gönderen&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$ticket['reporter']."</font></td>
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
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;İşlemler&nbsp;</b></font></td>
	<td><center><form method='post' action='bilet_islem.php'>
	<input type='hidden' name='id' value='".$ticket['no']."'>
	<input type='submit' name='cevapla' value='Cevapla'><input type='submit' name='kapat' value='Bileti Kapat'>
	</form></center></td>
	</tr><br>"; 
	$ticket['reporter'] = $_SESSION['reporter'];
	$reporter = $_SESSION['reporter'];
}
echo "</table></center>";
//Sayfalama için işlemler:
//Sayfa numarası alınıyor no değişkeni ile.
@$no = $_GET["no"];
//Sayfa numarası yerine admin de olsa numaradan başka bir şey girmesi engelleniyor.
if (eregi ("^[0-9]{1,}$", $no, $no)){
$no = $no[0];
}
else {
$no = 1;
}
//Eğer sayfa numarası girilmemişse otomatik olarak ilk sayfa açılıyor.
if(empty($no)){
$no = 1;
}
//Her sayfada listelenecek veri sayısı giriliyor.
$sayfalik_kayit = 5;
//Toplam kayıt bulunuyor.
$toplam = mysql_query("SELECT * FROM cevaplar where ticket_id='$bilet_no'", $baglanti_pointer);
$toplam_kayit = mysql_num_rows($toplam);
//Toplam sayfa sayısı bulunuyor.
$toplam_sayfa = ceil($toplam_kayit/$sayfalik_kayit);
//Eğer olmayan sayfa girilmişse otomatik olarak ilk sayfa açılıyor.
if($no>$toplam_sayfa){
$no=1;
}
//Açık olan sayfada listelenecek ilk kayıt numarası.
$baslangic = (($no*$sayfalik_kayit)-$sayfalik_kayit);
//Açık olan sayfada listelenecek son kayıt numarası.
$bitis = ($no * $sayfalik_kayit);
//Listeleme için seçilen veriler.
$cevaplar = mysql_query("select * from cevaplar where ticket_id='$bilet_no' order by no desc limit $baslangic,$bitis", $baglanti_pointer);
//Eğer sayfamız 1'den büyükse o zaman geri linki oluşturup ekrana yazdırıyoruz. 
if($no>1){
echo '<a href='.$PHP_SELF.'?no='.($no-1).'>Geri</a> | ';
}
//For döngüsü ile diğer sayfaların linkini ekrana yazdırıyoruz.
//Eğer sayfa numaralarında eksik ya da fazla varsa (i+1) ile oynanacak.
for($i=0; $i<$toplam_sayfa; $i++){
	if($no == ($i+1)){
	echo ($i+1).' ';
	}
	else{
	echo' <a href='.$PHP_SELF.'?no='.($i+1).'>'.($i+1).'</a> ';
	}
}
//Eğer toplam sayfamız şu anda bulunduğumuz sayfanın bir fazlasından daha fazla ise o zaman ileri linki oluşturuyoruz.
if($toplam_sayfa>$no){
echo'| <a href='.$PHP_SELF.'?no='.($no+1).'>İleri</a>';
}
//VERİLERİ YAZDIRMA:
//Cevaplar tablosu oluşturuluyor.
echo '<br><center><table border="1" width="500">';
while(@$cevap = mysql_fetch_array($cevaplar)){
echo "
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;No&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$cevap['no']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Cevaplayan&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$cevap['cevaplayan']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Cevap&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'><i>".$cevap['icerik']."</i></font></td>
	</tr>"; 
}
echo "</table></center>";

//Eğer goster butonuna basılmış ise yapılacak işlemlerin sonu aşağıdaki satır kapatıcı kod içerir.
}


//EĞER CEVAPLAYA BASILMIŞ İSE AŞAĞIDAKİ İŞLEMLER YAPILACAKTIR.
if (isset($_POST["cevapla"])) {
	//Burada cevaplamak için form gösteriyoruz ve eğer form gönderilmişse aşağıdaki işlemi yapıyoruz.
	if (isset($_POST["gonder"])) {
	//Formdan gelen bilgileri alıyoruz;
	$mesaj = $_POST['mesaj'];
	//Verileri boş girilmemeleri için gerekli fonksiyon ile kontrol ediyoruz.
	$hata_mesaj = "mesaj";
	$link = "kullanici.php?sayfa=destek_biletlerim&goster=bekleyen";
	bosmu_kontrol($mesaj, $hata_mesaj, $link);
	//Verilerde html ya da herhangi bir zararlı kod bulunmaması için güvenlik fonksiyonumuzla kontrol ediyoruz.
	guvenlik_filtresi($mesaj);
	//Verileri kontrol ediyoruz tekrar, sql kodu içeriyorlarsa temizliyoruz.
	$mesaj = mysql_real_escape_string($mesaj);
	//Şimdi veritabanımıza cevabımızı kaydediyoruz.
	$cevap_ekle = mysql_query ("INSERT INTO cevaplar (no, ticket_id, icerik, cevaplayan, cevaplanma) values ('', '$bilet_no', '$mesaj', '$admin', '')", $baglanti_pointer);
	//Bilet durumunu kapalı yapıyoruz.
	$bilet_kapat = mysql_query ("update tickets set durum='Kapalı' where no='$bilet_no'", $baglanti_pointer);
	
	//Eğer cevap formu doldurulup göndere basılmışsa yapılacak işlemler aşağıda son buluyor ve basılmamışsa işlemlerine geçiliyor.
	}
	else {
	echo '<center>
	<form method="post" action="bilet_islem.php">
	<font face="verdana" size="2" color="red"><b>Cevap Mesajı : </b></font><font face="verdana" size="2" color="gray"><i>Bilete vereceğiniz cevabı yazınız.</i></font>
    <br><textarea name="mesaj" cols="100" rows="10" id="mesaj"></textarea>
	<br><input type="hidden" name="cevapla" value="cevapla">
	<input type="hidden" name="id" value='.$bilet_no.'>
    <br><input name="temizle" type="reset" id="temizle" value="Temizle" />
    <input name="gonder" type="submit" id="gonder" value="Gönder" />
	</form></center>';
	}
//Eğer cevapla butonuna basılmış ise yapılacak işlemlerin sonu aşağıdaki satır kapatıcı kod içerir.
}


//EĞER AÇA BASILMIŞ İSE AŞAĞIDAKİ İŞLEMLER YAPILACAKTIR.
if (isset($_POST["ac"])) {
//Bileti açıyoruz.
$bilet_ac = mysql_query ("update tickets set durum='Açık' where no='$bilet_no'", $baglanti_pointer);
//Sonuç
if ($bilet_ac){
echo "<br><center><font face='verdana' size='2' color='green'><b>Bilet açıldı.</b></font><br><br><a href='kullanici.php?sayfa=destek_biletlerim&goster=cevaplanmis'>Geri Dön</a></center>";
}
else {
echo "<br><center><font face='verdana' size='2' color='red'><b>Bir sorun oluştu ve bilet açılamadı.</b></font><br><br><a href='kullanici.php?sayfa=destek_biletlerim&goster=cevaplanmis'>Geri Dön</a></center>";
}
//Eğer aç butonuna basılmış ise yapılacak işlemlerin sonu aşağıdaki satır kapatıcı kod içerir.
}


//EĞER KAPATA BASILMIŞ İSE AŞAĞIDAKİ İŞLEMLER YAPILACAKTIR.
if (isset($_POST["kapat"])) {
//Bileti kapatıyoruz.
$bilet_kapat = mysql_query ("update tickets set durum='Kapalı' where no='$bilet_no'", $baglanti_pointer);
//Sonuç
if ($bilet_kapat){
echo "<br><center><font face='verdana' size='2' color='green'><b>Bilet kapatıldı.</b></font><br><br><a href='kullanici.php?sayfa=destek_biletlerim&goster=bekleyen'>Geri Dön</a></center>";
}
else {
echo "<br><center><font face='verdana' size='2' color='red'><b>Bir sorun oluştu ve bilet kapatılamadı.</b></font><br><br><a href='kullanici.php?sayfa=destek_biletlerim&goster=bekleyen'>Geri Dön</a></center>";
}
//Eğer kapat butonuna basılmış ise yapılacak işlemlerin sonu aşağıdaki satır kapatıcı kod içerir.
}


//Bilet bulunamadının else'nin kapatıcı satırı aşağıda.
}
//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
?>
</body>
</html>
