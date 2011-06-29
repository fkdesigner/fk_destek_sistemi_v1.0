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

Bu dosya FK Destek sisteminin bir par�as�d�r.

	FK Destek Sistemi �cretsizdir: bu sistemi Free Software Foundation 
	taraf�ndan yay�nlanm�� GNU Genel Kamu Lisans� 3 ya da sonras�n�n 
	�artlar� alt�nda da��tabilir ve/veya d�zenleyebilirsiniz.

	FK Destek Sistemi faydal� olmas� umuduyla da��t�lmaktad�r, 
	ancak hi� bir garantisi yoktur; herhangi belli bir amaca uygunlu�una 
	bile garanti veremez. Daha fazla detay i�in GNU Genel Kamu Lisans�na 
	bak�n.
	
	FK Destek Sistemi ile Genel Kamu Lisans�'n�n bir kopyas�n� da alm�� 
	olmal�s�n�z. Aksi takdirde, <http://www.gnu.org/licenses/> adresine bak�n.


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

//Bize gerekli olan di�er dosyalardaki bilgileri de kullanabilmek i�in onlar� da sayfaya dahil ediyoruz.
include ("../ayarlar.php");
include ("../fonksiyonlar.php");

//Hemen bir oturum ba�lat�l�yor.
@session_start();
//Admin giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['admin'])){
}
else{
echo '<br><center><b><font face="verdana" size="2" color="red">Giri� yapmad�n�z, giri� sayfas�na y�nlendiriliyorsunuz.</font><br><br>';
echo '<a href="index.php">E�er taray�c�n�z otomatik y�nlendirmeyi desteklemiyorsa buray� t�klay�n.</a></b></center>';
header("Location: index.php");
exit;
}
?>
<title><?php echo "$site_adi"." - "."Bilet ��lem Sayfas�"; ?></title>
</head>
<body>
<?php
//Formdan gelen bilgileri al�yoruz;
$bilet_no = $_POST['id'];
//Oturum de�i�keni olarak bilet no ve admin username'i kaydediyoruz.
$_SESSION["bilet_no"] = $bilet_no;
$bilet_no = $_SESSION["bilet_no"];
$admin = $_SESSION['admin'];
//Veri kontrol� sadece say�lar m� de�il mi diye;
if (eregi ("^[0-9]{1,}$", $bilet_no, $bilet_no)){
$bilet_no = $bilet_no[0];
}
else {
echo "<br><br><center><font face='verdana' size='2' color='red'><b>Bu �ekilde bir kullan�m s�z konusu olamaz.</b></font><br><br><a href='admin.php'>Admin Sayfas�na D�n.</a></center>";
exit;
}
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$bilet_no = mysql_real_escape_string($bilet_no);
//Veritaban�ndan arama yap�yoruz, e�er girilen �ye veritaban�nda yoksa hata verdiriyorz tam tersinde i�lem yap�yoruz.
$bilet_kontrol = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
$bilet_kontrol_sonucu = mysql_num_rows($bilet_kontrol);
if ($bilet_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Bilet bulunamad�.</font><br><br>';
echo '<a href="admin.php?sayfa=destek_biletleri">Geri D�n</a></b></center>';
exit;
}
else {


//E�ER G�STERE BASILMI� �SE A�A�IDAK� ��LEMLER YAPILACAKTIR.
if (isset($_POST["goster"])) {
//Listeleme i�in se�ilen bilet.
$tickets = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
//Geri Linki olu�turuyoruz:
echo '<center><a href="admin.php?sayfa=destek_biletleri">GER�</a></center>';
//Biletler tablosu olu�turuluyor.
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
	<td><font face='verdana' size='2' color='red'><b>&nbsp;G�nderen&nbsp;</b></font></td>
	<td><font face='verdana' size='2' color='black'>".$ticket['reporter']."</font></td>
	</tr>
	<tr>
	<td><font face='verdana' size='2' color='red'><b>&nbsp;Ba�l�k&nbsp;</b></font></td>
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
	<td><font face='verdana' size='2' color='red'><b>&nbsp;��lemler&nbsp;</b></font></td>
	<td><center><form method='post' action='bilet_islem.php'>
	<input type='hidden' name='id' value='".$ticket['no']."'>
	<input type='submit' name='cevapla' value='Cevapla'><input type='submit' name='kapat' value='Bileti Kapat'><input type='submit' name='sil' value='Sil'>
	</form></center></td>
	</tr><br>"; 
	$ticket['reporter'] = $_SESSION['reporter'];
	$reporter = $_SESSION['reporter'];
}
echo "</table></center>";
//Sayfalama i�in i�lemler:
//Sayfa numaras� al�n�yor no de�i�keni ile.
@$no = $_GET["no"];
//Sayfa numaras� yerine admin de olsa numaradan ba�ka bir �ey girmesi engelleniyor.
if (eregi ("^[0-9]{1,}$", $no, $no)){
$no = $no[0];
}
else {
$no = 1;
}
//E�er sayfa numaras� girilmemi�se otomatik olarak ilk sayfa a��l�yor.
if(empty($no)){
$no = 1;
}
//Her sayfada listelenecek veri say�s� giriliyor.
$sayfalik_kayit = 5;
//Toplam kay�t bulunuyor.
$toplam = mysql_query("SELECT * FROM cevaplar where ticket_id='$bilet_no'", $baglanti_pointer);
$toplam_kayit = mysql_num_rows($toplam);
//Toplam sayfa say�s� bulunuyor.
$toplam_sayfa = ceil($toplam_kayit/$sayfalik_kayit);
//E�er olmayan sayfa girilmi�se otomatik olarak ilk sayfa a��l�yor.
if($no>$toplam_sayfa){
$no=1;
}
//A��k olan sayfada listelenecek ilk kay�t numaras�.
$baslangic = (($no*$sayfalik_kayit)-$sayfalik_kayit);
//A��k olan sayfada listelenecek son kay�t numaras�.
$bitis = ($no * $sayfalik_kayit);
//Listeleme i�in se�ilen veriler.
$cevaplar = mysql_query("select * from cevaplar where ticket_id='$bilet_no' order by no desc limit $baslangic,$bitis", $baglanti_pointer);
//E�er sayfam�z 1'den b�y�kse o zaman geri linki olu�turup ekrana yazd�r�yoruz. 
if($no>1){
echo '<a href='.$PHP_SELF.'?no='.($no-1).'>Geri</a> | ';
}
//For d�ng�s� ile di�er sayfalar�n linkini ekrana yazd�r�yoruz.
//E�er sayfa numaralar�nda eksik ya da fazla varsa (i+1) ile oynanacak.
for($i=0; $i<$toplam_sayfa; $i++){
	if($no == ($i+1)){
	echo ($i+1).' ';
	}
	else{
	echo' <a href='.$PHP_SELF.'?no='.($i+1).'>'.($i+1).'</a> ';
	}
}
//E�er toplam sayfam�z �u anda bulundu�umuz sayfan�n bir fazlas�ndan daha fazla ise o zaman ileri linki olu�turuyoruz.
if($toplam_sayfa>$no){
echo'| <a href='.$PHP_SELF.'?no='.($no+1).'>�leri</a>';
}
//VER�LER� YAZDIRMA:
//Cevaplar tablosu olu�turuluyor.
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

//E�er goster butonuna bas�lm�� ise yap�lacak i�lemlerin sonu a�a��daki sat�r kapat�c� kod i�erir.
}


