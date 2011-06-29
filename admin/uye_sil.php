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
<title><?php echo "$site_adi"." - "."�ye Sil"; ?></title>
</head>
<body>
<?php
//Formdan gelen bilgileri al�yoruz;
$silinecek_uye_no = $_POST['id'];
//Veri kontrol� sadece say�lar m� de�il mi diye;
if (eregi ("^[0-9]{1,}$", $silinecek_uye_no, $silinecek_uye_no)){
$silinecek_uye_no = $silinecek_uye_no[0];
}
else {
echo "<br><br><center><font face='verdana' size='2' color='red'><b>Bu �ekilde bir kullan�m s�z konusu olamaz.</b></font><br><br><a href='admin.php?sayfa=uyeler'>�yeler Sayfas�na D�n.</a></center>";
exit;
}
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$silinecek_uye_no = mysql_real_escape_string($silinecek_uye_no);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Veritaban�ndan arama yap�yoruz, e�er girilen �ye veritaban�nda yoksa hata verdiriyorz tam tersinde i�lem yap�yoruz.
$uye_kontrol = mysql_query("select * from uyeler where no='$silinecek_uye_no'", $baglanti_pointer);
$uye_kontrol_sonucu = mysql_num_rows($uye_kontrol);
if ($uye_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">�ye bulunamad�.</font><br><br>';
echo '<a href="admin.php?sayfa=uyeler">Geri D�n</a></b></center>';
exit;
}
else {
//�imdi veritaban�m�zdan �yemizi siliyoruz.
$uye_sil = mysql_query ("DELETE FROM uyeler WHERE no='$silinecek_uye_no'", $baglanti_pointer);
//Kay�t i�leminin sonucuna ba�l� olarak ekrana ��kt� yazd�r�yoruz.
if ($uye_sil){
echo '<br><center><b><font face="verdana" size="2" color="green">�ye silindi.</font><br><br><a href="admin.php?sayfa=uyeler">Geri D�n</a>';
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �ye silinemedi. L�tfen tekrar deneyin.</font><br><br>';
echo '<a href="admin.php?sayfa=uyeler">Geri D�n</a></b></center>';
exit;
}
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
?>
</body>
</html>
