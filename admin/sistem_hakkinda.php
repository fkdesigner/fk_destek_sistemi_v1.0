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
<title><?php echo "$site_adi"." - "."Sistem Hakk�nda"; ?></title>
<style type="text/css">
<!--
.style1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.style2 {
	font-size: 14px;
	font-weight: bold;
	color: #000099;
}
.style3 {color: #FF0000}
.style4 {color: #0000FF}
.style5 {color: #333333}
.style6 {color: #00FFFF}
.style8 {font-size: 14px; font-weight: bold; color: #006600; }
.style9 {font-size: 14px; font-weight: bold; color: #FF0000; }
-->
</style>
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
?> 
<span class="style1"><span class="style2">FK Destek Sistemi</span><br />
<br />
FK Destek Sistemi, size �zel olarak 0'dan kodlanm�� bir destek y�netim sistemidir. Oyun sunucular�nda, elektronik ma�azalarda, e-�irketlerin web sitelerinde ve �e�itli yerlerde destek sitesi ama�l� kullan�lmak i�in ve destek bileti sistemi (ticket system) d���n�lerek yap�lm��t�r. Yap�m� F�rat Koyuncu (FK Designer)'ya aittir.<br />
<br />
<span class="style9">FK Destek Sistemi 1.0 (S�n�rl� S�r�m):</span><br />
Sizin �u anda kulland���n�z s�r�m budur. FK Destek Sistemi ilk olarak 1.0 versiyonuyla ��kart�ld�. Versiyon �zerinde denemeler, beta ve stress testleri ile a��k ve g�venlik testleri yap�larak geli�tirmeye �al��t�k. Sonu� itibariyle s�n�rl� s�r�m� olu�turacak olan 1.0 s�r�m�n� ��kartt�k. Ama �unu bildirmeliyiz ki s�n�rs�z s�r�m her zaman bir ad�m daha �nde olacakt�r. S�n�rl� s�r�m yaln�zca HTML ve PHP kullan�larak yap�lm��t�r. S�n�rs�z s�r�mde kullanmay� d���nd���m�z �zelliklerin bir �o�u buraya eklenmemi�tir. Bu s�r�m yaln�zca tan�t�m ve temel testler i�in yap�lm��t�r ve yine bu s�r�m a��k kaynak kodlu olarak da��t�lacakt�r. Bu s�r�m� yaln�zca g�venlik gibi �nemli a��k, sorun ya da g�ncelleme gerekti�i takdirde g�ncelleyip geli�tirece�iz. Dolay�s�yla s�r�m muhtemelen 1.x versiyonlar�yla devam edecektir.
<br />
<br />
<span class="style8">FK Destek Sistemi 2.0 (S�n�rs�z S�r�m):</span><br />
Bu sistem tak�m�m�z�n �zel olarak oturup tasarlad��� ve 1.0'� em�lat�r gibi kullanarak %45'inin �zerine in�aa etti�i �zel bir sistemdir.Temelinden (1.0) farkl� olarak bu s�r�m HTML ve PHP d���nda JAVA ve PHOTOSHOP kullan�larak h�zland�r�lm��t�r. Yine bu s�r�mde g�rsellik tamamen �n plana ��kart�lm�� ve g�venlik seviyesi olduk�a artt�r�lm��t�r. Bu s�r�m tak�m�m�z�n alternatif ve ho� fikirleri ile �e�itli s�r�mlerde geli�tirilece�i gibi bu s�r�me sahip herkese de teknik destek verilecektir. 1.0'da olmayan ve as�l y�netim amac�yla kullanmak i�in arad���n�z �zellikler tamamen 2.0 �zerinde bulunmaktad�r. S�n�rs�z s�r�m� yaln�zca bizden isteyin l�tfen. Ve bu s�r�m�n bizden ba�ka bir yerde a��k/kapal� bir �ekilde da��t�lmas�, kopyalanmas�, belli i�eri�inin al�nmas� yasakt�r.<br />
<br />
�stteki yaz�lar�n her ikisi de yaz�l�rken 1.0 s�r�m� hen�z bitmemi�ti, bu y�zden ikisi hakk�nda ger�ekten ayr�nt�l� bilgi almak i�in web sitemizi ya da S�n�rs�z S�r�m 2.0'�n y�netim panelini ziyaret edin.<br />
<br />
<strong><span class="style3">FK</span> <span class="style4">Designer</span><br />
</strong><span class="style5">Web Geli�tirme Tak�m� </span><strong><br />
F�rat Koyuncu</strong> <strong>(Tak�m Lideri)<br />
<span class="style3">Web:</span> <a href="http://www.fkdesigner.com">http://www.fkdesigner.com</a><br />
<span class="style4">Facebook:</span> <a href="http://www.facebook.com/fkdesigner">http://www.facebook.com/fkdesigner</a><br />
<span class="style6">Twitter:</span> <a href="http://www.twitter.com/fkdesigner">http://www.twitter.com/fkdesigner</a></strong><br />
<strong><em><br />
L�tfen kendimizi ve sistemlerimizi geli�tirebilmemiz i�in bize kullan�m�n�z sonucu geri bildirim yap�n. Te�ekk�r ederiz. </em></strong></span>
</body>
</html>
