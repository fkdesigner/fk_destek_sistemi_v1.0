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
<title><?php echo "$site_adi"." - "."DESTEK B�LET� ARA"; ?></title>
</head>
<body>
<?php
//Oturumu ba�lat�yoruz.
@session_start();
//Admin giri� yapm�� m� diye kontrol ediyoruz, giri� yap�lmam��sa giri� sayfas�na y�nlendiriyoruz.
if(isset($_SESSION['kullanici'])){
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
?>
<b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Destek Bileti Ara:</font></b><br /><br />
<i><font face="verdana" size="1" color="#666666">G�rmek istedi�iniz destek biletinin numaras�n� yazarak bulabilirsiniz.</font></i>
<form id="form1" name="form1" method="post" action="">
  <input type="text" name="destek_bileti" />
  <input type="submit" name="ara" value="Ara" />
</form>
<?php
//E�ER FORM G�NDER�LM�� �SE A�A�IDAK� ��LEMLER UYGULANACAKTIR.
if (isset($_POST["ara"])) {
//Formdan gelen bilgileri al�yoruz;
$bilet_no = $_POST['destek_bileti'];
//Verilerde html ya da herhangi bir zararl� kod bulunmamas� i�in g�venlik fonksiyonumuzla kontrol ediyoruz.
guvenlik_filtresi($bilet_no);
//Verileri kontrol ediyoruz tekrar, sql kodu i�eriyorlarsa temizliyoruz.
$bilet_no = mysql_real_escape_string($bilet_no);
//Numara kontrol� sadece say�lar m� de�il mi diye;
if (eregi ("^[0-9]{1,}$", $bilet_no, $bilet_no)){
$bilet_no = $bilet_no[0];
}
else {
echo "<br><br><br><center><font face='verdana' size='2' color='red'><b>L�tfen sadece aramak istedi�iniz destek biletinizin numaras�n� girin.</b></font></center>";
exit;
}
//Veritaban�ndan o numaray� aray�p bileti ��kart�ca��z.
//Listeleme i�in se�ilen veriler.
$tickets = mysql_query("select * from tickets where no='$bilet_no'", $baglanti_pointer);
//Bilet varm� yok mu kontrol ediyoruz.
$tickets_kontrol_sonucu = mysql_num_rows($tickets);
if ($tickets_kontrol_sonucu == 0){
echo '<br><center><b><font face="verdana" size="2" color="red">Bilet bulunamad�.</font><br><br></b></center>';
exit;
}
//VER�LER� YAZDIRMA:
//Tablo olu�turuluyor.
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
	<br>";  
	$bilet_no = $ticket['no'];
}
echo "</table></center>";

//Ticketa verilen cevap say�s� bulunup alta yazd�r�lacak.
@$cevaplar = mysql_query("select * from cevaplar where ticket_id='$bilet_no'", $baglanti_pointer);
$toplam_cevap = mysql_num_rows($cevaplar);
echo "<br><center><font face='verdana' size='2' color='black'>Destek biletiniz ile ilgili toplam ".$toplam_cevap." adet cevap bulunuyor. Ayr�nt� i�in destek biletlerim sayfan�za bakabilirsiniz.</font></center>";

//43. sat�rdaki form g�nderilme kodunun kapatma i�areti a�a��dad�r.
}
//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
?>
</body>
</html>