//E�ER CEVAPLAYA BASILMI� �SE A�A�IDAK� ��LEMLER YAPILACAKTIR.
if (isset($_POST["cevapla"])) {
	//Burada cevaplamak i�in form g�steriyoruz ve e�er form g�nderilmi�se a�a��daki i�lemi yap�yoruz.
	if (isset($_POST["gonder"])) {
	//Formdan gelen bilgileri al�yoruz;
	$mesaj = $_POST['mesaj'];
	//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
	$hata_mesaj = "mesaj";
	$link = "admin.php?sayfa=destek_biletleri&goster=bekleyen";
	bosmu_kontrol($mesaj, $hata_mesaj, $link);
	//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
	guvenlik_filtresi($mesaj);
	//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
	$mesaj = mysql_real_escape_string($mesaj);
	//�imdi veritaban�m�za cevab�m�z� kaydediyoruz.
	$cevap_ekle = mysql_query ("INSERT INTO cevaplar (no, ticket_id, icerik, cevaplayan, cevaplanma) values ('', '$bilet_no', '$mesaj', '$admin', '')", $baglanti_pointer);
	//Bilet durumunu kapal� yap�yoruz.
	$bilet_kapat = mysql_query ("update tickets set durum='Kapal�' where no='$bilet_no'", $baglanti_pointer);
	//Veritaban�ndan kullan�c�n�n mail adresini �ekiyoruz.
	$kullanici = mysql_query("select e_mail from uyeler where username='$reporter'", $baglanti_pointer);
	while(@$mail = mysql_fetch_array($kullanici)){
	$kullanici_maili = $mail['e_mail'];
	}
	//Kullan�c�ya mail at�yoruz.
	//�yemize mail atarak biletine cevap verildi�ini kendisine bildiriyoruz.
	//Mail atma ba�lang�c�:
	//Mail'de ataca��m�z yeni �ifre linkini de hemen a�a��da haz�rl�yoruz.
	$sayfa = $_SERVER['REQUEST_URI'];
	$bilet_sayfasi = "http://".$_SERVER['HTTP_HOST'].str_replace("bilet_islem.php","kullanici.php",$sayfa)."?sayfa=destek_biletlerim&goster=cevaplanmis";
	$kime = "$kullanici_mail";
	$basliklar = 'From:'."$site_adi"."\n";
	$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
	$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Say�n '."$kullanici_adi".', a�m�� oldu�unuz destek biletlerinden birine cevap verildi ve biletiniz kapat�ld�. L�tfen �u adresten kontrol edin:'.'<a href="'."$bilet_sayfasi".'">'."$bilet_sayfasi".'</a>'.'</p><p>'."$site_adi".' Y�netimi</font>';
	$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geli�tirici Tak�m�</b>nin <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> �zerinden g�nderilmi�tir.</font><br><br>';
	$son_konu = "Biletiniz Cevapland�";
	if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
	echo '<br><center><b><font face="verdana" size="2" color="green">�yeli�inizi son ad�m olarak aktifle�tirip tamamlaman�z i�in mail adresinize mail g�nderildi. L�tfen gelen kutunuzu kontrol edin ve mail i�eri�indeki y�nergeleri takip edin.</font><br><br>';
	}
	else {
	echo '<br><center><font face="verdana" size="2" color="red">Bir sorun olu�tu ve aktivasyon i�in mail g�nderilemedi (Bu sorun localhostta �al��t�r�lmadan ya da host ile ilgili olabilir l�tfen web alan� sa�lay�c�n�z ile ileti�ime ge�in).</font></center><br>';
	}
	//Mail atma sonu. 

	#Cevaplan�rsa bilet durumu kapal� olacak, kullan�c�ya mail gidecek, cevap veritaban�na kaydedilecek.
	//E�er cevap formu doldurulup g�ndere bas�lm��sa yap�lacak i�lemler a�a��da son buluyor ve bas�lmam��sa i�lemlerine ge�iliyor.
	}
	else {
	echo '<center>
	<form method="post" action="bilet_islem.php">
	<font face="verdana" size="2" color="red"><b>Cevap Mesaj� : </b></font><font face="verdana" size="2" color="gray"><i>Bilete verece�iniz cevab� yaz�n�z.</i></font>
    <br><textarea name="mesaj" cols="100" rows="10" id="mesaj"></textarea>
	<br><input type="hidden" name="cevapla" value="cevapla">
	<input type="hidden" name="id" value='.$bilet_no.'>
    <br><input name="temizle" type="reset" id="temizle" value="Temizle" />
    <input name="gonder" type="submit" id="gonder" value="G�nder" />
	</form></center>';
	}
