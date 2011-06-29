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
?>
<title><?php echo "$site_adi"." - "."YARDIM"; ?></title>
</head>
<body>
<p>
  <?php
//Oturumu ba�lat�yoruz.
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
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br><a href="kayit_ol.php">Geri D�n</a></center>');	
//Admin mail adresini �ekiyoruz.
$admin_bilgi = mysql_query('SELECT e_mail FROM yoneticiler', $baglanti_pointer);
$admin_email = @mysql_result($admin_bilgi, 0);
//E�er form g�nderilmi� ise a�a��daki i�lemler uygulanacakt�r.
if (isset($_POST["gonder"])) {
//Formdan gelen bilgileri al�p de�i�kenlere kaydediyoruz.
$admin_email = $_POST['admin_email'];
$web_adress = $_POST['web_adress'];
$surum = $_POST['surum'];
$isim = $_POST['isim'];
$konu = $_POST['konu'];
$mesaj = $_POST['mesaj'];
$guvenlik = $_POST['guvenlik'];
//E�er bilgiler bo� girilmi�se hata verdiriyoruz
$isim_hata = "ad�n�z ve soyad�n�z";
$link = "admin.php?sayfa=yardim";
bosmu_kontrol($isim, $isim_hata, $link);
$konu_hata = "bize hangi konuda mesaj g�nderiyorsunuz";
bosmu_kontrol($konu, $konu_hata, $link);
$mesaj_hata = "mesaj";
bosmu_kontrol($mesaj, $mesaj_hata, $link);
$guvenlik_hata = "g�venlik kodu";
bosmu_kontrol($guvenlik, $guvenlik_hata, $link);
//Burada t�m veriler g�venlik filtresinden ge�iriliyor;
guvenlik_filtresi($isim);
guvenlik_filtresi($mesaj);
guvenlik_filtresi($konu);
guvenlik_filtresi($admin_email);
guvenlik_filtresi($web_adress);
guvenlik_filtresi($surum);
guvenlik_filtresi($guvenlik);
//Burada g�venlik sorusu e�er do�ru cevaplanm��sa mail gidiyor, cevaplanmam��sa hata veriliyor;
if ($guvenlik == $_SESSION["guvenlik_kodu"]){
$kime = 'iletisim@fkdesigner.com';
$basliklar = 'From:'."$admin_email"."\n";
$basliklar .= 'Reply-To:'."$admin_email"."\n";
$basliklar .= 'Content-type: text/html; charset=iso-8859-9'."\n";

$son_mesaj .= '
<b>G�nderenin Bilgileri:</b>
<font color="red">G�nderilen Web Adresi : </font>'."$web_adress".'
<br>
<font color="red">G�nderilen Destek S�r�m� : </font>'."$surum".'
<br>
<font color="red">G�nderen Admin : </font>'."$isim".'
<br>
<font color="red">G�nderen Admin E-Posta Adresi : </font>'."$admin_email".'
<br>
<font color="red">Mesaj Konusu : </font>'."$konu".'
<br>
<font color="red">Mesaj� : </font>';
$son_mesaj .= $mesaj;
$son_mesaj .= '<br><br><font face="verdana" size="1" color="black">Bu e-mail <b><font face="verdana" size="1" color="red">FK</font> <font face="verdana" size="1" color="blue">Designer</font> Bili�im Hizmetleri</b>nin FK �leti�im Mail Sistemi ile g�nderilmi�tir.</font><br><br>';
$son_konu = "FK DESTEK/YARDIM";
if (mail($kime, $son_konu, $son_mesaj, $basliklar)){
echo '<br><center><b><font face="arial" size="4" color="green">Mesaj�n�z iletildi, te�ekk�rler.</font></b></center><br>';
}
else {
echo '<br><center><font face="arial" size="3" color="red">Bir sorun olu�tu ve mesaj g�nderilemedi. L�tfen daha sonra tekrar deneyin.</font></center><br>';
}



}
//if kapat�c� komut.
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
  <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>Ad�n�z ve Soyad�n�z :
  <input type="text" name="isim" />
  </strong></font></label>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Bize Hangi Konuda Mesaj G�nderiyorsunuz : 
        
  </font></strong>
    <select name="konu">
      <option>Soru</option>
      <option>G�r��</option>
      <option>�neri</option>
      <option>�ikayet</option>
      <option>Hata/A��k Bildirimi</option>
    </select>
  </p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><img src="../guvenlik_kodu.php" /></font></strong></p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">G�venlik Kodu :</font></strong> 
    <input type="text" name="guvenlik" />
  </p>
  <p><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Mesaj�n�z :</font> <br />
    </strong><br />
    <textarea name="mesaj" cols="50" rows="5"></textarea>
  </p>
  <p>
    <input name="vazgec" type="reset" id="vazgec" value="Vazge�" />
    <input name="gonder" type="submit" id="gonder" value="G�nder" />
  </p>
</form>
<p>&nbsp;</p>
<?php
}
?>
</body>
</html>
