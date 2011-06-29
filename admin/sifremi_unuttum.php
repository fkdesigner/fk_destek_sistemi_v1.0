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
?>
<title><?php echo "$site_adi"." - "."�ifremi Unuttum"; ?></title>
</head>
<body>
<?php
//E�ER FORM G�NDER�LM�� �SE A�A�IDAK� ��LEMLER UYGULANACAKTIR.
if (isset($_POST["guvenlik"])) {
//Girilen de�erleri formdan �ekip de�i�kenlere kaydediyoruz.
$email = $_POST['email'];
$guvenlik = $_POST['guvenlik'];
//Formdan gelen verilerin bo� olmamas� i�in kontrol ediyoruz.
$email_hata = "e-posta adresi";
$guvenlik_hata = "guvenlik";
$link = "sifremi_unuttum.php";
bosmu_kontrol($email, $email_hata, $link);
bosmu_kontrol($guvenlik, $guvenlik_hata, $link);
//E-mail ve g�venlik kodu bo� de�ilse �imdi de html kodu ya da zararl� bir kod i�ermemesini sa�l�yoruz.
guvenlik_filtresi($email);
guvenlik_filtresi($guvenlik);
//E-Mail ge�erli mi diye kontrol ediyoruz.
$hata ="sifremi_unuttum";
eposta_kontrol($email, $hata);
//Veritaban� ba�lant�m�z� yap�yoruz.
db_baglan($db_server, $db_username, $db_userpass, $db_name);
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="arial" size="3" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');
//Bu kez de verilerin sql kodu i�ermediklerine emin oluyoruz.
$email = mysql_real_escape_string($email);
$guvenlik = mysql_real_escape_string($guvenlik);
//�imdi g�venlik kodu do�ru girilmi� mi diye bir kontrol yap�yoruz, do�ru ise i�lem yap�lacak, de�ilse hata verilecek.
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
//Kullan�c� ad� ve �ifreyi veritaban�ndan sorgulat�yoruz. 
$email_sorgu = mysql_query("select * from yoneticiler where e_mail='$email'", $baglanti_pointer);
//Kullan�c� sorgusunun sonucunu al�yoruz ve uygun i�lemler yapt�r�yoruz.
$email_sorgu_sonucu = mysql_num_rows($email_sorgu);
if ($email_sorgu_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Girdi�iniz e-posta adresi kay�tl� de�il.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri D�n</a></b></center>';
}
else {
while($admin_bilgi = mysql_fetch_array($email_sorgu)) { 
//Veritaban�ndan kullan�c� ad� ve mail bilgilerini �ekip de�i�kenlere kaydediyoruz.. 
$admin_email = $admin_bilgi['e_mail'];
$admin_username = $admin_bilgi['username'];
}
//Girilen g�venlik kodu, �ifrelenerek veritaban�na kaydedilecek ve bir de�i�kene at�lacak.
$guvenlik_kodu = sha1($guvenlik);

$guvenlik_kodu_guncelle = mysql_query ("update yoneticiler set guvenlik_kodu='$guvenlik' where e_mail='$admin_email'", $baglanti_pointer);
//Mail ile at�lacak de�i�kenler ��yle: $admin_email ve $sifre;
//Kullan�c�ya �ifre de�i�tirebilmesi i�in yeni �ifre sayfas�na eri�ebilmesi i�in ona �zel olu�turulmu� link mail ile at�lacak.
//Mail atma ba�lang�c�:
//Mail'de ataca��m�z yeni �ifre linkini de hemen a�a��da haz�rl�yoruz.
$link = $_SERVER['REQUEST_URI'];
$yeni_sifre_linki = "http://".$_SERVER['HTTP_HOST'].str_replace("sifremi_unuttum.php","yeni_sifre.php",$link)."?e_mail="."$admin_email"."&guvenlik_kodu="."$guvenlik";

$kime = "$admin_email";
$basliklar = 'From:'."$site_adi"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";
$son_mesaj .= '<font face="verdana" size="2" color="black"><p>Say�n '."$admin_username".', �ifrenizi unuttu�unuza ve yeni bir tane talep etti�inize dair bir bildirim ald�k. Kendinize �u adresten yeni bir �ifre belirleyebilirsiniz:'."$yeni_sifre_linki".'</p><p>E�er b�yle bir talepte bulunmad�ysan�z bu e-maili �nemsemeyin ve mevcut �ifrenizi kullanmaya devam edin. Te�ekk�rler.</p><p>'."$site_adi".' Y�netimi</font>';
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Bili�im Hizmetleri</b>nin <font face="verdana" size="1" color="blue">FK Destek Sistemi</font> �zerinden g�nderilmi�tir.</font><br><br>';
$son_konu = "�ifre Hat�rlatma Talebiniz";
if (@mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="verdana" size="2" color="green">�ifre de�i�ikli�i talebiniz i�in girdi�iniz mail adresine mail g�nderildi. L�tfen gelen kutunuzu kontrol edin ve mail i�eri�indeki y�nergeleri takip edin.</font><br><br>';
}
else {
echo '<br><center><font face="verdana" size="2" color="red">Bir sorun olu�tu ve �ifre de�i�ikli�i i�in mail g�nderilemedi (Bu sorun localhostta �al��t�r�lmadan ya da host ile ilgili olabilir l�tfen web alan� sa�lay�c�n�z ile ileti�ime ge�in).</font></center><br>';
//Mail atma sonu. 
}
}
}
else {
echo '<center><br><b><font face="verdana" size="2" color="red">Verilen g�venlik kodu ile sizin girdi�iniz karakterler e�le�miyor.</font><br><br>';
echo '<a href="sifremi_unuttum.php">Geri D�n</a></b></center>';
}
//Veritaban� ba�lant�m�z� sonland�r�yoruz.
mysql_close ();
//Buras� son sat�r, en ba�taki if form girilmi�se sat�r�n�n son kapat�c� komutu a�a��dad�r. Buradan sonra form g�nderilmemi�se i�lemleri ba�layacakt�r.
}
else {
//E�ER FORM G�NDER�LMEM��SE O ZAMAN A�A�IDA BO� FORM G�STER�LECEKT�R.
?>
<br /><br /><br /><br /><br />
<table width="439" height="225" border="1" align="center">
  <tr>
    <td valign="top"><br />
	<center>
	<b><font face="Verdana, Arial, Helvetica, sans-serif" size="4" color="#FF0000"><?php echo "$site_adi";?></font><br /></b>
	<i><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#333333"><?php echo "$site_aciklama";?></font></i><br />
	</center><br /><br />
	<form id="form1" method="post" action="<?php echo $_SERVER["SCRIPT_NAME"] ?>">
                      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">�ifreniz e-posta adresinize g�nderilecektir.</font><br /><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">E-Posta Adresiniz : </font>
                        <input type="text" name="email" size="20" maxlength = "25">
                        <br />
                        <br />
                             <font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="grey">A�a��daki g�venlik kodunu, alt�ndaki kutucu�a girin.</font>
                        <br />
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../guvenlik_kodu.php" /><br />
                        <font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#000066">G�venlik Kodu : </font>
						<input type="text" name="guvenlik" size="20" maxlength = "25">
                      </div>
        <blockquote><blockquote><p align="right">
              <input type="submit" value="G�nder">
              </p>
            </blockquote>
          </blockquote>
	</form>	</td>
  </tr>
</table>
<?php
}
include ("../footer.php");
?>
</body>
</html>