//E�er cevapla butonuna bas�lm�� ise yap�lacak i�lemlerin sonu a�a��daki sat�r kapat�c� kod i�erir.
}


//E�ER A�A BASILMI� �SE A�A�IDAK� ��LEMLER YAPILACAKTIR.
if (isset($_POST["ac"])) {
//Bileti a��yoruz.
$bilet_ac = mysql_query ("update tickets set durum='A��k' where no='$bilet_no'", $baglanti_pointer);
//Sonu�
if ($bilet_ac){
echo "<br><center><font face='verdana' size='2' color='green'><b>Bilet a��ld�.</b></font><br><br><a href='admin.php?sayfa=destek_biletleri&goster=cevaplanmis'>Geri D�n</a></center>";
}
else {
echo "<br><center><font face='verdana' size='2' color='red'><b>Bir sorun olu�tu ve bilet a��lamad�.</b></font><br><br><a href='admin.php?sayfa=destek_biletleri&goster=cevaplanmis'>Geri D�n</a></center>";
}
//E�er a� butonuna bas�lm�� ise yap�lacak i�lemlerin sonu a�a��daki sat�r kapat�c� kod i�erir.
}


//E�ER KAPATA BASILMI� �SE A�A�IDAK� ��LEMLER YAPILACAKTIR.
if (isset($_POST["kapat"])) {
//Bileti kapat�yoruz.
$bilet_kapat = mysql_query ("update tickets set durum='Kapal�' where no='$bilet_no'", $baglanti_pointer);
//Sonu�
if ($bilet_kapat){
echo "<br><center><font face='verdana' size='2' color='green'><b>Bilet kapat�ld�.</b></font><br><br><a href='admin.php?sayfa=destek_biletleri&goster=bekleyen'>Geri D�n</a></center>";
}
else {
echo "<br><center><font face='verdana' size='2' color='red'><b>Bir sorun olu�tu ve bilet kapat�lamad�.</b></font><br><br><a href='admin.php?sayfa=destek_biletleri&goster=bekleyen'>Geri D�n</a></center>";
}
//E�er kapat butonuna bas�lm�� ise yap�lacak i�lemlerin sonu a�a��daki sat�r kapat�c� kod i�erir.
}


