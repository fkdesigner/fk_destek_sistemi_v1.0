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
include ("ayarlar.php");
include ("fonksiyonlar.php");
//Hemen bir oturum ba�lat�l�yor.
@session_start();
?>
<title><?php echo "$site_adi"." - "."Tekrar Aktivasyon"; ?></title>
</head>
<body>
<?php 
//Formdan gelen bilgileri al�yoruz;
$e_mail = $_POST['email'];
$guvenlik = $_POST['guvenlik'];
//Verileri bo� girilmemeleri i�in gerekli fonksiyon ile kontrol ediyoruz.
$hata_email = "e-posta adresi";
$link = "aktivasyon.php";
bosmu_kontrol($e_mail, $hata_email, $link);
$hata_guvenlik = "g�venlik";
bosmu_kontrol($guvenlik, $hata_guvenlik, $link);
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($e_mail);
guvenlik_filtresi($guvenlik);
//E-mail adresi do�ru girilmi� mi diye kontrol ediyoruz.
$email_hata = "aktivasyon";
eposta_kontrol ($e_mail, $email_hata);
//G�venlik kodu do�ru girilmi� mi diye kontrol ediyoruz, e�er do�ru ise formumuza i�lemleri yapt�raca��z.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
db_baglan ($db_server, $db_username, $db_userpass, $db_name);	
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$e_mail = mysql_real_escape_string($e_mail);
$guvenlik = mysql_real_escape_string($guvenlik);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');
//Veritaban�ndan arama yap�yoruz, e�er girilen mail adresi veritaban�nda yer alm�yorsa hata verdiriyoruz.
$mail_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail'", $baglanti_pointer);
$mail_kontrol_sonucu = mysql_num_rows($mail_kontrol);
if ($mail_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz e-posta adresi kay�tl� de�ildir.</font><br><br>';
echo '<a href="kayit_ol.php">Kay�t Ol</a></b></center>';
exit;
}
else {
}
//Gelen bilgilerin veritaban�ndan do�rulu�unu kontrol ediyoruz.
$bilgi_kontrol = mysql_query("select * from uyeler where e_mail='$e_mail' and aktiflik='pasif'", $baglanti_pointer);
$bilgi_kontrol_sonucu = mysql_num_rows($bilgi_kontrol);
if ($bilgi_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">�yeli�inizi daha �nce zaten aktifle�tirmi�siniz. Tekrar aktivasyon i�lemi yapman�za gerek yok.</font><br><br>';
echo '<a href="index.php">Anasayfaya D�n</a></b></center>';
exit;
}
else {
}
//Kullan�c� �ifresini ve g�venlik kodunu veritaban�na g�venlik kaydedilmeleri i�in �ifreliyoruz.
$sifrelenmis_guvenlik = sha1($guvenlik);
//Kullan�c�y� veritaban�nda aktif konumuna getirip aktivasyon i�lemini yap�yoruz.
$guvenlik_guncelle = mysql_query ("update uyeler set guvenlik_kodu='$sifrelenmis_guvenlik' where e_mail='$e_mail'", $baglanti_pointer);
//��lemlerin sonucunda bir yaz� yazd�r�yoruz.
if ($guvenlik_guncelle){
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �yeli�iniz aktif edilemedi l�tfen mailinize gelen ba�lant�yla yeniden deneyin, bu i�e yaramazsa yeniden aktivasyon maili istemek i�in a�a��daki ba�lant�y� izleyin:<br><br>';
echo '<a href="aktivasyon.php">Yeniden Aktivasyon</a></font></b></center>';
}
//�yemize mail atarak aktivasyon kodunu kendisine bildiriyoruz.
//Mail atma ba�lang�c�:
//Mail'de ataca��m�z yeni �ifre linkini de hemen a�a��da haz�rl�yoruz.
$sayfa = $_SERVER['REQUEST_URI'];
$aktivasyon_sayfasi = "http://".$_SERVER['HTTP_HOST'].str_replace("tekrar_aktivasyon.php","aktivasyon.php",$sayfa)."?e_mail="."$e_mail"."&guvenlik_kodu="."$guvenlik";

$kime = "$e_mail";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Say�n '."$kullanici_adi".', tekrar aktivasyon iste�iniz �zerine bu maili alm�� bulunuyorsunuz. �u ba�lant�dan �yeli�inizi aktif edebilirsiniz :'.'<a href="'."$aktivasyon_sayfasi".'">'."$aktivasyon_sayfasi".'</a>'.'</p><p>'."$site_adi".' Y�netimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Geli�tirici Tak�m�</b>n�n <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> �zerinden g�nderilmi�tir.</font><br><br>';
$son_konu = "Tekrar Aktivasyon ��lemi";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">�yeli�inizi son ad�m olarak aktifle�tirip tamamlaman�z i�in mail adresinize mail g�nderildi. L�tfen gelen kutunuzu kontrol edin ve mail i�eri�indeki y�nergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun olu�tu ve aktivasyon i�in mail g�nderilemedi (Bu sorun localhostta �al��t�r�lmadan ya da host ile ilgili olabilir l�tfen web alan� sa�lay�c�n�z ile ileti�ime ge�in).</font></center><br>';
}
//Mail atma sonu. 
//Mysql ba�lant�m�z� kapat�yoruz.
mysql_close ();
//40. sat�rdaki if g�venlik kodunun kapat�c�s� a�a��dad�r.
}
else {
echo '<br><center><b><font face="verdana" size="2" color="red">G�venlik i�in girdi�iniz karakterler ile verilenler e�le�miyor.</font><br><br>';
echo '<a href="aktivasyon.php">Geri D�n</a></b></center>';
exit;
}
include ("footer.php");
?>
</body>
</html>

