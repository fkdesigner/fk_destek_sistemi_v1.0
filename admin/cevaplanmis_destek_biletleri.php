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
<title><?php echo "$site_adi"." - "."Cevaplanm�� Destek Biletleri"; ?></title>
</head>
<body>
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
echo '<b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FF0000">Bekleyen Destek Biletleri:</font></b><br />';
//Veritaban�na ba�lan�yoruz ve veritaban�m�z� se�iyoruz.
@db_baglan ($db_server, $db_username, $db_userpass, $db_name);
//�nce veritaban� ba�lant� fonksiyonumuzdan hari� file pointer olu�turup, mysql_query i�in kullanaca��z.
$baglanti_pointer = @mysql_connect("$db_server","$db_username","$db_userpass") or die('<br><center><b><font face="verdana" size="2" color="red">Veritaban�na ba�lan�lam�yor, l�tfen veritaban� ile ilgili bilgileri tekrar kontrol edin.</font></b><br><br></center>');	
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
$sayfalik_kayit = 10;
//Toplam kay�t bulunuyor.
$toplam = mysql_query("SELECT * FROM tickets where durum='Kapal�'", $baglanti_pointer);
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
$tickets = mysql_query("select * from tickets where durum='Kapal�' order by no limit $baslangic,$bitis", $baglanti_pointer);
//E�er sayfam�z 1'den b�y�kse o zaman geri linki olu�turup ekrana yazd�r�yoruz. 
if($no>1){
echo '<a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=cevaplanmis&no='.($no-1).'>Geri</a> | ';
}
//For d�ng�s� ile di�er sayfalar�n linkini ekrana yazd�r�yoruz.
//E�er sayfa numaralar�nda eksik ya da fazla varsa (i+1) ile oynanacak.
for($i=0; $i<$toplam_sayfa; $i++){
	if($no == ($i+1)){
	echo ($i+1).' ';
	}
	else{
	echo' <a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=cevaplanmis&no='.($i+1).'>'.($i+1).'</a> ';
	}
}
//E�er toplam sayfam�z �u anda bulundu�umuz sayfan�n bir fazlas�ndan daha fazla ise o zaman ileri linki olu�turuyoruz.
if($toplam_sayfa>$no){
echo'| <a href='.$PHP_SELF.'?sayfa=destek_biletleri&goster=cevaplanmis&no='.($no+1).'>�leri</a>';
}
//VER�LER� YAZDIRMA:
//Tablo olu�turuluyor.
echo '<center><table border="1">';
echo "<tr><td><font face='verdana' size='2' color='red'>&nbsp;Bilet No&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Bilet Sahibi&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Ba�l�k&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>Kategori&nbsp;</font></td><td>&nbsp;<font face='verdana' size='2' color='red'>��lemler&nbsp;</font></td></tr>";
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
	<input type='submit' name='goster' value='G�ster'><input type='submit' name='ac' value='Bileti Yeniden A�'><input type='submit' name='sil' value='Sil'>
	</form>
	</center>
	</td></tr>";
}
echo "</table></center><br>";


//Veritaban� ba�lant�m�z� kapat�yoruz.
mysql_close ();
?>
</body>
</html>