//E�ER S�LE BASILMI� �SE A�A�IDAK� ��LEMLER YAPILACAKTIR.
if (isset($_POST["sil"])) {
//�imdi veritaban�m�zdan biletimizi siliyoruz, e�er varsa bilete dair yaz��malar� da siliyoruz.
$bilet_sil = mysql_query ("DELETE FROM tickets WHERE no='$bilet_no'", $baglanti_pointer);
@$cevap_sil = mysql_query ("DELETE FROM cevaplar WHERE ticket_id='$bilet_no'", $baglanti_pointer);
//Kay�t i�leminin sonucuna ba�l� olarak ekrana ��kt� yazd�r�yoruz.
if ($bilet_sil){
echo '<br><center><b><font face="verdana" size="2" color="green">Bilet silindi.</font><br><br><a href="admin.php?sayfa=destek_biletleri">Geri D�n</a>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve bilet silinemedi. L�tfen tekrar deneyin.</font><br><br>';
echo '<a href="admin.php?sayfa=destek_biletleri">Geri D�n</a></b></center>';
exit;
}
//E�er sil butonuna bas�lm�� ise yap�lacak i�lemlerin sonu a�a��daki sat�r kapat�c� kod i�erir.
}
//Bilet bulunamad�n�n else'nin kapat�c� sat�r� a�a��da.
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
?>
</body>
</html>
