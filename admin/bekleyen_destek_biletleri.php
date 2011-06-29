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
<title><?php echo "$site_adi"." - "."Bekleyen Destek Biletleri"; ?></title>
</head>
<body>
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
echo '<b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Bekleyen Destek Biletleri:</font></b><br />';
//Veritabanına bağlanıyoruz ve veritabanımızı seçiyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//Önce veritabanı bağlantı fonksiyonumuzdan hariç file pointer oluşturup, mysql_query için kullanacağız.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritabanına bağlanılamıyor, lütfen veritabanı ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');	
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
$sayfalik_kayit = 10;
//Toplam kayıt bulunuyor.
$toplam = mysql_query("SELECT * FROM tickets where durum='Açık'", $baglanti_pointer);
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
$tickets = mysql_query("select * from tickets where durum='Açık' order by no limit $baslangic,$bitis", $baglanti_pointer);
//Eğer sayfamız 1'den büyükse o zaman geri linki oluşturup ekrana yazdırıyoruz. 
if($no>1){
echo '<a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=bekleyen&no='.($no-1).'>Geri</a> | ';
}
//For döngüsü ile diğer sayfaların linkini ekrana yazdırıyoruz.
//Eğer sayfa numaralarında eksik ya da fazla varsa (i+1) ile oynanacak.
for($i=0; $i<$toplam_sayfa; $i++){
	if($no == ($i+1)){
	echo ($i+1).' ';
	}
	else{
	echo' <a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=bekleyen&no='.($i+1).'>'.($i+1).'</a> ';
	}
}
//Eğer toplam sayfamız şu anda bulunduğumuz sayfanın bir fazlasından daha fazla ise o zaman ileri linki oluşturuyoruz.
if($toplam_sayfa>$no){
echo'| <a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=bekleyen&no='.($no+1).'>İleri</a>';
}
//VERİLERİ YAZDIRMA:
//Tablo oluşturuluyor.
echo '<center><table border="1">';
echo "<tr><td><font face='verdana' size='2' color='red'>&nbsp;Bilet No&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Bilet Sahibi&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Başlık&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Kategori&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>İşlemler&nbsp;</font></td></tr>";
while($ticket = mysql_fetch_array($tickets)){ 
	echo "<tr>
	<td><center><font face='verdana' size='1' color='black'><b>".$ticket['no']."</b></font></center></td>
	<td><center><font face='verdana' size='1' color='black'>".$ticket['reporter']."</center></font></td>
	<td><center><font face='verdana' size='1' color='black'>".$ticket['icerik']."</center></font></td>
	<td><center><font face='verdana' size='1' color='black'><b>".$ticket['kategori']."</b></center></font></td>
	<td>
	<center>
	<form id='form2' method='post' action='bilet_islem.php'>
	<input type='hidden' name='id' value='".$ticket['no']."'>
	<input type='submit' name='goster' value='Göster'><input type='submit' name='kapat' value='Bileti Kapat'><input type='submit' name='sil' value='Sil'>
	</form>
	</center>
	</td></tr>";
}
echo "</table></center><br>";


//Veritabanı bağlantımızı kapatıyoruz.
mysql_close ();
?>
</body>
</html>
